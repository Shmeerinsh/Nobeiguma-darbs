<?php

namespace Modules\Contacts\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Clients\App\Models\Client;
use Illuminate\Support\Facades\Session;
use Modules\Contacts\App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{

    public $_aimx = [
        'name' => 'Contacts', // Section name
        'title' => 'Contacts', // Header title
        'description' => 'contact list',
        'icon' => 'ti ti-briefcase',
        'color' => 'purple',

        'module' => 'contacts',
        'code' => 'contacts', // List or Porfile main object
        'urlBase' => 'contacts', // URI #1
        'jsFiles' => ['/assets/js/aim-list.js'],
        'cssFiles' => [],
    ];

    public $_listPerPageDefault = 30;
    public $_listSortModeDefault = "desc";


    public function _initListModel()
    {
        $this->_listModel = new Contact;
    }

    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        $auth = $this->auth($this->_aimx['module'].".access_".$this->_aimx['code']);
        if (!$auth['ok']) { return $auth['x']; }
        $this->_buildData($request); // Build list data
        $this->_listOnRun();

        return view($this->_aimx['module'] . '::' . $this->_aimx['code'] . '_list', $this->page);
    }

    public function onAction(Request $request)
    {
        $action = $request->input('action');
        $auth = $this->auth("contacts.manage_contacts");
        if (!$auth['ok']) { return $auth['x']; }
        if (method_exists($this, "action_" . $action)) {
            return $this->{"action_" . $action}($auth, $request->input());
        }

        return $this->toast("Action not found!", "warning");

    }

    public function create(Request $request)
    {
        $auth = $this->auth($this->_aimx['module'].".manage_".$this->_aimx['code']);
        if (!$auth['ok']) { return $auth['x']; }
        $this->_buildData($request); // Build list data
        $this->_listOnRun();

        return view($this->_aimx['module'] . '::' . $this->_aimx['code'] . '_create', $this->page);
    }

    public function onShowFilters()
    {
        $filters = Session::get($this->_aimx['module'].'_'.$this->_aimx['code'].'_filters', []);
        $clients = Client::select('id', 'title')->get();
        $contacts = Contact::select('created_at')->get();
        $contactDate = isset($filters['contacted_at']['like']) ? $filters['contacted_at']['like'] : null;
        $startAt = date("Y-m-d H:i:s");
        $view = view($this->_aimx['module'].'::'.$this->_aimx['code'].'_list_filters', [
            "filters" => $filters,
            "clients" => $clients,
            "contacts" => $contacts,
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

public function action_create_contact($auth, $request)
{
    $validator = Validator::make($request, [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
    ]);
    
    if ($validator->fails()) {
        return $this->toast($validator->errors()->first(), 'error');
    }
    
    $userId = $auth['user']->id;

    $contact = new Contact();
    
    $contact->first_name = $request['first_name'];
    $contact->last_name = $request['last_name'];
    $contact->phone = $request['phone'];
    $contact->email = $request['email'];
    
    $contact->save();

    return $this->redirect('/contacts');
}

}
