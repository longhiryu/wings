<?php

namespace App\Http\Livewire\Admin\Supplier;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Setting;
use App\Models\Supplier;
use App\Http\Livewire\Admin\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SupplierComponent extends BaseComponent
{
    use AuthorizesRequests;

    public $parent = null;

    public function rules()
    {
        $rules = [
            'object.id'                => 'nullable',
            'object.is_active'         => 'nullable',
            'object.file_id'           => 'nullable',
            'object.category_id'       => 'nullable',
            'object.name'              => 'required|string|max:255|min:2',
            'object.presentation_name' => 'nullable',
            'object.company'           => 'nullable',
            'object.address'           => 'nullable',
            'object.phone'             => 'nullable',
            'object.email'             => 'nullable',
            'object.tax_no'            => 'nullable',
            'object.note'              => 'nullable',
            'object.code'              => ['required'],
        ];

        // Kiểm tra sự duy nhất của trường 'code' trong bảng ngoại khi tạo mới
        if (! optional($this->object)->id) {
            $rules['object.code'][] = 'unique:suppliers,code';
        } else {
            // Kiểm tra sự duy nhất của trường 'code' trong bảng ngoại khi cập nhật, tránh kiểm tra với bản ghi hiện tại
            $rules['object.code'][] = 'unique:suppliers,code,' . $this->object->id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'object.name.required' => 'Tên đối tượng là bắt buộc.',
            'object.name.string'   => 'Tên đối tượng phải là một chuỗi.',
            'object.name.max'      => 'Tên đối tượng không thể dài hơn :max ký tự.',
            'object.name.min'      => 'Tên đối tượng không thể ngắn hơn :min ký tự.',
            'object.code.required' => 'Mã đối tượng không được phép để trống.',
            'object.code.unique'   => 'Mã đối tượng đã tồn tại trong hệ thống.',
        ];
    }

    public function render()
    {
        $this->authorize('index', new Supplier());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Supplier();
        $this->type = 'supplier';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => ['name', 'code', 'phone', 'email'],
            'keyword'     => $this->keyword,
            'sortBy'      => $this->sortBy,
            'sortType'    => $this->sortType,
            'limit'       => $this->limit,
        ];

        // filter
        if ($this->parent != null) {
            $pars['category_id'] = $this->parent;
        }

        $data = $this->sysData->getData($this->model, $pars);

        $cateTree = null;
        if (method_exists($this->model, 'getTree')) {
            $cateTree = $this->model->getTree(null, null, $this->type);
        }

        $dataToView = [
            'data'     => $data,
            'links'    => $data->links() ?? null,
            'cateTree' => $cateTree,
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
            ->extends($this->masterView)
            ->section($this->sectionView);
    }
}
