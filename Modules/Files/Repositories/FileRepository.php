<?php

namespace Modules\Files\Repositories;

use Modules\Files\Entities\File;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class FileRepository
 * @package Modules\Platform\User\Repositories
 */
class FileRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return File::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return File
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
     * @return File
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}