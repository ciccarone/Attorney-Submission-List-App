<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Http\Request;

class Attorney extends Model
{
  protected $table = 'attorneys';
  protected $guarded = [];
  use SoftDeletes;

  static public function retrieve_all_attorneys($args, $single = false)
  {
    if (!$args) {
      $attorney = Attorney::all();
    } elseif ($single) {
      $attorney = Attorney::where($args)
                 ->first();
    } else {
      $attorney = Attorney::where($args)
                ->orderBy('id', 'desc')
                ->get();
    }
    return $attorney;
  }

  static public function search_attorneys($keyword)
  {

    $attorney = Attorney::where(function($query) use ($keyword)
    {
        $query->where('semper_contact', 'like', '%' . $keyword . '%');
        $query->orWhere('semper_contact_email', 'like', '%' . $keyword . '%');
        $query->orWhere('company_name', 'like', '%' . $keyword . '%');
        $query->orWhere('company_contact_name', 'like', '%' . $keyword . '%');
        $query->orWhere('email', 'like', '%' . $keyword . '%');
    })
    ->where('status_id', '=', '2')->get();

    return $attorney;
  }

  static public function retrieve_attorney_name($id)
  {
    $attorney = Attorney::find($id);
    return str_slug($attorney->company_name);
  }

  static public function update_attorney_record($request, $fields, $status)
  {

    // Attorney::find($request->id)->update(Request::all());
    $attorney = Attorney::find($request->id);
    foreach ($fields as $key => $value) {
      $attorney->$key = $request->$key;
    }
    foreach ($status as $key => $value) {
      $attorney->$key = $request->$key;
    }
    $attorney->save();
    // var_dump($fields);
  }
}
