<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateLabelRequest;
use App\Http\Requests\Admin\UpdateLabelRequest;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends BaseController
{
    public function __construct()
    {  
        $this->model = new Label();
        parent::__construct();
        
    }
  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLabelRequest $request)
    {
        $data = $request->all();
        // dd($data);       
        return $this->insert_data($data);
    } 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLabelRequest $request, Label $label)
    {  
        return $this->insert_data($request, $label);
    }
    
}
