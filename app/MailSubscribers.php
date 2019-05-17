<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Notifications\Notifiable;

class MailSubscribers extends Model
{

    use Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email',
    ];

}
