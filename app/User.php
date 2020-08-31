<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'ci', 'cell', 'email', 'password', 'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function users()
    {
      return $this->hasMany('App\User');
    }
    public function setNameAttribute($value)
    {
      $this->attributes['name'] = strtoupper($value);
    }
    public function scopeName($query, $name)
    {
      if($name) return $query->where('name','LIKE',"%$name%");
    }
    //relacion con ventas
    public function sales()
    {
      return $this->hasMany('App\Sale');
    }
    //relacion con patrocinador.
    public function sponsor()
    {
      return $this->belongsTo('App\User', 'user_id');
    }
    //relacion con wallets
    public function wallets()
    {
      return $this->hasMany('App\Wallet');
    }
}
