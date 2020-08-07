<?php
$feedback="";
// check if submit button is selected
if(isset($_POST['submit'])){
	// check if a file is selected to be uploaded
	if(empty($_FILES['file']['name'])):
		// display error message
		$feedback = 'Select a file to upload';
	else:
	//get file information
	$file = $_FILES['file'];
	//get filename
	$fileName= $file['name'];
	//get file location
	$fileTmp= $file['tmp_name'];
	// get file size
	$fileSize= $file['size'];
	// check for errors
	$fileError= $file['error'];
	// get filetype
	$fileType = $file['type'];

 // seperate name from extention
 $getEXT = explode('.', $fileName);
 // get file extention to lowercase
 $fileEXT = strtolower(end($getEXT));
// an array of allowed file types
 $allowedExt = array('jpg', 'jpeg','png');
 // check if a file contains allowed ext
if(in_array($fileEXT, $allowedExt)){
	// check file error
 if($fileError === 0){
	 // check file size
	 if($fileSize < 100000){
		 // set file name
		 $newFileName = $_SESSION['email'].'.'.$fileEXT;
		 //set file path
		 $fileDestination = 'uploads/'.$newFileName;
		 //check if file is moved to final destination
		 if(move_uploaded_file($fileTmp,$fileDestination)){
			 // update profile pic status to uploaded
				header('Location: index.php?upload=success');
		 }else{
			 // display error message
			 $feedback = "file upload failed, try again";
		 }
	 }else{
		 // file size error
		 $feedback = 'file size should be less then 1Mb';
	 }

 }else{
	 // display file upload error
	 $feedback = "file upload failded, try again";
 }
}else{
	// display invalid file type error
 $feedback = 'invalid file type; upload jpeg,jpg or png ';

}
endif;
}


?>
