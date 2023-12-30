<?php

namespace App\Http\Livewire\Admin;

use App\Models\CodeSerie;
use DB;
use Str;
use URL;
use Hash;
use Schema;
use Storage;
use Exception;
use App\Models\File;
use App\Sys\SysCore;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseComponent extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use WithFileUploads;

    protected $listeners = ['refreshComponent' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    protected $sysItem;
    protected $sysData;
    protected $sysView;
    protected $view;
    protected $masterView;
    protected $sectionView;
    protected $log;
    protected $settings;
    public $type;
    public $limit;
    public $model;
    public $modelTranslation;
    public $object;
    public $translated;
    public $image = 'images/no-image.png';
    public $viewEdit;
    public $viewIndex;
    public $modelID;
    public $temporaryKeyword = null;
    public $keyword = null;
    public $error;
    public $sortBy = 'id';
    public $sortType = 'DESC';
    public $categories = [];
    public $tags = [];
    public $deleteId = null;
    public $searchFields = ['name', 'title'];
    public $storageImagePath = 'storage/upload/images/';

    //files
    protected $files;
    public $photos;
    public $path = 'upload/images';
    public $file_keyword;

    // for select2 render
    public $iteration = 0;

    // is form view
    public $isForm = false;
    public $offForm = false;

    // button exit
    public $exitConfirm = false;
    public $deleteConfirm = [];

    // Permission
    public $create_permission = false;
    public $edit_permission = false;
    public $delete_permission = false;

    /**
     * Method checkPermission
     * check permission before render component
     * @return void
     */
    public function checkPermission(): void
    {
        if (Gate::allows('edit', $this->model)) {
            $this->edit_permission = true;
        }

        if (Gate::allows('create', $this->model)) {
            $this->create_permission = true;
        }

        if (Gate::allows('delete', $this->model)) {
            $this->delete_permission = true;
        }
    }

    /**
     * Method uploadPhotos
     * upload file from detail pages
     * @return void
     */
    public function uploadPhotos(): void
    {
        $this->validate([
            'photos.*' => 'required|max:2048|file|mimes:png,jpg,webp',
        ]);

        $sysCore = new SysCore();

        DB::beginTransaction();

        try {
            if ($this->photos != null && ! empty($this->photos)) {
                collect($this->photos)->each(function ($photo) use($sysCore) {
                    $filename = time() . $sysCore->createFileName($photo->getClientOriginalName());
                    $photo->storeAs($this->path, $filename, 'public');
                    $path = 'storage/' . $this->path . '/' . $filename;

                    // Check file uploaded
                    if (! FacadesFile::exists($path)) {
                        throw new Exception('Đã có lỗi xảy ra!');
                    }

                    // create file info in database
                    File::create([
                        'name' => $filename,
                        'extension' => $photo->getClientOriginalExtension(),
                        'mime' => $photo->getMimeType(),
                        'path' => $path,
                        'fullpath' => URL::to('/') . '/' . $path,
                        'size' => $photo->getSize(),
                        'alt' => $filename,
                    ]);
                });

                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $this->emit('notification_error', $th->getMessage() . ' (Basecomponent:uploadPhotos())');

            //throw $th;
        }

        $this->reset('photos');
    }

    /**
     * Method create
     * execute when user open create form
     * @return void
     */
    public function create(): void
    {
        $this->authorize('create', $this->model);

        $this->object = $this->model;

        if (method_exists($this->model, 'translated')) {
            $this->translated = $this->modelTranslation;
        }

        if (method_exists($this->model, 'getTree')) {
            $this->tree = $this->object->getTree(null, null, $this->type);
        }

        // Khởi chạy các phương thức khi ở trang create
        if (method_exists($this, 'whenCreate')) {
            $this->whenCreate();
        }

        $this->isForm = true;
        $this->emit('isForm');
        $this->iteration++;
    }

    /**
     * Method edit
     * @param $id
     * @return void
     */
    public function edit(int $id): void
    {
        $this->authorize('edit', $this->model);

        $this->object = $this->model::find($id);

        if (method_exists($this->model, 'getTree')) {
            $this->tree = $this->object->getTree(null, null, $this->type);
        }

        $this->image = $this->object->file ? $this->object->file->path : 'images/no-image.png';

        if (method_exists($this->model, 'translated') && isset($this->object->translated)) {
            $this->translated = $this->object->translated;
        }

        // Khởi chạy các phương thức khi ở trang edit
        if (method_exists($this, 'whenEdit')) {
            $this->whenEdit();
        }

        $this->isForm = true;
        $this->emit('change_title', $this->object->name ?? $this->translated->name ?? $this->object->presentation_name);
        $this->emit('isForm');
        $this->iteration++;
    }

    public function settingPage()
    {
        $files = $this->files;
        $sysItem = $this->sysItem;
        $data = Setting::all();

        return view($this->view, compact('data', 'files', 'SysItem'))->extends('backend.main')->section('content');
    }

    public function getFiles()
    {
        $pars = [
            'keyword' => $this->file_keyword ?? null,
            'limit' => 24,
            'sortBy' => 'id',
            'sortType' => 'DESC',
            'searchField' => 'name',
        ];

        return $this->sysData->getData(new File(), $pars);
    }

    public function createOrUpdate($exit = null)
    {
        $this->authorize('edit', $this->model);

        $this->validation();

        $new = $this->object->id == null ? true : false;

        DB::beginTransaction();

        try {
            // hàm này thực hiện trước khi save vào database
            if (method_exists($this, 'beforeSave')) {
                $this->beforeSave();
            }

            $this->saveModel();
            $this->saveRelationship();
            $this->saveTranslated();

            // nếu có xử lý hậu kỳ thì chạy hàm afterSave (được khai báo trong Component chính)
            if (method_exists($this, 'afterSave')) {
                $this->afterSave();
            }

            DB::commit();
            $this->emit('notification_update_success');
        } catch (\Exception $th) {
            DB::rollback();
            $this->emit('notification_error', $th->getMessage() . ' BaseComponent:createOrUpdate()');

            throw $th;
        }

        if ($exit != null) {
            $this->exit();
        }
    }

    public function saveModel()
    {
        /** if field = null, set field = 0 */
        $boolean_fields = [
            'is_active',
            'is_default',
            'is_staff',
            'is_admin',
            'is_customer',
            'price',
            'exported',
            'material',
            'finished',
        ];
        foreach ($boolean_fields as $field) {
            if ($this->hasAttribute($field)) {
                $this->object->$field == null && $this->object->$field = 0;
                /** if is_default = 1, set the order rows is_default = 0 */
                $field == 'is_default' && $this->object->$field == 1 && $this->model::where('is_default', 1)->update(['is_default' => 0]);
            }
        }

        $string_fields = [
            'code', 'slug', 'password',
        ];

        foreach ($string_fields as $field) {
            if ($this->hasAttribute($field)) {
                if ($this->object->$field == null) {
                    // makde Code
                    $codeSerie = new CodeSerie();
                    $field == 'code' && $this->object->code = $codeSerie->makeCode($this->object);
                    $field == 'slug' && $this->object->slug = Str::slug($this->object->name);
                }

                $field == 'password' && $this->password != null && $this->object->password = Hash::make($this->password);
            }
        }

        $nullable_fields = [
            'parent_id',
            'category_id',
        ];

        foreach ($nullable_fields as $field) {
            if ($this->hasAttribute($field) && $this->object->$field == '') {
                $this->object->$field = null;
            }
        }

        if (method_exists($this->object, 'file')) {
            $this->storeImageFromExternal();
        }

        $this->object->save();
        $this->object->touch();
    }

    public function saveTranslated()
    {
        // translation save
        if ($this->translated) {
            $this->translated->locale = Config::get('app.locale');

            if ($this->hasAttribute('slug', $this->translated)) {
                $this->translated->slug = Str::slug($this->translated->name);
            }

            // if ($this->hasAttribute('image', $this->translated)) {
            //     $this->storeImageFromExternal($this->translated);
            // }

            if ($this->hasAttribute('title', $this->translated) && $this->translated->title == null) {
                $this->translated->title = $this->translated->name;
            }

            $this->object->translated()->save($this->translated);
        }
    }

    public function saveRelationship()
    {
        if (method_exists($this->object, 'categories') && count($this->categories) > 0) {
            $this->object->categories()->sync($this->categories);
        }

        if (method_exists($this->object, 'tags')) {
            $this->object->tags()->sync($this->tags);
        }
    }

    public function storeImageFromExternal()
    {
        if ($this->image != '' && $this->image != null) {
            $checkUrl = Str::contains($this->image, ['http://', 'https://']);

            if ($checkUrl) {
                // store image to Storage
                $url = $this->image;
                $content = file_get_contents($url);
                $name = substr($url, strrpos($url, '/') + 1);
                $path = 'public/upload/images/' . $name;
                Storage::put($path, $content);

                // store image info to Database
                $fileData['name'] = $name;
                $fileData['size'] = filesize(Storage::path($path));
                $fileData['extension'] = pathinfo(Storage::path($path))['extension'];
                $fileData['mime'] = FacadesFile::mimeType(Storage::path($path));
                $fileData['path'] = $this->storageImagePath . $name;

                // for FE or external use
                $fileData['fullpath'] = URL::to('/') . '/' . $fileData['path'];
                $file = File::create($fileData);

                $this->object->file_id = $file->id;
            }
        }
    }

    public function setImage($filepath, $field = 'image', $idModal)
    {
        if (! method_exists($this->model, 'translated')) {
            $this->model->$field = $filepath;
        } else {
            $this->translated->image = $filepath;
        }

        $this->emit('closeModal', $idModal);
    }

    public function removeImage()
    {
        $this->image = 'images/no-image.png';
    }

    public function setFile($file_id, $field, $path)
    {
        $this->object->$field = $file_id;
        $this->image = $path;
    }
    
    /**
     * Method updatingKeyword
     * reset page data/layout when keyword updating
     * ex: pagination
     * @return void
     */
    public function updatingKeyword()
    {
        $this->resetPage();
    }

    public function updating()
    {
        $this->resetPage();
    }
    
    /**
     * Method hasAttribute
     *
     * @param string $column 
     * @param object $model 
     *
     * @return bool
     */
    public function hasAttribute($column, $model = null): bool
    {
        try {
            return Schema::hasColumn($model == null ? $this->model->getTable() : $model->getTable(), $column);
        } catch (\Throwable $th) {
            return false;
        }
    }
    
    /**
     * Method validation
     *
     * @return void
     */
    public function validation()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->emit('notification_error');
            $this->validate();
        }
    }
    
    /**
     * Method exitConfirm
     *
     * @param $confirm
     *
     * @return void
     */
    public function exitConfirm($confirm)
    {
        $this->exitConfirm = true;
        if ($confirm == true) {
            $this->exit();
        }
    }

    public function exit()
    {
        $this->object = $this->model;
        $this->resetValues();
        $this->dispatchBrowserEvent('offForm');
    }

    public function deleteConfirm($id)
    {
        $this->deleteConfirm[$id] = true;
    }

    public function delete($id)
    {
        $this->authorize('delete', $this->model);

        $entity = $this->model::find($id);
        $check = true;
        if (method_exists($entity, 'checkBeforeDelete')) {
            $check = $entity->checkBeforeDelete();
        }

        DB::beginTransaction();

        try {
            if ($check !== true) {
                throw new Exception($check);
            }

            $entity::destroy($id);

            DB::commit();
            $this->emit('notification_delete_success');
        } catch (\Throwable $th) {
            
            DB::rollBack();
            $this->emit('notification_error', $th->getMessage());
        }
    }

    public function resetValues()
    {
        $this->reset('isForm', 'exitConfirm', 'image');
    }
}
