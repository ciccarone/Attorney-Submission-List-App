<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
  protected $table = 'forms';

  public function retrieve_all_forms()
  {
    $forms = Form::all();
    foreach ($forms as $key => $value) {
      $ret[$value->file_slug] = $value->id;
    }
    return $ret;
  }

  public function retrieve_all_forms_full()
  {
    $forms = Form::all();
    return $forms;
  }
}
