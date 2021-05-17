<?php

namespace Modules\Advertisings\Helpers;

use Modules\Advertisings\Entities\AdvertisingCategory;

class AdvertisingCategoryHelper
{
    public static function isHasCategoryChildren($categoryId)
    {
        if (AdvertisingCategory::query()->where('parent_id', $categoryId)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * @param $categoryId
     * @param array $arr
     */
    public static function getParentCategory($categoryId, &$arr = [])
    {
        /** @var AdvertisingCategory $category */
        $category = AdvertisingCategory::query()->find($categoryId);

        $categoryParent = AdvertisingCategory::query()->where('id', $category->parent_id)->first();

        if (!is_null($categoryParent)) {
            array_push($arr, $categoryParent->id);
            self::getParentCategory($categoryParent->id, $arr);
        }

    }

    /**
     * @param $categoryId
     * @param array $arr
     */
    public static function getChildrenCategory($categoryId, &$arr = [])
    {
        /** @var AdvertisingCategory $category */
        $category = AdvertisingCategory::query()->find($categoryId);

        if (!is_null($category)) {
            array_push($arr, $category->id);
        }

        $categoryChilds = AdvertisingCategory::query()->where('parent_id', $category->id)->get();

        if ($categoryChilds->isNotEmpty()) {
            foreach ($categoryChilds as $categoryChild) {
                array_push($arr, $categoryChild->id);
                self::getChildrenCategory($categoryChild->id, $arr);
            }
        }
    }
}
