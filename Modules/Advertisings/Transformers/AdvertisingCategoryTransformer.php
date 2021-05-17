<?php

namespace Modules\Advertisings\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Advertisings\Entities\Advertising;
use Modules\Advertisings\Entities\AdvertisingCategory;

class AdvertisingCategoryTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    protected $defaultIncludes = ['category_children'];

    public function transform(AdvertisingCategory $advertisingCategory)
    {
        return [
            'id' => $advertisingCategory->id,
            'name' => $advertisingCategory->name,
            'slug' => $advertisingCategory->slug,
            'parent_id' => $advertisingCategory->parent_id
        ];
    }

    public function includeCategoryChildren(AdvertisingCategory $advertisingCategory)
    {
        $categoryChilds = AdvertisingCategory::query()->where('parent_id', $advertisingCategory->id)->get();

        return $categoryChilds ? $this->collection($categoryChilds, new AdvertisingCategoryTransformer()) : $this->primitive(null);
    }
}
