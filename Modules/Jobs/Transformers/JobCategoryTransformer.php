<?php

namespace Modules\Jobs\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Advertisings\Entities\AdvertisingCategory;
use Modules\Jobs\Entities\JobCategory;

class JobCategoryTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    protected $defaultIncludes = ['category_children'];

    public function transform(JobCategory $jobCategory)
    {
        return [
            'id' => $jobCategory->id,
            'name' => $jobCategory->name,
            'slug' => $jobCategory->slug,
            'parent_id' => $jobCategory->parent_id
        ];
    }

    public function includeCategoryChildren(JobCategory $jobCategory)
    {
        $categoryChilds = JobCategory::query()->where('parent_id', $jobCategory->id)->get();

        return $categoryChilds ? $this->collection($categoryChilds, new JobCategoryTransformer()) : $this->primitive(null);
    }
}
