<?php
/**
 * Created by PhpStorm.
 * User: master
 * Date: 2019-06-20
 * Time: 오전 12:39
 */

namespace App\Traits;


use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public $disk = "s3";

    public $collectionName = "avatar";

    public function setDisk($disk)
    {
        $this->disk = $disk;
    }

    public function setCollectionName($name)
    {
        $this->collectionName = $name;
    }

    public function storeBase64($file)
    {
        $fileName = $this->getFileNameFromBase64($file);

        $decoded = $this->decodeBase64($file);

        return $this->storeFile($fileName, $decoded);
    }

    public function getFileNameFromBase64($file)
    {
        $exploded = explode(',', $file);

        if(str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';

        return str_random().'.'.$extension;
    }

    public function decodeBase64($file)
    {
        $exploded = explode(',', $file);

        return base64_decode($exploded[1]);
    }

    public function storeFile($path, $file)
    {
        Storage::disk($this->disk)->put($path, $file);

        return Storage::disk($this->disk)->url($path);
    }

    public function isAlreadyStoredInMedia($url, $model)
    {
        if(!$model->hasMedia($this->collectionName))
            return false;

        $medias = $model->getMedia($this->collectionName);

        foreach($medias as $media){
            if($media->getUrl() === $url)
                return true;
        }
    }

    public function storeBase64AndAddMedia($file, $model)
    {
        $url = $this->storeBase64($file);

        $model->addMediaFromUrl($url)->toMediaCollection($this->collectionName, $this->disk);
    }
}
