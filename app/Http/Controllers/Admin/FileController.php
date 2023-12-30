<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File as ModelFile;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class FileController extends BaseController
{
    protected $quotation_key;

    public function __construct()
    {
        $this->model = new ModelFile();  


        parent::__construct();
    }

    public function store(Request $request)
    {       
        // dd($request);
        $this->upload($request);

        return redirect()->route('file.index');
    }

    public function update(Request $request, ModelFile $file)
    {

        $this->upload($request,'/upload_data/',$file);

        return redirect()->route('file.edit',$file->id);
    }

    public function upload($request,$path = '/upload_data/',$entity = null)
    {

        if ($request->hasFile('fileToUpload')) {
            $file = $request->file('fileToUpload');

            // Create File record
            $file_data['name'] = $file->getClientOriginalName();
            $file_data['extension'] = $file->getClientOriginalExtension();
            $file_data['mime'] = $file->getMimeType();
            $file_data['path'] = $path. $file->getClientOriginalName();
            $file_data['size'] = $file->getSize();
            if(!$entity){
                ModelFile::create($file_data);
            }else{
                //delete file exist -> url
                // dd($entity->path);
                File::delete(asset($entity->path));
                $entity->update($file_data);
            }

            // upload file
            $file->move(public_path() . '/upload_data/', $file->getClientOriginalName());
        }
    }
}
