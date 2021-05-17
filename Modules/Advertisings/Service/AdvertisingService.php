<?php

namespace Modules\Advertisings\Service;

use App\Helpers\UploadImageHelper;
use Modules\Advertisings\Entities\Advertising;
use Modules\Advertisings\Helpers\AdvertisingCategoryHelper;
use Modules\Advertisings\Repositories\AdvertisingRepository;
use Modules\Comments\Entities\Comment;
use Modules\Customers\Entities\Student;

class AdvertisingService
{
    protected $repository;

    public function __construct(AdvertisingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @param $student
     * @param $schoolIds
     * @param $files
     * @return Advertising
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createAdvertising($data, $student, $schoolIds, $files)
    {
        $data['creatable_id'] = $student->id;
        $data['creatable_type'] = Student::class;

        if (AdvertisingCategoryHelper::isHasCategoryChildren($data['advertising_category_id'])) {
            throw new \Exception("can't choose this category because this category has children category");
        }

        /** @var Advertising $advertising */
        $advertising = $this->repository->create($data);

        $advertising->schools()->sync($schoolIds);

        if (!empty($files)) {
            foreach ($files as $file) {
                UploadImageHelper::uploadImage($file, $advertising, 'Advertisings');
            }
        }

        return $advertising;
    }

    /**
     * @param $advertising
     * @param $data
     * @param $schoolIds
     * @param $file_ids
     * @param $files
     * @return Advertising
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateAdvertising($advertising, $data, $schoolIds, $file_ids, $files)
    {
        if (AdvertisingCategoryHelper::isHasCategoryChildren($data['advertising_category_id'])) {
            throw new \Exception("can't choose this category because this category has children category");
        }

        $advertising = $this->repository->update($data, $advertising->id);

        $advertising->schools()->sync($schoolIds);

        if (!empty($file_ids)) {
            UploadImageHelper::updateImage($advertising, $file_ids);
        }

        if (!empty($files)) {

            foreach ($files as $file) {
                UploadImageHelper::uploadImage($file, $advertising, 'Advertisings');
            }

        }
        return $advertising;
    }

    /**
     * @param Advertising $advertising
     * @param $commentId
     * @param $data
     * @return mixed
     */
    public function feedbackComment($advertising, $commentId, $data)
    {
        /** @var Comment $comment */
        $comment = $advertising->comments()->find($commentId);

        if ($comment->parent_id == 0) {
            $data['parent_id'] = $comment->id;
        } else {
            $commentParent = $advertising->comments()->find($comment->parent_id);

            if ($commentParent->parent_id == 0) {
                $data['parent_id'] = $commentId;
            } else {
                $data['parent_id'] = $comment->parent_id;
            }

//            $data['parent_id'] = $commentParent->id;
        }

        $advertising->comments()->create($data);

        return $advertising;
    }
}
