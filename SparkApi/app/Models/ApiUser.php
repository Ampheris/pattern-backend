<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser create($value)
* @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiUser findOrFail($value)
*/
class ApiUser extends Model
{
    // use HasApiTokens;
    use HasFactory;

    // use Notifiable;
    // use AuthenticableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
        'api_token',
        'requests'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];
}
