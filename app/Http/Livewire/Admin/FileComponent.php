<?php

namespace App\Http\Livewire\Admin;

use File;
use App\Sys\SysView;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\File as ModelsFile;
use App\Sys\SysCore;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Str;

class FileComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $path = 'upload/images';
    public $photos = [];
    public $keyword;
    public $model;
    protected $sysView;
    protected $listeners = ['refreshComponent' => '$refresh'];
    protected $paginationTheme = 'bootstrap';
    public $deleteConfirm = [];

    public function render()
    {
        $this->sysView = new SysView();
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;

        $data = ModelsFile::where('name', 'like', '%' . $this->keyword . '%')->latest()->paginate(24);

        return view('livewire.admin.file.index', compact('data'))
            ->extends($this->masterView)
            ->section($this->sectionView);
    }

    public function save()
    {
        $this->validate([
            'photos.*' => 'required|max:2048|file|mimes:png,jpg,webp',
        ]);

        $sysCore = new SysCore();

        DB::beginTransaction();

        try {
            if ($this->photos != null && !empty($this->photos)) {
                collect($this->photos)->each(function ($photo) use ($sysCore) {
                    $filename = time() . '_' .$sysCore->createFileName($photo->getClientOriginalName());
                    $photo->storeAs($this->path, $filename, 'public');
                    $path = 'storage/' . $this->path . '/' . $filename;

                    // Check file uploaded
                    if (!File::exists($path)) {
                        throw new Exception('Đã có lỗi xảy ra!');
                    }

                    // create file info in database
                    ModelsFile::create([
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
            DB::rollBack();

            $this->emit('notification_error', $th->getMessage() . ' (FileComponent:save())');
            //throw $th;
        }

        $this->reset('photos');
    }

    public function getFile($id)
    {
        $this->model = ModelsFile::find($id)->toArray();
    }

    public function deleteConfirm($id)
    {
        $this->deleteConfirm[$id] = true;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $file = ModelsFile::find($id);
            ModelsFile::destroy($id);
            File::delete($file->path);

            DB::commit();

            $this->emit('notification_delete_success');
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->emit('notification_error', $th->getMessage());
        }
    }
}
