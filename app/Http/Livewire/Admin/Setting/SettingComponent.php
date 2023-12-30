<?php

namespace App\Http\Livewire\Admin\Setting;

use DB;
use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Setting;
use Livewire\Component;

class SettingComponent extends Component
{
    public $model;
    protected $sysItem;
    protected $sysData;
    protected $sysView;
    protected $rules = [
        'model.page_name' => 'required',
        'model.address' => 'required',
        'model.phone' => 'required',
        'model.email' => 'required',
        'model.website_artile_footer' => 'required',
        'model.website' => 'required',
        'model.website_copy_right' => 'required',
        'model.custom_css' => 'required',
        'model.custom_js' => 'required',
        'model.website_items_perpage' => 'required',
        'model.items_per_page' => 'required',
        'model.copyright' => 'required',
        'model.code_product' => 'required',
        'model.code_customer' => 'required',
        'model.title' => 'required',
        'model.description' => 'required',
        'model.logo' => 'required',
        'model.logo_icon' => 'required',
    ];

    public function render()
    {
        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;

        $this->model = new Setting();
        $this->type = 'setting';

        $data = [
            'admin' => Setting::where('type', 'admin')->get(),
            'website' => Setting::where('type', 'website')->get(),
        ];

        return view($this->view, $data)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }

    public function bindData()
    {
        $data = Setting::all();
        foreach ($this->rules as $key => $value) {
            $key = explode('.', $key);
            $prop = $key[1];

            $model = $data->filter(function ($item) use ($prop) {
                return $item->name == $prop;
            })->first();

            if ($model) {
                $this->model->$prop = $model->val;
            }
        }
    }

    public function saveSettings()
    {
        DB::beginTransaction();

        try {
            $data = $this->model->toArray();

            foreach ($data as $key => $value) {
                $this->model::updateOrCreate([
                    'name' => $key,
                ], [
                    'val' => $value,
                ]);
            }

            $this->emit('notification_update_success');
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }
}
