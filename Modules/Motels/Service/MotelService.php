<?php

namespace Modules\Motels\Service;


use App\Helpers\UploadImageHelper;
use Modules\Comments\Entities\Comment;
use Modules\Customers\Entities\Student;
use Modules\Motels\Entities\Motel;
use Modules\Motels\Repositories\MotelRepository;

/**
 * Class MotelService
 * @package Modules\Motels\Service
 */
class MotelService
{
    protected $motelRepository;

    public function __construct(MotelRepository $motelRepository)
    {
        $this->motelRepository = $motelRepository;
    }

    /**
     * @param $data
     * @param Student $student
     * @param null $files
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createMotel($data, $student, $schoolIds, $files = null)
    {
        $data['creatable_id'] = $student->id;
        $data['creatable_type'] = Student::class;

        /** @var Motel $motel */
        $motel = $this->motelRepository->create($data);

        $motel->schools()->sync($schoolIds);

        if (!empty($files)) {
            foreach ($files as $file) {
                UploadImageHelper::uploadImage($file, $motel, 'Motels');
            }
        }

        return $motel;
    }

    /**
     * @param $motel
     * @param $data
     * @param $schoolIds
     * @param $file_ids
     * @param $files
     * @return Motel
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateMotel($motel, $data, $schoolIds, $file_ids, $files)
    {
        $motel = $this->motelRepository->update($data, $motel->id);

        $motel->schools()->sync($schoolIds);

        if (!empty($file_ids)) {
            UploadImageHelper::updateImage($motel, $file_ids);
        }

        if (!empty($files)) {

            foreach ($files as $file) {
                UploadImageHelper::uploadImage($file, $motel, 'Motels');
            }

        }
        return $motel;
    }

    /**
     * @param Motel $motel
     * @param $commentId
     * @param $data
     * @return mixed
     */
    public function feedbackComment($motel, $commentId, $data)
    {
        /** @var Comment $comment */
        $comment = $motel->comments()->find($commentId);

        if ($comment->parent_id == 0) {
            $data['parent_id'] = $comment->id;
        } else {
            $commentParent = $motel->comments()->find($comment->parent_id);

            if ($commentParent->parent_id == 0) {
                $data['parent_id'] = $commentId;
            } else {
                $data['parent_id'] = $comment->parent_id;
            }

//            $data['parent_id'] = $commentParent->id;
        }

        $motel->comments()->create($data);

        return $motel;
    }
}
