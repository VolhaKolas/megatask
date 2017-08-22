<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 25.05.17
 * Time: 15:54
 */

namespace Core;


class Upload
{
    private $fileName;
    private $from;
    private $to;
    private $folderName;
    private $file;
    private $name;


    public function startupload($file, $q_id){
        $this->file = $file;
        if($this->file['name'] != null) {
            $this->folderName = "files/" . $q_id;
            if (!is_dir($this->folderName)) {
                mkdir($this->folderName);
            }

            $this->fileName = $this->file["name"];
            $this->from = $this->file["tmp_name"];
            $this->to = $this->folderName . "/" . sha1($this->fileName);
            $this->uploadfile($this->from, $this->to);
        }
    }

    private function uploadfile($from, $to){
        if(move_uploaded_file($from, $to)){
            return true;
        }
    }
}