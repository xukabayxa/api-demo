<?php

namespace Modules\Customers\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Modules\Customers\Entities\Student;
use Modules\Files\Entities\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CustomerHelper
{
    /**
     * @param UploadedFile $file
     * @param string $path
     * @param Student $user
     */
    public static function uploadAvatar($file, $user, $path)
    {
        $file_name = uniqid() . '-' . $file->getClientOriginalName();

        Storage::disk('public')->put($path. '/' . $file_name, file_get_contents($file));

        $fileData['name'] = $file_name;
        $fileData['path'] = $path . '/' . $file_name;
        $fileData['path_thumbnail'] = '';
        $fileData['fileable_id'] = $user->id;
        $fileData['fileable_type'] = get_class($user);

        $image = new File($fileData);
        $image->save();
    }

    /**
     * @param Student $user
     * @param array $fileIds
     */
    public static function updateAvatar($user, $fileIds)
    {
        $fileIdsCurrent = File::query()
            ->where([
                'fileable_id' => $user->id,
                'fileable_type' => get_class($user)
            ])
            ->pluck('id')
            ->toArray();

        $IdsDiff = array_diff($fileIdsCurrent, $fileIds);

        File::query()->whereIn('id', $IdsDiff)->delete();
    }

}


?>
