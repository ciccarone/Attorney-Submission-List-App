<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
  protected $table = 'statuses';

  public function retrieve_all_statuses()
  {
    $statuses = Status::all();
    foreach ($statuses as $key => $value) {
      $ret[$value->id] = ucwords($value->name);
    }
    return $ret;
  }
}
