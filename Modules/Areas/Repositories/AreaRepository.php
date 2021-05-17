<?php

namespace Modules\Areas\Repositories;

use Modules\Areas\Entities\Area;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AreaRepository
 * @package Modules\Platform\User\Repositories
 */
class AreaRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Area::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return Area
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
     * @return Area
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}