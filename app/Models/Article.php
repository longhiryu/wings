<?php

namespace App\Models;

use App\Traits\HasTranslated;
use App\Traits\Livewire\HasCategory;
use App\Traits\Livewire\HasChannel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $is_active
 * @property int $viewed
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Channel[] $channels
 * @property-read int|null $channels_count
 * @property-read \App\Models\ArticleTranslation|null $translated
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereViewed($value)
 * @mixin \Eloquent
 */
class Article extends BaseModel
{
    use HasTranslated, SoftDeletes, HasChannel, HasCategory;

    protected $fillable = [
        'category_id',
        'file_id',
        'is_active',
        'viewed'
    ];

    public $translatedModel = ArticleTranslation::class;

    protected $with = ['translated'];

    public function translatedModel()
    {
        return new ArticleTranslation();
    }

    public function file(){
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
