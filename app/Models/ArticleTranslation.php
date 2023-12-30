<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArticleTranslation
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $locale
 * @property string $slug
 * @property int $article_id
 * @property string|null $image
 * @property string|null $short_description
 * @property string|null $long_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Article $article
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereLongDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleTranslation extends Model
{
    protected $fillable = [
        'name',
        'title',
        'locale',
        'slug',
        'image',
        'short_description',
        'long_description'
    ];
    use HasFactory;

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
