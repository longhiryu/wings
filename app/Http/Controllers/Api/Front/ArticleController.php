<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Article;
use App\Models\ArticleTranslation;
use App\Http\Resources\Api\Front\ArticleResource;
use App\Http\Resources\Api\Front\ArticleCollection;

class ArticleController extends BaseController
{
    public function __construct()
    {
        $this->model = new Article();
        $this->collection = ArticleCollection::class;
        $this->resource = ArticleResource::class;
        $this->translation = new ArticleTranslation();

        parent::__construct();
    }
}
