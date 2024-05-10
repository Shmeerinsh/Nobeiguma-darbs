<?php

namespace Modules\Interactions\App\Models;

use App\Classes\AimModel;
use Modules\Clients\App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Modules\Contacts\App\Models\Contact;
use Modules\Interactions\App\Models\Interactions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Interactions\Database\factories\InteractionFactory;

class Interaction extends Model
{
    use HasFactory, AimModel;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    protected static function newFactory(): InteractionFactory
    {
        //return InteractionFactory::new();
    }

    public static function interactionType()
    {
        return [
            'phone' => ['title' => 'Phone', 'icon' => 'ti ti-phone', 'color' => 'success'],
            'e-mail' => ['title' => 'E-mail', 'icon' => 'ti ti-mail', 'color' => 'secondary'],
            'in_person' => ['title' => 'In Person', 'icon' => 'ti ti-user', 'color' => 'primary'],
        ];
    }

}
