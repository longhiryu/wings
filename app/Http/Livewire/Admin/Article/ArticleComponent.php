<?php

namespace App\Http\Livewire\Admin\Article;

use App\Sys\SysData;
use App\Sys\SysItem;
use App\Sys\SysView;
use App\Models\Article;
use App\Models\ArticleTranslation;
use App\Http\Livewire\Admin\BaseComponent;
use App\Models\Setting;
use App\Rules\BooleanOrNullableRule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ArticleComponent extends BaseComponent
{
    public $parent = null;

    use AuthorizesRequests;

    public function rules(){
        return [
            'object.id' => 'nullable',
            'object.is_active' => ['nullable', new BooleanOrNullableRule],
            'object.viewed' => 'nullable',
            'object.category_id' => 'nullable',
            'object.file_id' => 'nullable',
            'translated.locale' => 'nullable',
            'translated.name' => 'required|string|max:255',
            'translated.image' => 'nullable',
            'translated.title' => 'required|string|max:255',
            'translated.short_description' => 'nullable',
            'translated.long_description' => 'nullable',
            'translated.slug' => 'nullable',
        ];
    }

    public function messages()
{
    return [
        'translated.name.required' => 'Vui lòng nhập tên.',
        'translated.name.string' => 'Tên phải là chuỗi.',
        'translated.name.max' => 'Tên không thể dài hơn 255 ký tự.',
        'translated.title.required' => 'Vui lòng nhập tiêu đề.',
        'translated.title.string' => 'Tiêu đề phải là chuỗi.',
        'translated.title.max' => 'Tiêu đề không thể dài hơn 255 ký tự.',
        // Thêm thông báo tùy chỉnh cho các quy tắc kiểm tra khác ở đây...
    ];
}

    public function render()
    {
        $this->authorize('index', new Article());

        $this->sysView = new SysView();
        $this->sysItem = new SysItem();
        $this->sysData = new SysData();
        $this->settings = Setting::all();
        $this->model = new Article();
        $this->modelTranslation = new ArticleTranslation();
        $this->type = 'article';
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
            'data' => $data,
            'links' => $data->links() ?? null,
            'cateTree' => $cateTree
        ];

        $this->checkPermission();

        return view($this->view, $dataToView)
        ->extends($this->masterView)
        ->section($this->sectionView);
    }
}
