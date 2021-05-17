<?php

namespace Modules\Comments\Repositories;

use Modules\Comments\Entities\Comment;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CommentRepository
 * @package Modules\Platform\User\Repositories
 */
class CommentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return Comment
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
     * @return Comment
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}