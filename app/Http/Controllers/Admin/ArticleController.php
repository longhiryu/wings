<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Http\Requests\Admin\CreateArticleRequest;
use App\Http\Requests\Admin\UpdateArticleRequest;
use App\Models\ArticleTranslation;
use DB;

class ArticleController extends BaseController
{
    public function __construct()
    {
        $this->model = new Article();
        parent::__construct();
    }

    public function store(CreateArticleRequest $request)
    {
        $data = $request->all();

        return $this->insert_data($data);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        // dd($request);
        $data = $request->all();

        return $this->insert_data($data, $article);
    }

    public function cleanCotent()
    {
        $data = ArticleTranslation::select('id','long_description')->get();

        foreach ($data as $value) {
            $clean = preg_replace("/<img[^>]+\>/i", "(image) ", $value->long_description);

            DB::table('article_translations')->where('id',$value->id)->update(['long_description' => $clean]);
        }
    }
}
