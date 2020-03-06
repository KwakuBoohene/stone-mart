<?php

function uploadImage(){
    //the directory/path of the image
    $folderName = "../image/";
    //fileName: a variable with the folder name and the name of the image
    //fileToUpload: is the name of the input in the form
    //name: specifies the name of the file that is being uploaded
    //concatenate (join) the foldername and the file name 
    $fileName = $folderName . basename($_FILES["fileToUpload"]["name"]);
    //set a variable 'uploadOk' and make it equal to 1. 
    //this variable will be used later to know whether the file can be successfully uploaded or not
    $uploadOk = 1;
    //imageFileType: this variale stores the extension of the image used
    $imageFileType = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    //when the upload image button is submitted/clicked..
    if(isset($_POST["addProduct"])) {
        //get the dimensions of the image and store it in the variable '$check'
        $fileDimensions = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($fileDimensions !== false) {
             echo "File is an image - " . $fileDimensions["mime"] . ".";
            // print_r($fileDimensions);
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
            return false;
        }
    }
    // Check if file already exists
    if (file_exists($fileName)) {
        echo "Picture already exists. Record will still be entered without picture <br>";
        $uploadOk = 0;
        $fileName = basename( $_FILES["fileToUpload"]["name"]);
        return false;
    }

    // Check file size
    //check if its greater than 1500kb
    if ($_FILES["fileToUpload"]["size"] > 1500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        return false;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        return false;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fileName)) {
            $image = basename( $_FILES["fileToUpload"]["name"]);
            echo "The file ". $image. " has been uploaded. <br>"; 
            return $image;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}



?>