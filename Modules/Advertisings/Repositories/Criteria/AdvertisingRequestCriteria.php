<?php

namespace Modules\Advertisings\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Advertisings\Helpers\AdvertisingCategoryHelper;
use Modules\Customers\Entities\Student;
use Modules\Motels\Entities\Motel;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class AdvertisingRequestCriteria implements CriteriaInterface
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->request->get('title')) {
            $title = $this->request->get('title');

            $model = $model->where('title', 'LIKE', "%{$title}%");
        }

        if ($this->request->get('address')) {
            $address = $this->request->get('address');

            $model = $model->where('address', 'LIKE', "%{$address}%");
        }

        if ($this->request->get('area_id')) {
            $areaId = $this->request->get('area_id');

            $model = $model->where('area_id', $areaId);
        }

        if ($this->request->get('intent_id')) {
            $intentId = $this->request->get('intent_id');

            $model = $model->where('intent_id', $intentId);
        }

        if ($this->request->get('status_id')) {
            $statusId = $this->request->get('status_id');

            $model = $model->where('status_id', $statusId);
        }

        if ($this->request->get('school_ids')) {
            $schoolIds = explode(',', $this->request->get('school_ids'));

            $model = $model->whereHas('schools', function (Builder $query) use ($schoolIds) {
                $query->whereIn('school_id', $schoolIds);
            });
        }

        if ($this->request->get('category_ids')) {
            $categoryIds = explode(',', $this->request->get('category_ids'));
            $cateIds = [];
            foreach ($categoryIds as $categoryId) {
                AdvertisingCategoryHelper::getChildrenCategory($categoryId, $cateIds);
            }

            $model = $model->whereIn('advertising_category_id', array_unique($cateIds));
        }

        return $model;

    }
}

