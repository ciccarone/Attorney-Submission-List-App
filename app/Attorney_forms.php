<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attorney_forms extends Model
{
  protected $table = 'attorney_forms';

  static public function retrieve_attorneys_forms($id)
  {
    $forms = Attorney_forms::where('attorney_id', $id)->get();
    return $forms;
  }
}
