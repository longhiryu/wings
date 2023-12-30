<?php

namespace App\Http\Livewire\Admin\Import;

use DB;
use App\Models\User;
use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Import;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\InventoryProduct;
use App\Http\Livewire\Admin\BaseComponent;
use App\Models\Customer;
use App\Models\Project;
use App\Sys\SysCore;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;

class ImportComponent extends BaseComponent
{
    use AuthorizesRequests;

    protected $modal_import;
    protected $product_select; // Product list to select
    public $user_id;
    public $supplier_id;
    public $inventory_id;
    public $product_ids = [];
    public $product_list = [];
    public $product_iteration = 0;
    public $image_viewbox_flag = 0;
    public $source_text_search;
    public $import_product_keyword;
    public $project_keyword;
    public $project_name;

    public $list_iteration = 1;

    public function rules()
    {
        $rules = [
            'object.id' => 'nullable',
            'object.name' => 'required|string|max:255',
            'object.supplier_id' => 'nullable',
            'object.customer_id' => 'nullable',
            'object.project_id' => 'nullable',
            'object.inventory_id' => 'required|int',
            'object.note' => 'nullable',
            'object.items' => 'nullable',
            'object.type' => 'required|string',
            'product_list' => 'required|array',
        ];

        if (optional($this->object)->type == 'supplier') {
            $rules['object.supplier_id'] = ['required', 'int'];
        }

        if (optional($this->object)->type == 'customer') {
            $rules['object.customer_id'] = ['required', 'int'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'object.name.required' => 'Vui lòng nhập tên Phiếu nhập.',
            'object.name.max' => 'Tên Phiếu nhập không được vượt quá 255 ký tự.',
            'object.supplier_id.required' => 'Vui lòng chọn Nhà cung cấp.',
            'object.customer_id.required' => 'Vui lòng chọn Khách hàng.',
            'object.inventory_id.required' => 'Vui lòng chọn Kho nhập.',
            'object.type.required' => 'Vui lòng chọn Loại phiếu nhập.',
            'product_list.required' => 'Danh sách sản phẩm là bắt buộc.'
        ];
    }

    public function render()
    {
        $this->authorize('index', new Import());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Import();
        $this->type = 'import';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => ['name', 'code'],
            'keyword' => $this->keyword,
            'sortBy' => $this->sortBy,
            'sortType' => $this->sortType,
            'limit' => $this->limit,
        ];

        // filter
        $this->user_id != null && $pars['user_id'] = $this->user_id;
        $this->supplier_id != null && $pars['supplier_id'] = $this->supplier_id;
        $this->inventory_id != null && $pars['inventory_id'] = $this->inventory_id;

        // get data
        $data = $this->sysData->getData($this->model, $pars);
        $users = User::active()->get();
        $suppliers = $this->sysData->getData(new Supplier(), ['is_active' => 1]);
        $inventories = $this->sysData->getData(new Inventory(), ['is_active' => 1]);
        $this->project_name = null;
        if (optional($this->object)->project_id) {
            $this->project_name = optional($this->object->project)->name;
        }

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
            'users' => $users,
            'suppliers' => $suppliers,
            'inventories' => $inventories,
            'modal_import' => $this->modal_import,
            'product_select' => $this->searchProductToAdd(),
            'source_import_data' => $this->getSourceImport(),
            'types' => config('import.types'),
            'project_list' => $this->searchProject()
        ];
        $this->checkPermission();

        return view($this->view, $dataToView)
            ->extends($this->masterView)
            ->section($this->sectionView);
    }

    /**
     * searchProject function
     *
     * @return void
     */
    public function searchProject()
    {
        if ($this->project_keyword && strlen($this->project_keyword) >= 3) {
            $sysData = new SysData();
            $projects = $sysData->getData(new Project(), [
                'is_active' => 0,
                'searchField' => 'name',
                'keyword' => $this->project_keyword,
                'limit' => 5
            ]);

            return $projects;
        }

        return null;
    }

    public function setProjectId($id, $name)
    {
        $this->object->project_id = $id;
        $this->project_name = $name;
        $this->project_keyword = null;
    }

    /**
     * Method searchProduct
     * Hiển thị danh sách sản phẩm tìm kiếm theo keyword
     * @return null|\Illuminate\Support\Collection
     */
    public function searchProductToAdd()
    {
        if ($this->import_product_keyword) {
            $sysData = new SysData();
            $pars = [
                'is_active' => 1,
                'keyword' => $this->import_product_keyword,
                'searchField' => ['name', 'sku'],
                'limit' => 10
            ];

            if ($this->object->type == 'supplier' && optional($this->object)->supplier_id) {
                $pars['supplier_id'] = $this->object->supplier_id;
            }

            if ($this->object->type == 'customer' && optional($this->object)->customer_id) {
                $pars['customer_id'] = $this->object->customer_id;
            }

            return $sysData->getData(new Product(), $pars);
        }

        return null;
    }

    /**
     * Method getSourceImport
     * Danh sách Supplier hoặc Customer 
     * @return \Illuminate\Support\Collection
     */
    public function getSourceImport()
    {
        if ($this->source_text_search && $this->object->type == 'supplier') {
            $sysData = new SysData();
            return $sysData->getData(new Supplier(), [
                'is_active' => 1,
                'keyword' => $this->source_text_search,
                'searchField' => 'name',
                'limit' => 10
            ]);
        }

        if ($this->source_text_search && $this->object->type == 'customer') {
            $sysData = new SysData();
            return $sysData->getData(new Customer(), [
                'is_active' => 1,
                'keyword' => $this->source_text_search,
                'searchField' => 'company_name',
                'limit' => 10
            ]);
        }

        return null;
    }

    /**
     * Method setSourceImport
     * @param int $source_id
     * @return void
     */
    public function setSourceImport(int $source_id)
    {
        if ($this->object->type == 'supplier') {
            $this->object->supplier_id = $source_id;
        } else {
            $this->object->customer_id = $source_id;
        }
    }

    /**
     * Method print
     * @param int $id
     * @return mixed
     */
    public function print(int $id): mixed
    {
        $import = $this->model->find($id);
        $types = config('import.types');
        $viewContent = view('livewire.admin.import.print', compact('import', 'types'))->render();
        //$pdf = Pdf::loadView('livewire.admin.import.print', compact('data'));
        $pdf = Pdf::loadHTML($viewContent);
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, $import->name . '-' . $import->created_at . '.pdf');
    }

    /**
     * Method addProductToList
     * @param int $id
     * @return void
     */
    public function addProductToList($id)
    {
        $sku = SysCore::strRandom();
        $this->dispatchBrowserEvent('addProductToList', ['sku' => $sku]);

        $product = Product::find($id);
        $sku = $product->sku;
        $valueExists = array_reduce($this->product_list, function ($carry, $subArray) use ($sku) {
            return $carry || in_array($sku, $subArray);
        }, false);

        if ($product && !$valueExists) {

            $this->product_list[] = [
                'sku' => $product->sku,
                'product_id' => $id,
                'image' => $product->getImage(),
                'product_name' => $product->translate('name'),
                'import_price' => 0,
                'selling_price' => 0,
                'product_quantity' => 1,
                'product_unit' => $product->unit,
            ];
        }

        $this->import_product_keyword = null;
    }

    /**
     * Method importToInventory
     * import product to Inevtory
     * @param int $import_id
     *
     * @return void
     */
    public function importToInventory($import_id)
    {
        $now = Carbon::now();

        DB::beginTransaction();
        try {
            $import = Import::where('id', $import_id)->where('is_imported', 0)->first();
            if (!$import) {
                throw new Exception('Nothing to import!');
            }
            $import->is_imported = 1;
            $import->import_date = $now->format('Y-m-d');
            $import->save();

            $products = json_decode($import->items, true);
            if ($products) {
                foreach ($products as $item) {
                    InventoryProduct::updateOrCreate(
                        [
                            'product_id' => $item['product_id'],
                            'inventory_id' => $import->inventory_id,
                            'supplier_id' => $import->supplier_id,
                            'customer_id' => $import->customer_id,
                            'project_id' => $import->project_id,
                            'type' => $import->type,
                            'import_price' => $item['import_price'],
                            'product_unit' => $item['product_unit'],
                        ],
                        [
                            'product_id' => $item['product_id'],
                            'inventory_id' => $import->inventory_id,
                            'supplier_id' => $import->supplier_id,
                            'customer_id' => $import->customer_id,
                            'project_id' => $import->project_id,
                            'type' => $import->type,
                            'product_name' => $item['product_name'],
                            'import_price' => $item['import_price'],
                            'selling_price' => 0,
                            'product_unit' => $item['product_unit'],
                            'product_quantity' => DB::raw("product_quantity + " . $item['product_quantity']),
                        ]
                    );
                }
            }
            DB::commit();

            $this->emit('notification_update_success');
        } catch (\Throwable $th) {
            DB::rollback();
            $this->emit('notification_error', $th->getMessage());
        }
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
        if ($key == 'product_quantity' && ($value <= 0 or $value == null)) {
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
     * Method saveProductList
     * Save products to import_products
     * @return void
     */
    public function saveProductList()
    {
        if ($this->object->id && !empty($this->product_list)) {
            $this->object->items = json_encode($this->product_list);
            $this->object->save();
        } else {
            $this->emit('notification_error', 'Vui lòng kiểm tra danh sách sản phẩm!');
        }
    }

    /**
     * Method getProductList
     * get list product of this Import
     * @return void
     */
    public function getProductList()
    {
        if (optional($this->object)->id && optional($this->object)->items) {
            $this->product_list = json_decode($this->object->items, true);

            return $this->product_list;
        }

        return null;
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return void
     */
    public function modalImportInventory(int $id)
    {
        $data = Import::find($id);
        if ($data) {
            $this->modal_import = $data;
        }
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
     * removeProp function
     *
     * @param string $propName
     * @return void
     */
    public function removeProp(string $propName, bool $clear_list = false)
    {
        $array = explode(',', $propName);

        $clear_list && $this->product_list = [];

        if (!empty($array)) {
            foreach ($array as $name) {
                $this->object->$name = null;
            }
            $this->source_text_search = null;
        }
    }

    /**
     * Method whenCreate
     * Hàm được gọi chạy khi ở trang create
     * @return void
     */
    public function whenCreate()
    {
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
        $this->object->user_id = auth()->user()->id;
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
