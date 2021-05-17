<?php

namespace Modules\Advertisings\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdvertisingCategory
 * @property int $id
 * @package Modules\Advertisings\Entities
 *
 * @property string $name
 * @property string $slug
 * @property int $parent_id
 *
 * Relations
 * @property-read Collection|Advertising[] $advertisings
 */
class AdvertisingCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'slug', 'parent_id'];

    protected $table = 'advertising_categories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Advertising[]
     */
    public function advertisings()
    {
        return $this->hasMany(Advertising::class, 'advertising_category_id');
    }
}
