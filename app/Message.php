<?php

namespace App;

class Message
{
  public static function danger($model)
  {
    return session()->flash('message', [
        'bg' => 'bg-danger',
        'text' => $model." correctamente"
    ]);
  }
  public static function success($model)
  {
    return session()->flash('message', [
        'bg' => 'bg-success',
        'text' => $model. ' correctamente'
    ]);
  }
  public static function info($model)
  {
    return session()->flash('message', [
        'bg' => 'bg-info',
        'text' =>$model.' correctamente'
    ]);
  }
}
