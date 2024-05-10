<?php

namespace Modules\Interactions\App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Clients\App\Models\Client;
use Illuminate\Support\Facades\Session;
use Modules\Clients\App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Modules\Interactions\App\Models\Interaction;

class InteractionsController extends Controller
{
    public $_aimx = [
        'name' => 'Interactions', // Section name
        'title' => 'Interactions', // Header title
        'description' => 'interactions list',
        'icon' => 'ti ti-transform',
        'color' => 'purple',

        'module' => 'interactions',
        'code' => 'interactions', // List or Porfile main object
        'urlBase' => 'interactions', // URI #1
        'jsFiles' => ['/assets/js/aim-list.js'],
        'cssFiles' => [],
    ];

    public $_listWithRelations = ['contact', 'client'];
    public $_listPerPageDefault = 20;
    public $_listSortModeDefault = "desc";


    public function _initListModel()
    {
        $this->_listModel = new Interaction;
    }

    public function list(Request $request)
    {
        $auth = $this->auth($this->_aimx['module'].".access_".$this->_aimx['code']);
        if (!$auth['ok']) { return $auth['x']; }
        $this->_buildData($request); // Build list data
        $this->_listOnRun();
        $this->page['interactionType'] = Interaction::interactionType();
        return view($this->_aimx['module'] . '::' . $this->_aimx['code'] . '_list', $this->page);
    }

    public function onRefresh($request, $toast=null)
    {
        $auth = $this->auth($this->_aimx['module'].".access_".$this->_aimx['code']);
        if (!$auth['ok']) { return $auth['x']; }
        
        $post = $request->input();

        if (Arr::get($post, 'data.search_original') != Arr::get($post, 'data.search')) {
            $this->_sentToFirstPage = true;
        }

        if (Arr::get($post, 'data.page') || $this->_sentToFirstPage) {
            Session::put($this->_aimx['code'].'_list_page', $this->_sentToFirstPage ? 1 : $post['data']['page']);
        }

        $this->_buildData($request);

        $view = view('list.aim-list-page', 
            [
                'user' => $auth['user'],
                'workspace' => $auth['workspace'],
                'listItems' => $this->_listItems,
                'statistics' => $this->_listStatistics,
                'data' => $this->_data,
                'filters' => $this->_filters,
                'aimx' => $this->_aimx,
                'interactionType' => Interaction::interactionType()
            ])->render();

        return [
            '#aim-list-page' => $view,
            '#aim-toast' => $toast ? $this->toast($toast)['#aim-toast'] : ''
        ];
    }

    public function import(Request $request)
    {

        return view($this->_aimx['module'] . '::' . $this->_aimx['code'] . '_import', $this->page);
    }

    public function profile($id, $tab = "interactions")
    {
        $auth = $this->auth("interactions.access_interactions", function () use ($id) {
            return Interaction::find($id);
        });
        if (!$auth['ok']) {
            return $auth['x'];
        }
        $client = $auth['item'];

        $interactions = Interaction::where('client_id', $client->id)
            ->orderBy('created_at', 'desc');


        $this->_aimx['title'] = $client->title;

        $interactionType = [
            'phone' => ['title' => 'Phone', 'icon' => 'ti ti-phone', 'color' => 'success'],
            'e-mail' => ['title' => 'E-mail', 'icon' => 'ti ti-mail', 'color' => 'secondary'],
            'in_person' => ['title' => 'In Person', 'icon' => 'ti ti-user', 'color' => 'primary'],
        ];
    
        $userList = User::select(['id', 'name'])->get();
        $clientId = $client->id;

        $all = request()->get('all') ?? false;

        foreach ($interactions as $interaction) {
            $interaction->formatted_notes = $this->formatNotes($interaction->notes);
        }

        return view('interactions', [
            'tab' => $tab,
            'clients'=> $clients,
            'aimx' => $this->_aimx,
            'userList' => $userList,
            'interactions' => $interactions,
            'interactionType' => $interactionType,
        ])->render();
    }

    public function onAction(Request $request)
    {
        $clientId = $request->input('client_id');
        $action = $request->input('action');
        $auth = $this->auth("interactions.manage_interactions");
        if (!$auth['ok']) { return $auth['x']; }
        $client = Client::find($clientId);
        if (method_exists($this, "action_" . $action)) {
            return $this->{"action_" . $action}($auth, $request, $client);
        }

        return $this->toast("Action not found!", "warning");

    }


    public function onShowFilters()
    {
        $filters = Session::get($this->_aimx['module'].'_'.$this->_aimx['code'].'_filters', []);
        $contacts = Contact::select('id','title', 'client_id', 'first_name', 'last_name', 'job_title', 'created_at')->get();
        $interactions = Interaction::select('id','contact_id', 'interaction_type', 'rating')->with('contact')->get();
        $contactDate = isset($filters['contacted_at']['like']) ? $filters['contacted_at']['like'] : null;
        $startAt = date("Y-m-d H:i:s");
        $view = view($this->_aimx['module'].'::'.$this->_aimx['code'].'_list_filters', [
            "filters" => $filters,
            "contacts" => $contacts,
            "interactions" => $interactions,
            "startAt" => $startAt
        ])->render();

        return [
            '#aim-filter-body' => $view
        ];
    }
    public function _searchFilterScope($data, $filters)
{
    $filterCount = 0;
    $searchFilters = [];
    foreach ($filters as $filterKey => $filter) {
        if (!empty($filter['like'])) {
            $searchFilters[$filterKey] = ['like', '%' . $filter['like'] . '%'];
            $filterCount++;
        } elseif (!empty($filter['is'])) {
            $searchFilters[$filterKey] = ['=', $filter['is']];
            $filterCount++;
        } elseif (!empty($filter['after'])) {
            $searchFilters[$filterKey] = ['>', $filter['after']];
            $filterCount++;
        } elseif (!empty($filter['before'])) {
            $searchFilters[$filterKey] = ['<', $filter['before']];
            $filterCount++;
        }
    }
    $search = $filterCount > 0 ? "" : $data['search'];
    return [
        "search" => $search,
        "searchFilters" => $searchFilters,
        "filters" => $filters,
        "filterCount" => $filterCount
    ];
}
    
    private function action_get_client_contacts($auth, $request, $client)
    {
       
        $contacts = Contact::where('client_id', $client->id)->get();
        return $contacts;
    }
    
    public function create(Request $request)
    {
        $clients = Client::all();
        
        $interactions = Interaction::all();
        
        return view('interactions::interactions_create', [
            'aimx' => $this->_aimx,
            'interactions' => $interactions,
            'clients' => $clients,
        ]);
    }

   public function action_create_interaction($auth, $request, $client)
    {
        if (!$client) {
            return $this->toast('Client not found!', 'error');
        }
        
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'interaction_type' => 'required',
            'created_at' => 'required',
            'contact_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->toast($validator->errors()->first(), 'error');
        }
        $userId = $auth['user']->id;

        $interaction = new Interaction();
        $interaction->client_id = $client->id;
        $interaction->user_id = $userId;
        $interaction->contact_id = $request->input('contact_id') ?: null;
        $interaction->rating = $request->input('rating');
        $interaction->interaction_type = $request->input('interaction_type');
        $interaction->notes = $request->input('notes');
        $interaction->created_at = $request->input('created_at');
        $interaction->save();

        return $this->redirect('/interactions');
    }
}

