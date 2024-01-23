<?php
namespace App\Trait;

trait AttachmentTrait{
    function saveAttach($file,$folderPath){
        $original_name = $file->getClientOriginalName();
        $attach_file_name = $original_name;
        $avatar_path = $folderPath;
        $file->move(public_path($avatar_path),$attach_file_name);
        return $attach_file_name;
    }
    
    function saveBook($file,$folderPath,$fileName){ ///عشان اخزن اسم الفايل علي السيرفر بنفس اسمه
        
        $original_name = $fileName.'.pdf';
        $attach_file_name = $original_name;
        $avatar_path = $folderPath;
        $file->move(public_path($avatar_path),$attach_file_name);
        return $attach_file_name;
    }
}
?>