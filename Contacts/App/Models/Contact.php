<?php

namespace Modules\Contacts\App\Models;

use App\Classes\AimModel;
use Modules\Clients\App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Contacts\Database\factories\ContactFactory;

class Contact extends Model
{
    use HasFactory, AimModel;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    
    protected static function newFactory(): ContactFactory
    {
        //return ContactFactory::new();
    }
}
