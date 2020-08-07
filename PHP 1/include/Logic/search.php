<?php

//check if search button is set
if(isset($_POST['searchbtn'])){
	//check if search button contains any input
	if(empty($_POST['search'])):
		//redirect to home page with appropriate message
		header('Location: index.php?field=empty');
	else:
		// assign input to $searchWord viriable
		$searchWord = $_POST['search'];
	endif;
// check for validation errors
 if(empty($feedback)){
	 // make a search 
	$searchResult = $display->Search($searchWord);
	// check for search results
	if(!empty($searchResult)){
		$result = new DisplayProfile($searchResult);
			// echo search result
			$result->DisplayProfile();
}
}

}
