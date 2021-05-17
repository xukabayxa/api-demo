<?php

namespace Modules\Jobs\Helpers;

use Modules\Jobs\Entities\JobCategory;

class JobCategoryHelper
{
    public static function isHasCategoryChildren($categoryId)
    {
        if (JobCategory::query()->where('parent_id', $categoryId)->exists()) {
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
        /** @var JobCategory $category */
        $category = JobCategory::query()->find($categoryId);

        $categoryParent = JobCategory::query()->where('id', $category->parent_id)->first();

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
        /** @var JobCategory $category */
        $category = JobCategory::query()->find($categoryId);

        if (!is_null($category)) {
            array_push($arr, $category->id);
        }

        $categoryChilds = JobCategory::query()->where('parent_id', $category->id)->get();

        if ($categoryChilds->isNotEmpty()) {
            foreach ($categoryChilds as $categoryChild) {
                array_push($arr, $categoryChild->id);
                self::getChildrenCategory($categoryChild->id, $arr);
            }
        }
    }
}
