<?php

namespace App\Http\Livewire\Admin\Project;

use App\Sys\SysCore;
use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\ProjectProduct;
use App\Http\Livewire\Admin\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectComponent extends BaseComponent
{
    use AuthorizesRequests;

    public $product_list;
    public $product_iteration;

    public function rules()
    {
        $rules = [
            'object.id' => 'nullable',
            'object.name' => ['required', 'string', 'max:255', 'min:8'],
            'object.code' => ['required'],
            'object.tax' => ['required', 'integer', 'in:0,3,5,10'],
            'object.customer_id' => ['required', 'integer'],
            'object.is_active' => ['nullable'],
            'object.finished' => ['nullable'],
            'object.staff_id' => ['nullable'],
            'object.consignee_name' => ['nullable'],
            'object.consignee_phone' => ['nullable'],
            'object.address' => ['nullable'],
            'object.note' => ['nullable'],
        ];

        // Kiểm tra sự duy nhất của trường 'code' trong bảng ngoại khi tạo mới
        if (!optional($this->object)->id) {
            $rules['object.code'][] = 'unique:projects,code';
        } else{
            // Kiểm tra sự duy nhất của trường 'code' trong bảng ngoại khi cập nhật, tránh kiểm tra với bản ghi hiện tại
            $rules['object.code'][] = 'unique:projects,code,' . $this->object->id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'object.name.required' => 'Tên là bắt buộc.',
            'object.name.string' => 'Tên phải là chuỗi.',
            'object.name.max' => 'Tên không được vượt quá :max ký tự.',
            'object.name.min' => 'Tên phải có ít nhất :min ký tự.',
            'object.code.required' => 'Mã là bắt buộc.',
            'object.code.string' => 'Mã phải là chuỗi.',
            'object.code.max' => 'Mã không được vượt quá :max ký tự.',
            'object.code.min' => 'Mã phải có ít nhất 0 :min tự.',
            'object.tax.required' => 'Thuế là bắt buộc.',
            'object.tax.integer' => 'Thuế phải là số nguyên.',
            'object.tax.in' => 'Thuế phải thuộc một trong các giá trị: 0, 3, 5, 10.',
            'object.customer_id.required' => 'Vui lòng chọn khách hàng!.',
            'object.customer_id.integer' => 'ID khách hàng phải là số nguyên.',
        ];
    }

    public function render()
    {
        $this->authorize('index', new Project());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Project();
        $this->type = 'project';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => ['name', 'code'],
            'keyword' => $this->keyword,
            'sortBy' => 'created_at',
            'sortType' => 'DESC',
            'limit' => $this->limit,
        ];

        $data = $this->sysData->getData($this->model, $pars);
        $customers = $this->sysData->getData(new Customer(), ['is_active' => 1]);
        $products = $this->sysData->getData(new Product(), ['is_active' => 1, 'material' => false]);

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
            'customers' => $customers,
            'products' => $products,
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }

    public function getProductList()
    {
        $products = ProjectProduct::where('project_id', $this->object->id)->get();
        if ($products) {
            foreach ($products as $item) {
                $pro_data = Product::find($item->product_id);
                $this->product_list[] = [
                    'sku_random' => SysCore::strRandom(),
                    'id' => $item->id,
                    'sku' => $pro_data->sku,
                    'image' => $pro_data->getImage(),
                    'project_id' => optional($this->object)->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'product_price' => $item->product_price,
                    'product_quantity' => $item->product_quantity,
                    'product_unit' => $item->product_unit,
                    'note' => $item->note,
                ];
            }
        }
    }

    public function addProductToList($id)
    {
        $product = Product::find($id);
        $this->product_list[] = [
            'sku_random' => SysCore::strRandom(),
            'id' => null,
            'sku' => $product->sku,
            'image' => $product->getImage(),
            'project_id' => optional($this->object)->id,
            'product_id' => $product->id,
            'product_name' => $product->translate('name'),
            'product_price' => $product->price,
            'product_quantity' => 1,
            'product_unit' => $product->unit ?? 'pcs',
            'note' => null,
        ];
    }

    public function saveProjectProducts()
    {
        $inList = array_column($this->product_list, 'id');
        // remove not inlist
        ProjectProduct::whereNotIn('id', $inList)->where('project_id', $this->object->id)->delete();

        foreach ($this->product_list as $item) {
            ProjectProduct::updateOrCreate([
                'project_id' => optional($this->object)->id,
                'product_id' => $item['product_id'],
                'product_price' => $item['product_price'],
            ], [
                'project_id' => optional($this->object)->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'product_price' => $item['product_price'],
                'product_quantity' => $item['product_quantity'],
                'product_unit' => $item['product_unit'],
                'note' => $item['note'],
            ]);
        }
    }

    public function updateProductList($key, $sku_random, $value)
    {
        if ($key == 'product_quantity' && ($value <= 0 or $value == null)) {
            $value = 1;
        }

        foreach ($this->product_list as &$item) {
            if ($item['sku_random'] == $sku_random) {
                $item[$key] = $value;
            }
        }
    }

    public function removeProductFromList($sku_random)
    {
        if ($sku_random) {
            foreach ($this->product_list as $key => $value) {
                if ($value['sku_random'] == $sku_random) {
                    unset($this->product_list[$key]);
                }
            }
        }
    }

    /**
     * Method whenEdit
     * Hàm được gọi chạy khi ở trang edit
     * @return void
     */
    public function whenEdit()
    {
        if (optional($this->object)->id) {
            $this->getProductList();
        }
    }

    public function beforeSave()
    {
    }

    /**
     * Method afterSave
     * Chạy hàm này sau khi đã lưu thông tin của Component chính
     * @return void
     */
    public function afterSave()
    {
        $this->saveProjectProducts();
    }
}
