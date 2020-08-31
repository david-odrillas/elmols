<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
  protected $fillable = ['quantity','sale_id','unit_id'];
  public function sale()
  {
    return $this->belongsTo('App\Sale');
  }
  public function unit()
  {
    return $this->belongsTo('App\Unit');
  }
  public function wallets()
  {
    return $this->hasMany('App\Wallet');
  }
}
