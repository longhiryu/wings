<?php

namespace App\Http\Livewire\Admin\Order;

use DB;
use App\Sys\SysCore;
use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\OrderExport;
use App\Models\OrderProduct;
use App\Models\InventoryProduct;
use App\Http\Livewire\Admin\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderComponent extends BaseComponent
{
    use AuthorizesRequests;

    public $product_ids = [];
    public $product_list = [];
    public $product_export_list = [];
    public $export_iteration = 0;
    public $product_iteration = 0;
    public $stock_iteration = 0;

    public function rules()
    {
        return [
            'object.id' => 'nullable',
            'object.name' => 'required|min:10',
            'object.customer_id' => 'required',
            'object.address_id' => 'required',
            'object.note' => 'nullable',
            'object.exported' => 'nullable',
            'product_list' => 'required|array',
            'product_export_list' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'object.name.required' => 'Tên đối tượng là bắt buộc.',
            'object.name.min' => 'Tên đối tượng phải có ít nhất :min ký tự.',
            'object.customer_id.required' => 'Vui lòng chọn khách hàng.',
            'object.address_id.required' => 'Vui lòng chọn địa chỉ.',
            'product_list.required' => 'Vui lòng thêm sản phẩm vào đơn hàng!',
            'product_export_list.required' => 'Vui lòng thêm sản phẩm vào phiếu xuất kho!',
            // Thêm các thông báo tùy chỉnh cho các quy tắc khác nếu cần.
        ];
    }

    public function render()
    {
        $this->authorize('index', new Order());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Order();
        $this->type = 'order';
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

        // get data
        $data = $this->sysData->getData($this->model, $pars);
        $customers = $this->sysData->getData(new Customer(), ['is_active' => 1]);
        $products = $this->sysData->getData(new Product(), ['is_active' => 1]);
        $stocks = InventoryProduct::all();
        $addresses = $this->getAddresses();

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
            'customers' => $customers,
            'products' => $products,
            'addresses' => $addresses,
            'stocks' => $stocks,
        ];

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }

    public function getAddresses()
    {
        if (optional($this->object)->customer_id) {
            $customer = Customer::find($this->object->customer_id);

            return $customer->addresses;
        }

        return null;
    }

    /**
     * Method getProductList
     * Lấy các sản phẩm thuộc Order từ Database
     * @return void
     */
    public function getProductList()
    {
        $products = OrderProduct::where('order_id', $this->object->id)->get();
        if ($products) {
            foreach ($products as $item) {
                $this->product_list[] = [
                    'sku_random' => SysCore::strRandom(),
                    'id' => $item->id,
                    'order_id' => optional($this->object)->id,
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

    public function getExportProduct()
    {
        $products = OrderExport::where('order_id', $this->object->id)->get();
        if ($products) {
            foreach ($products as $item) {
                $this->product_export_list[] = [
                    'sku_random' => SysCore::strRandom(),
                    'id' => $item->id,
                    'order_id' => optional($this->object)->id,
                    'product_id' => $item->inventoryProduct->product_id,
                    'inventory_product_id' => $item->inventoryProduct->id,
                    'name' => $item->inventoryProduct->product->translate('name'),
                    'product_name' => $item->inventoryProduct->product_name,
                    'product_unit' => $item->inventoryProduct->product_unit,
                    'import_price' => $item->inventoryProduct->import_price,
                    'selling_price' => $item->inventoryProduct->selling_price,
                    'supplier' => $item->inventoryProduct->supplier->name,
                    'inventory' => $item->inventoryProduct->inventory->name,
                    'stock' => $item->inventoryProduct->product_quantity,
                    'export_quantity' => $item->export_quantity,
                ];
            }
        }
    }

    /**
     * Method addProductToList
     * Thêm sản phẩm vào danh sách của Order, thực hiện ở view
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function addProductToList($id)
    {
        $product = Product::find($id);
        $this->product_list[] = [
            'sku_random' => SysCore::strRandom(),
            'id' => null,
            'order_id' => optional($this->object)->id,
            'product_id' => $product->id,
            'product_name' => $product->translate('name'),
            'product_price' => $product->price,
            'product_quantity' => 1,
            'product_unit' => 'pcs',
            'note' => null,
        ];
    }

    public function addProductToExportList($id)
    {
        $stock = InventoryProduct::find($id);
        $this->product_export_list[] = [
            'sku_random' => SysCore::strRandom(),
            'id' => null,
            'order_id' => optional($this->object)->id,
            'product_id' => $stock->product_id,
            'inventory_product_id' => $stock->id,
            'name' => $stock->product->translate('name'),
            'product_name' => $stock->product_name,
            'product_unit' => $stock->product_unit,
            'import_price' => $stock->import_price,
            'selling_price' => $stock->selling_price,
            'supplier' => $stock->supplier->name,
            'inventory' => $stock->inventory->name,
            'stock' => $stock->product_quantity,
            'export_quantity' => 1,
        ];
    }

    /**
     * Method updateProductList
     *
     * @param $key $key [giá trị quantity, prirce ...]
     * @param $sku_random $sku_random [mã quản lý ngắn hạn ở SysCore]
     * @param $value $value [giá trị mới để cập nhật]
     *
     * @return void
     */
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

    /**
     * Method updateProductExportList
     *
     * @param $key $key [explicite description]
     * @param $sku_random $sku_random [explicite description]
     * @param $value $value [giá trị được nhập vào]
     * @param $stock $stock [giá trị tồn kho]
     *
     * @return void
     */
    public function updateProductExportList($key, $sku_random, $value, $stock)
    {
        if ($value <= $stock && $value > 0) {
            foreach ($this->product_export_list as &$item) {
                if ($item['sku_random'] == $sku_random) {
                    $item[$key] = $value;
                }
            }
        }

        $this->export_iteration++;
    }

    /**
     * Method removeProductFromList
     * Xóa sản phầm khỏi danh sách hiển thị, đồng thời khỏi Database nếu có
     * @param $sku_random $sku_random [explicite description]
     *
     * @return void
     */
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

    public function removeProductFromExportList($sku_random)
    {
        if ($sku_random) {
            foreach ($this->product_export_list as $key => $value) {
                if ($value['sku_random'] == $sku_random) {
                    unset($this->product_export_list[$key]);
                }
            }
        }
    }

    public function check_list()
    {
        dd($this->object);
    }

    /**
     * Method saveOrderProducts
     * Sau khi lưu Order sẽ tiến hành lưu các sản phẩm thuộc Order
     * Lưu ý: update những sản phẩm đã tồn tại
     * @return void
     */
    public function saveOrderProducts()
    {
        $inList = array_column($this->product_list, 'id');
        // remove not inlist
        OrderProduct::whereNotIn('id', $inList)->delete();

        foreach ($this->product_list as $item) {
            OrderProduct::updateOrCreate([
                'order_id' => optional($this->object)->id,
                'product_id' => $item['product_id'],
                'product_price' => $item['product_price'],
            ], [
                'order_id' => optional($this->object)->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'product_price' => $item['product_price'],
                'product_quantity' => $item['product_quantity'],
                'product_unit' => $item['product_unit'],
                'note' => $item['note'],
            ]);
        }
    }

    /**
     * Method saveExportProduct
     * Lưu trữ thông tin các sản phẩm xuất kho
     * @return void
     */
    public function saveExportProduct()
    {
        $inList = array_column($this->product_export_list, 'id');
        // xóa những sản phẩm không có trong danh sách (bảng xuất)
        OrderExport::whereNotIn('id', $inList)->delete();

        foreach ($this->product_export_list as $item) {

            // Lưu trữ thông tin các sản phẩm xuất kho
            OrderExport::updateOrCreate([
                'order_id' => optional($this->object)->id,
                'inventory_product_id' => $item['inventory_product_id'],
            ], [
                'order_id' => optional($this->object)->id,
                'inventory_product_id' => $item['inventory_product_id'],
                'export_quantity' => $item['export_quantity'],
            ]);
        }
    }

    public function checkStock()
    {
        $this->validation();

        DB::beginTransaction();

        try {
            foreach ($this->product_export_list as $item) {
                // Thực thiện trừ kho khi có lệnh trừ kho
                if ($this->object->exported == 0) {
                    $stock = InventoryProduct::find($item['inventory_product_id']);
                    if ($stock && $stock->product_quantity >= $item['export_quantity']) {
                        $stock->decrement('product_quantity', $item['export_quantity']);

                        // mark order exported
                        $this->object->exported = 1;
                        $this->object->save();
                        $this->export = null;
                    } else {
                        throw new \Exception('Đơn hàng đã được xuất hoặc không đủ số lượng tồn kho.');
                    }
                }
            }

            $this->emit('select2_intial');

            $this->product_iteration++;
            $this->stock_iteration++;

            $this->emit('refreshComponent');
            DB::commit();
        } catch (\Throwable $th) {

            $this->emit('notification_error', $th->getMessage());
            //throw $th;
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
            $this->getExportProduct();
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
        $this->saveOrderProducts();
        $this->saveExportProduct();
    }
}
