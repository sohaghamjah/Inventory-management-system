<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadAble{
    /**
     * uploadFile function
     *
     * @param UploadedFile $file
     * @param [type] $folder
     * @param [type] $file_name
     * @param string $disk
     * @return fileNameToStore
     */
    public function uploadFile(UploadedFile $file, $folder=null, $file_name=null,$disk='public'){
        if(!Storage::directories($disk.'/'.$folder)){
            Storage::makeDirectory($disk.'/'.$folder,0777,true);
        }
        $fileNameWithExtension = $file->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExtension, PATHINFO_EXTENSION);
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = !is_null($file_name) ? $file_name.'.'.$extension : $fileName.uniqid().'.'.$extension;
        $file->storeAs($folder, $fileNameToStore, $disk);
        return $fileNameToStore;
    }

    public function deleteFile($file_name, $folder, $disk="public"){
        if(Storage::exists($disk.'/'.$folder.$file_name)){
            Storage::disk($disk)->delete($folder.$file_name);
            return true;
        }else{
            return false;
        }
    }
}
