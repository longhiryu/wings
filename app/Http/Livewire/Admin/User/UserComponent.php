<?php

namespace App\Http\Livewire\Admin\User;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Http\Livewire\Admin\BaseComponent;
use App\Models\Setting;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserComponent extends BaseComponent
{
    use AuthorizesRequests;

    public $password;
    public $password_confirmation;

    public function rules()
    {
        $rules = [
            'object.id' => 'nullable',
            'object.name' => 'required|string|max:255',
            'object.email' => 'required',
            'object.is_active' => 'nullable',
            'object.is_admin' => 'nullable',
            'object.is_staff' => 'nullable',
            'object.is_customer' => 'nullable',
            'object.phone' => 'nullable',
            'object.address' => 'nullable',
            'object.IDNo' => 'nullable',
            'object.note' => 'nullable',
            'object.user_group_id' => 'nullable',
        ];
        
        //create
        if (isset($this->object) && $this->object->id == null) {
            $rules['password'] = 'required|confirmed';
            $rules['password_confirmation'] = 'required';
        }
        // update
        elseif($this->password != null){
            $rules['password'] = 'required|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        return $rules;
    }

    public function render()
    {
        $this->authorize('index', new User());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new User();
        $this->type = 'user';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => collect($this->searchFields)->first(),
            'keyword' => $this->keyword,
            'sortBy' => $this->sortBy,
            'sortType' => $this->sortType,
            'limit' => $this->limit,
        ];

        $data = $this->sysData->getData($this->model, $pars);

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }
}
