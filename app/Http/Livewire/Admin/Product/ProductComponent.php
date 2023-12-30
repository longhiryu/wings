<?php

namespace App\Http\Livewire\Admin\Product;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\ProductTranslation;
use App\Http\Livewire\Admin\BaseComponent;
use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductComponent extends BaseComponent
{
    public $parent = null;
    public $price_range = null;

    use AuthorizesRequests;

    public function rules()
    {
        $rules = [
            'object.id' => 'nullable',
            'object.is_active' => ['nullable'],
            'object.price' => ['nullable', 'numeric', 'min:0'],
            'object.sku' => ['required', 'max:50'],
            'object.rating' => ['nullable', 'max:100'],
            'object.material' => 'nullable',
            'object.unit' => ['required'],
            'object.category_id' => 'nullable',
            'object.file_id' => 'nullable',
            'object.supplier_id' => 'required|integer',
            'translated.locale' => 'nullable',
            'translated.name' => 'required|string|max:255',
            'translated.image' => 'nullable',
            'translated.title' => 'nullable',
            'translated.short_description' => 'nullable',
            'translated.long_description' => 'nullable',
            'translated.slug' => 'nullable',
        ];

        // Kiểm tra sự duy nhất của trường 'code' trong bảng ngoại khi tạo mới
        if (!optional($this->object)->id) {
            $rules['object.sku'][] = 'unique:products,sku';
        } else{
            // Kiểm tra sự duy nhất của trường 'code' trong bảng ngoại khi cập nhật, tránh kiểm tra với bản ghi hiện tại
            $rules['object.sku'][] = 'unique:products,sku,' . $this->object->id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'object.price.min' => 'Giá trị phải lớn hơn hoặc bằng :min',
            'object.rating.max' => 'Dữ liệu không quá :max ký tự',
            'object.sku.required' => 'Vui lòng nhập mã',
            'object.sku.unique' => 'Mã này đã tồn tại trong hệ thống. Vui lòng chọn mã khác.',
            'object.sku.max' => 'Dữ liệu không quá :max ký tự',
            'object.supplier_id.required' => 'Vui lòng chọn Nhà cung cấp.',
            'translated.name.required' => 'Vui lòng điền tên sản phẩm.',
            'translated.name.max' => 'Trường name không được vượt quá :max ký tự.',
            'translated.title.required' => 'Vui lòng điền tiêu đề. Việc này quan trọng cho SEO',
            'translated.title.max' => 'Trường tiêu đề không được vượt quá :max ký tự.',
        ];
    }

    public function render()
    {
        $this->authorize('index', new Product());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Product();
        $this->modelTranslation = new ProductTranslation();
        $this->type = 'product';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => ['name', 'sku'],
            'keyword' => $this->keyword,
            'sortBy' => $this->sortBy,
            'sortType' => $this->sortType,
            'limit' => $this->limit,
        ];

        // filter
        if ($this->parent != null) {
            $pars['category_id'] = $this->parent;
        }

        $data = $this->sysData->getData($this->model, $pars);
        $suppliers = $this->sysData->getData(new Supplier(), ['is_active' => 1]);

        $cateTree = null;
        if (method_exists($this->model, 'getTree')) {
            $cateTree = $this->model->getTree(null, null, $this->type);
        }

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
            'cateTree' => $cateTree,
            'suppliers' => $suppliers,
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }

    public function duplicateProduct($id){
        
        if($this->model->duplicateProduct($id)){
            $this->emit('notification_update_success');
        }else{
            $this->emit('notification_error', 'Đã có lỗi xảy ra ProductComponent:duplicateProduct()');
        }
    }
}
