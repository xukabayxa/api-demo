<?php

namespace Modules\Advertisings\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Customers\Entities\Student;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class MyAdvertisingCriteria implements CriteriaInterface
{

    public function __construct()
    {
    }

    /**
     * @param Builder $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        /** @var Student $student */
        $student = auth('student')->user();

        return $student->advertisings();
    }
}

