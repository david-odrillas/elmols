<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  protected $fillable =['amount', 'payment', 'change'];
  public function details()
  {
    return $this->hasMany('App\Detail');
  }
  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
