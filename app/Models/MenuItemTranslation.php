<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MenuItemTranslation
 *
 * @property int $id
 * @property string $name
 * @property string $locale
 * @property int $menu_item_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation whereMenuItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuItemTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuItemTranslation extends Model
{
    protected $fillable = ['name', 'locale', 'menu_item_id'];
}
