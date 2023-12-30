<?php

namespace App\Models;

use App\Sys\SysData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class BaseModel extends Model
{
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function getImage()
    {
        $url = $this->file ? $this->file->path : null;
        if ($url) {
            return File::exists($url) ? $url : '/images/no_image.png';
        }
        
        return '/images/no_image.png';
    }

    public static function getTree($parentCategory = null, $prefix = '', $type = null)
    {
        $model = new Category();
        $sysData = new SysData();
        $params = ['parent_id' => null, 'is_active' => 1];
        $type != null && $params['type'] = $type;

        $data = $sysData->getData($model, $params);
        $categories = ($parentCategory) ? $parentCategory->children()->where('is_active', 1)->get() : $data;

        $tree = [];
        foreach ($categories as $category) {
            $tree[] = [
                'id' => $category->id,
                'name' => $category->translate('name'),
                'level' => count(explode('-', $prefix)) - 1,
            ];

            if ($category->children->count()) {
                $tree = array_merge($tree, $model->getTree($category, $prefix . '-'));
            }
        }

        return $tree;
    }

    public function getCategoryForMenu($parentId = null)
    {
        $categories = Category::where('parent_id', $parentId)->get();
        $categoryTree = [];

        foreach ($categories as $category) {
            $categoryTree[] = [
                'id' => $category->id,
                'type' => $category->type,
                'name' => $category->translate('name'),
                'slug' => $category->translate('slug'),
                'childrens' => $this->getCategoryForMenu($category->id), // Đệ quy để lấy các con của category này
            ];
        }

        return $categoryTree;
    }

    public function getCategoryTree($parentId = null)
    {
        $categories = Category::where('parent_id', $parentId)->get();
        $categoryTree = [];

        foreach ($categories as $category) {
            $categoryTree[] = [
                'id' => $category->id,
                'name' => $category->translate('name'),
                'slug' => $category->translate('slug'),
                'childrens' => $this->getCategoryTree($category->id), // Đệ quy để lấy các con của category này
            ];
        }

        return $categoryTree;
    }
}
