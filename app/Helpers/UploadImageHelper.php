<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Storage;
use Modules\Customers\Entities\Student;
use Modules\Files\Entities\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageHelper
{
    /**
     * @param UploadedFile $file
     * @param string $path
     * @param $create
     */
    public static function uploadImage($file, $create, $path)
    {
        $file_name = uniqid() . '-' . $file->getClientOriginalName();

        Storage::disk('public')->put($path. '/' . $file_name, file_get_contents($file));

        $fileData['name'] = $file_name;
        $fileData['path'] = $path . '/' . $file_name;
        $fileData['path_thumbnail'] = '';
        $fileData['fileable_id'] = $create->id;
        $fileData['fileable_type'] = get_class($create);

        $image = new File($fileData);
        $image->save();
    }

    /**
     * @param $create
     * @param array $fileIds
     */
    public static function updateImage($create, $fileIds)
    {
        $fileIdsCurrent = File::query()
            ->where([
                'fileable_id' => $create->id,
                'fileable_type' => get_class($create)
            ])
            ->pluck('id')
            ->toArray();

        $IdsDiff = array_diff($fileIdsCurrent, $fileIds);

        File::query()->whereIn('id', $IdsDiff)->delete();
    }
}
