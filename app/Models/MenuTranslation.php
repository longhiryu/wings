<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MenuTranslation
 *
 * @property int $id
 * @property string $name
 * @property string $locale
 * @property int $menu_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Menu $menu
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuTranslation extends Model
{
    protected $fillable = ['name', 'locale'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
