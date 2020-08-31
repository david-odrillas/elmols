<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $fillable = ['volumen', 'price', 'sponsor', 'supsponsor'];

    public function product()
    {
      return $this->belongsTo('App\Product');
    }
    public function details()
    {
      return $this->hasMany('App\Detail');
    }
    public function setVolumenAttribute($value)
    {
      $this->attributes['volumen'] = strtoupper($value);
    }
}
