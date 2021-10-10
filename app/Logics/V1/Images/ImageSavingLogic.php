<?php

//
//namespace App\Logics;
//
//
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Str;
//
//class ImageSavingLogic
//{
////    private $BASE_IMAGE_DIR_PATH = "asset";
//    private $typeOfEntity;
//
//    public function __construct(string $typeOfEntity)
//    {
//        $this->typeOfEntity = strtolower(Str::plural($typeOfEntity));
//    }
//
//    /**
//     * @param bool $isBase64
//     * @param $content
//     * @param $folderName
//     * @return string
//     * @throws \Throwable
//     */
//    public function store($content, $folderName, bool $isBase64 = false): string
//    {
//        return $isBase64
//            ? ($this->createBase64($content, $folderName))
//            : ($this->storeImage($content, $folderName));
//    }
//
//
//    /**
//     * @param $content
//     * @param $folderName
//     * @return string
//     * @throws \Throwable
//     */
//    private function storeImage($content, $folderName): string
//    {
//        try {
//            $path = $this->pathBuilder($folderName);
//            $ext = $content->getClientOriginalExtension();
//            $fileName = uniqid($this->typeOfEntity . "_") . ".$ext";
//            Storage::disk('local')->put("$path/$fileName", $content);
//            return "$path/$fileName";
//        } catch (\Throwable $th) {
//            throw $th;
//        }
//    }
//
//    /**
//     * @param $folderName
//     * @return string
//     */
//    private function pathBuilder($folderName): string
//    {
//        return "app/assets/$this->typeOfEntity/$folderName";
//    }
//
//    /**
//     * @param $base64file
//     * @param $folderName
//     * @return string
//     */
//    private function createBase64($base64file, $folderName): string
//    {
//        $explode = explode(";", $base64file);
//        $explode = explode("/", $explode[0]);
//        $extension = $explode[1];
//        $fileName = "assets/images/lottery/users_profile/{$folderName}/" . uniqid("lottery_");
//        $fileNewName = $fileName . "." . $extension;
//        $base64file = str_replace("data:image/" . $extension . ";base64,", '', $base64file);
//        Storage::disk('public')->put($fileNewName, base64_decode($base64file));
//        return $fileNewName;
//    }
//}


namespace App\Logics;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageSavingLogic
{
//    private $BASE_IMAGE_DIR_PATH = "asset";
    private $typeOfEntity;
    public $name;

    /**
     * ImageSavingLogic constructor.
     * @param string $typeOfEntity
     */
    public function __construct(string $typeOfEntity, $name = "lottery")
    {
        $this->typeOfEntity = strtolower(Str::plural($typeOfEntity));
        $this->name = $name;
    }

    /**
     * @param bool $isBase64
     * @param $content
     * @param $folderName
     * @return string
     * @throws \Throwable
     */
    public function store($content, $folderName, bool $isBase64 = false): string
    {
        return $isBase64
            ? ($this->createBase64($content, $folderName))
            : ($this->storeImage($content, $folderName));
    }


    /**
     * @param $content
     * @param $folderName
     * @return string
     * @throws \Throwable
     */
    private function storeImage($content, $folderName): string
    {
        try {
//            $path = $this->pathBuilder($folderName);
            $ext = $content->getClientOriginalExtension();
//            $fileName = uniqid($this->typeOfEntity . "_") . ".$ext";
            $path = "{$this->name}/{$folderName}/$this->typeOfEntity/" . uniqid($this->name . "_");
            $file = $path . "." . $ext;
            Storage::disk('local')->put($file, $content);
            return $file;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param $folderName
     * @return string
     */
    private function pathBuilder($folderName): string
    {
        return "app/assets/$this->typeOfEntity/$folderName";
    }

    /**
     * @param $base64file
     * @param $folderName
     * @return string
     */
    private function createBase64($base64file, $folderName): string
    {
        $explode = explode(";", $base64file);
        $explode = explode("/", $explode[0]);
        $extension = $explode[1];
//        $fileName = "assets/images/lottery/users_profile/{$folderName}/" . uniqid("lottery_");
        $fileName = "{$this->name}/{$folderName}/$this->typeOfEntity/" . uniqid($this->name . "_");
        $fileNewName = $fileName . "." . $extension;
        $base64file = str_replace("data:image/" . $extension . ";base64,", '', $base64file);

        Storage::disk('local')->put($fileNewName, base64_decode($base64file));
        return $fileNewName;
    }
}
