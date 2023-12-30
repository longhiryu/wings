<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\BaseController as AdminApiBaseController;
use App\Http\Resources\Api\Admin\ArticleCollection;
use App\Http\Resources\Api\Admin\ArticleResource;
use App\Models\Article;

class ArticleController extends AdminApiBaseController
{
   public function __construct()
   {
      parent::__construct();
      $this->model = new Article();
      $this->collection = ArticleCollection::class;
      $this->resource = ArticleResource::class;
   }

   // public function index()
   // {
   //    $data = Article::paginate(10);
   //    return new ArticleCollection($data);
   // }
}
