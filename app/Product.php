<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use SoftDeletes;

  protected $fillable = ['name'];

  public function units()
  {
    return $this->hasMany('App\Unit');
  }
  public function setNameAttribute($value)
  {
    $this->attributes['name'] = strtoupper($value);
  }
  public function scopeName($query, $name)
  {
    if($name) return $query->where('name','LIKE',"%$name%");
  }
}
