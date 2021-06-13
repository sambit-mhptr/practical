<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends \TCG\Voyager\Models\User
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
      $id = auth()->user()->role_id;
      $a = \DB::table('roles')->where('id', $id)->first()->name;
        if(trim($a) == "super admin" || trim($a) == "admin"){
            return true;
        }
       return false;
    }  

    public function products()
    {
       return $this->hasMany(Product::class);
    }  

    public function categories()
    {
       return $this->hasMany(Category::class);
    } 
}
