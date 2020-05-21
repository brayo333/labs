<?php
    class FileUploader{

        private static $target_directory = "uploads/";
        private static $size_limit = 100000;
        private $uploadOk = true;
        private $file_original_name;
        private $file_tmpName;
        private $file_type;
        private $file_size;
        private $final_file_name;

        public function setOriginalName ($name){
            $this->file_original_name = $name;
        }

        public function getOriginalName() {
            return $this->file_original_name;
        }

        public function setFileTmpName ($name){
            $this->file_tmpName = $name;
        }

        public function getFileTmpName() {
            return $this->file_tmpName;
        }

        public function setFileType ($type){
            $this->file_type = $type;
        }

        public function getFileType() {
            return $this->file_type;
        }

        public function setFileSize ($size){
            $this->file_size = $size;
        }

        public function getFileSize() {
            return $this->file_size;
        }

        public function setFinalFileName ($final_name){
            $this->final_file_name = $final_name;
        }

        public function getFinalFileName() {
            return $this->final_file_name;
        }

        public function uploadFile(){
            $this->fileTypeIsCorrect();
            $this->fileSizeIsCorrect();
            $this->fileAlreadyExists();
            $uploadOk = $this->uploadOk;

            if($uploadOk == true){
                $this->moveFile();
                $uploaded = true;
            }else{
                echo "Unable to upload file";
                $uploaded = false;
            }
            return $uploaded;
        }

        public function fileAlreadyExists(){
            $file_original_name = $this->file_original_name;

            if (file_exists($file_original_name)) {
                echo "Sorry, file already exists.";
                $this->uploadOk = false;
            }
        }

        public function saveFilePathTo(){}

        public function moveFile(){
            $file_original_name = $this->file_original_name;
            $file_tmpName = $this->file_tmpName;
            $target_file = FileUploader::$target_directory.basename($file_original_name);

            if (move_uploaded_file($file_tmpName, $target_file)) {
                // $final_file_path = basename( $file_original_name);
                echo "The file ". basename($file_original_name). " has been uploaded.";
              } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        public function fileTypeIsCorrect(){
            $file_type = $this->file_type;

            if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                $this->uploadOk = false;
            }

        }

        public function fileSizeIsCorrect(){
            $file_size = $this->file_size;

            if ($file_size > FileUploader::$size_limit) {
                echo "Sorry, your file is too large";
                $this->uploadOk = false;
            }

        }

        public function fileWasSelected(){}
    }
?>