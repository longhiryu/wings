<?php

namespace App\Http\Livewire\Admin\UserGroup;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Setting;
use App\Models\UserGroup;
use App\Http\Livewire\Admin\BaseComponent;
use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserGroupComponent extends BaseComponent
{
    use AuthorizesRequests;

    public function rules()
    {
        $rules = [
            'object.id' => 'nullable',
            'object.name' => 'required|string|max:255',
            'object.slug' => 'nullable',
            'object.is_active' => 'nullable',
        ];

        return $rules;
    }

    public function render()
    {
        $this->authorize('index', new UserGroup());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new UserGroup();
        $this->type = 'usergroup';
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
        $permissions = Permission::all();
        $groups = $permissions->groupBy('type');
        if (optional($this->object)->id) {
            $allowed = $this->object->permissions;
        }
        
        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
            'permissions' => $permissions,
            'allowed' => $allowed ?? null,
            'groups' => $groups
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }

    public function submit($formData){
        $ids = array_values($formData);
        if (!empty($ids)) {
            $this->object->permissions()->sync($ids);
            $this->emit('notification_update_success');
        }
        $this->emit('refreshComponent');
    }
}
