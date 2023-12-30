<?php

namespace App\Http\Livewire\Admin\Category;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryTranslation;
use App\Http\Livewire\Admin\BaseComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryComponent extends BaseComponent
{
    public $parent = null;

    use AuthorizesRequests;

    protected $rules = [
        'object.id' => 'nullable',
        'object.is_active' => 'nullable',
        'object.parent_id' => 'nullable',
        'object.type' => 'required',
        'object.file_id' => 'nullable',
        'object.position' => 'nullable',
        'translated.locale' => 'nullable',
        'translated.name' => 'required|string|max:255',
        'translated.title' => 'nullable',
        'translated.short_description' => 'nullable',
        'translated.long_description' => 'nullable',
        'translated.slug' => 'nullable',
    ];

    public function render()
    {
        //ADD locations
        // $data = config('vn_locations');
        // foreach ($data as $city) {
        //     DB::beginTransaction();

        //     try {
        //         $new_city_id = DB::table('address_cities')->insertGetId([
        //             'name' => $city['name'],
        //             'code' => $city['code'],
        //             'code_name' => $city['codename'],
        //             'division_type' => $city['division_type'],
        //             'phone_code' => $city['phone_code'],
        //         ]);

        //         if (!empty($city['districts'])) {
        //             foreach ($city['districts'] as $dist) {
        //                 $new_dist_id = DB::table('address_districts')->insertGetId(
        //                     [
        //                         'name' => $dist['name'],
        //                         'code' => $dist['code'],
        //                         'code_name' => $dist['codename'],
        //                         'short_codename' => $dist['short_codename'],
        //                         'division_type' => $dist['division_type'],
        //                         'address_city_id' => $new_city_id,
        //                     ]
        //                 );

        //                 if (!empty($dist['wards'])) {
        //                     foreach ($dist['wards'] as $ward) {
        //                         DB::table('address_wards')->insertGetId(
        //                             [
        //                                 'name' => $ward['name'],
        //                                 'code' => $ward['code'],
        //                                 'code_name' => $ward['codename'],
        //                                 'short_codename' => $ward['short_codename'],
        //                                 'division_type' => $ward['division_type'],
        //                                 'address_city_id' => $new_city_id,
        //                                 'address_district_id' => $new_dist_id,
        //                             ]
        //                         );
        //                     }
                            
        //                 }
        //             }
        //         }
        //         DB::commit();
        //     } catch (\Throwable $th) {
        //         DB::rollback();

        //         throw($th);
        //     }
        // }

        // ADD locations

        $this->authorize('index', new Category());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Category();
        $this->modelTranslation = new CategoryTranslation();
        $this->type = 'category';
        $this->view = $this->sysView->livewireAdminIndexView($this->type);
        $this->masterView = $this->sysView::_LIVEWIRE_ADMIN_MASTER_VIEW;
        $this->sectionView = $this->sysView::_LIVEWIRE_ADMIN_SECTION;
        $this->limit = $this->limit ?? getSetting('admin_items_per_page', $this->settings);
        $this->files = $this->getFiles();
        $pars = [
            'searchField' => collect($this->searchFields)->first(),
            'keyword' => $this->keyword,
            'sortBy' => ['type', 'parent_id'],
            'sortType' => 'DESC',
            'limit' => $this->limit,
        ];

        // filter
        if ($this->parent != null) {
            $pars['parent_id'] = $this->parent;
        }

        $data = $this->sysData->getData($this->model, $pars);

        $cateTree = null;
        if (method_exists($this->model, 'getTree')) {
            $cateTree = $this->model->getTree(null, null, null);
        }

        $dataToView = [
            'data' => $data,
            'links' => $data->links() ?? null,
            'cateTree' => $cateTree,
        ];

        $this->checkPermission();
        
        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }
}
