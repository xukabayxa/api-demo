<?php

namespace Modules\Jobs\Repositories;

use Modules\Jobs\Entities\Job;
use Modules\Jobs\Entities\JobCategory;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class JobRepository
 * @package Modules\Platform\User\Repositories
 */
class JobCategoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return JobCategory::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return Job
     */
    public function create(array $attributes)
    {
        return parent::create($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return Job
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}
