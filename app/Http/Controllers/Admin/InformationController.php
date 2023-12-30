<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class InformationController extends Controller
{
    public function show()
    {
      // Read File
      $path = base_path('resources/views/backend/data/info_'.Config::get('app.locale').'.json');
      $jsonString = file_get_contents($path);
      $data = json_decode($jsonString, true);
      $data = (object) $data;
    
      return view('backend/layouts/info/edit',compact('data'));
    }

    public function save(Request $request)
    {
      // Write File
      $data = $request->except('_token','_method');
      $path = base_path('resources/views/backend/data/info_'.Config::get('app.locale').'.json');
      foreach($data as $key => &$item){
        $data[$key] =  addslashes(preg_replace("!\r?\n!", "", $item));
      }
      $newJsonString = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
      file_put_contents($path, stripslashes($newJsonString));

      return back();
    }
}
