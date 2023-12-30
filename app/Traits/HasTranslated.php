<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

trait HasTranslated
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasTranslated()
    {
        // static::saved(function ($entity) {
        //     $translatedModel = $entity->translatedModel();

        //     $data = request('data');
        //     $data['slug'] = Str::slug($data['name']);
        //     $data['title'] = (isset($data['title']) && $data['title'] != null) ? $data['title'] : $data['name'];

        //     foreach ($translatedModel->getFillable() as $field) {
        //         $translatedModel->$field = $data[$field];
        //     }

        //     if ($entity->translated()->exists()) {
        //         $entity->translated()->update(collect($data)->only($translatedModel->getFillable())->toArray());
        //     } else {
        //         $entity->translated()->save($translatedModel);
        //     }
        // });

        // static::retrieved(function ($entity) {
        //     $translatedModel = $entity->translatedModel();
        //     if ($entity->translated == null) {
        //         $entity->translated = $translatedModel;
        //     }
        // });
    }

    public function translated()
    {
        return $this->hasOne(get_class($this->translatedModel()))->where('locale', '=', Config::get('app.locale'));
    }

    public function translate(string $key)
    {
        return ($this->translated != null) ? $this->translated->$key : null;
    }
}
