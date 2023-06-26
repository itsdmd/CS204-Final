<?php

class MediaCtrl extends Controller {
    public function uploadMedia() {
        if (isset($_FILES["file"])) {
            $file = $_FILES["file"];
            $file_name = $file["name"];
            $file_tmp_name = $file["tmp_name"];
            $file_size = $file["size"];
            $file_error = $file["error"];

            $file_ext = explode(".", $file_name);
            $file_actual_ext = strtolower(end($file_ext));

            $allowed = array("jpg", "jpeg", "png");

            if (in_array($file_actual_ext, $allowed)) {
                if ($file_error === 0) {
                    if ($file_size < 1000000) {
                        $file_new_name = uniqid("", true) . "." . $file_actual_ext;
                        $file_destination = "./img/uploads/" . $file_new_name;
                        move_uploaded_file($file_tmp_name, $file_destination);

                        $this->addNewUploadFileEntry($file_new_name, $_SESSION['username']);

                        // echo "File uploaded successfully!";
                        return $file_new_name;
                    } else {
                        echo "File is too big!";
                    }
                } else {
                    echo "There was an error uploading your file!";
                }
            } else {
                echo "You cannot upload files of this type!";
            }
        }

        return null;
    }

    public function addNewUploadFileEntry($file_name, $username) {
        $mediaMdl = new MediaMdl($this->conn);
        $mediaMdl->addNewUploadFileEntry($file_name, $username);
    }

    public function getFilePathById($id) {
        $mediaMdl = new MediaMdl($this->conn);
        return $mediaMdl->getFilePathById($id);
    }

    public function getFileIdByPath($path) {
        $mediaMdl = new MediaMdl($this->conn);
        return $mediaMdl->getFileIdByPath($path);
    }
}
