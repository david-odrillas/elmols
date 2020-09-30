<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
  use SoftDeletes;
  protected $fillable = ['user_id', 'amount', 'detail_id'];
  public function detail()
  {
    return $this->belongsTo('App\Detail');
  }
  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
