<?php

namespace App\Http\Livewire\Admin\Export;

use Exception;
use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Export;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Http\Livewire\Admin\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SupplierOrderComponent extends BaseComponent
{
    use AuthorizesRequests;

    public $customer_keyword;
    public $inventory_keyword;
    public $project_keyword;
    public $product_keyword;
    public $product_list = [];
    public $list_iteration = 0;

    public function rules()
    {
        $rules = [
            'object.id'               => 'nullable',
            'object.code'             => 'nullable',
            'object.items'            => 'nullable',
            'object.creator_id'       => 'required',
            'object.customer_id'      => 'nullable',
            'object.project_id'       => 'nullable',
            'object.export_status'    => 'nullable',
            'object.export_date'      => 'nullable',
            'object.delivery_address' => 'required',
            'object.inventory_id'     => 'required',
            'object.reciever_name'    => 'required',
            'object.reciever_phone'   => 'required',
            'object.driver_name'      => 'nullable',
            'object.driver_phone'     => 'nullable',
            'object.driver_plate'     => 'nullable',
            'object.note'             => 'nullable',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'object.delivery_address.required' => 'Vui lòng cung cấp Địa chỉ giao hàng.',
            'object.inventory_id.required'     => 'Vui lòng chọn kho xuất.',
            'object.reciever_name.required'    => 'Vui lòng nhập Tên người nhận.',
            'object.reciever_phone.required'   => 'Vui lòng nhập Điện thoại người nhận.',
            // Thêm các thông báo cho các trường khác tương ứng ở đây
        ];
    }

    public function render()
    {
        $export = new Export;

        $this->authorize('index', $export);

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = $export;
        $this->type = 'export';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => ['name', 'code'],
            'keyword'     => $this->keyword,
            'limit'       => $this->limit,
        ];

        $data = $this->sysData->getData($this->model, $pars);

        $dataToView = [
            'data'        => $data,
            'links'       => $data->links() ?? null,
            'suppliers'   => $this->searchList(new Supplier(), $this->supplier_keyword),
            'projects'    => $this->searchList(new Project(), $this->project_keyword),
            'products'    => $this->searchList(new Product(), $this->product_keyword),
            'inventories' => $this->searchList(new Inventory(), $this->inventory_keyword),
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
            ->extends($this->masterView)
            ->section($this->sectionView);
    }

    public function getProductList()
    {
        if (optional($this->object)->id && optional($this->object)->items) {
            $this->product_list = json_decode($this->object->items, true);
        }
    }

    /**
     * searchList function
     *
     * @return void
     */
    public function searchList(object $model, string|null $keyword)
    {
        if ($keyword && strlen($keyword) >= 3) {
            $sysData = new SysData();
            $data = $sysData->getData($model, [
                'is_active'   => 1,
                'searchField' => ['name', 'code', 'sku'],
                'keyword'     => $keyword,
                'limit'       => 5,
            ]);

            return $data;
        }

        return null;
    }

    /**
     * removeProp function
     *
     * @param string $propName
     * @return void
     */
    public function removeProp(string $propName)
    {
        $array = explode(',', $propName);

        if (! empty($array)) {
            foreach ($array as $name) {
                $this->object->$name = null;
            }
        }
    }

    /**
     * setProp function
     *
     * @param string $propName
     * @param mixed $value
     * @return void
     */
    public function setProp(string $propName, mixed $value, string $keywordPropName):void
    {
        if (! empty($propName) && ! empty($value)) {
            $this->object->$propName = $value;
            $this->$keywordPropName = null;
        }
    }

    /**
     * addProductToList function
     *
     * @param int $product_id
     * @return void
     */
    public function addProductToList(int $product_id)
    {
        $product = Product::find($product_id);

        // Kiểm tra sku đã tồn tại hay chưa
        foreach ($this->product_list as &$subArray) {
            if (isset($subArray['sku']) && $subArray['sku'] === $product->sku) {
                $subArray['quantity'] += 1;

                break;
            }
        }

        // Nếu sku chưa tồn tại
        if (! in_array($product->sku, array_column($this->product_list, 'sku'))) {
            $this->product_list[] = [
                'id'       => $product->id,
                'sku'      => $product->sku,
                'name'     => $product->translated->name,
                'sku'      => $product->sku,
                'unit'     => $product->unit,
                'quantity' => 1,
                'price'    => 0,
            ];
        }

        $this->product_keyword = null;
        $this->list_iteration++;
    }

    /**
     * Method updateProductList
     *
     * @param string $key
     * @param string $sku_random
     * @param mixed $value
     *
     * @return void
     */
    public function updateProductList($key, $sku, $value)
    {
        if ($key == 'quantity' && ($value <= 0 or $value == null)) {
            $value = 1;
        }

        foreach ($this->product_list as &$item) {
            if ($item['sku'] == $sku) {
                $item[$key] = $value;
            }
        }

        $this->list_iteration++;
    }

    /**
     * Method removeProductFromList
     * @param string $sku
     *
     * @return void
     */
    public function removeProductFromList($sku)
    {
        if ($sku) {
            foreach ($this->product_list as $key => $value) {
                if ($value['sku'] == $sku) {
                    unset($this->product_list[$key]);
                }
            }
        }
    }

    /**
     * Method saveProductList
     * @return void
     */
    public function saveProductList()
    {
        if ($this->object->id && ! empty($this->product_list)) {
            $this->object->items = json_encode($this->product_list);
            $this->object->save();
        } else {
            $this->emit('notification_error', 'Vui lòng kiểm tra danh sách sản phẩm!');
        }
    }

    /**
     * Method whenCreate
     * Hàm được gọi chạy khi ở trang create
     * @return void
     */
    public function whenCreate()
    {
        $this->object->creator_id = auth()->user()->id;
        $this->product_list = [];
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

    /**
     * Method beforeSave
     * Hàm được gọi chạy trước khi save dữ liệu
     * @return void
     */
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
        $this->saveProductList();
    }
}
