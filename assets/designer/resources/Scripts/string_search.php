<?php
	
// since this is a one page tutorial 
// we're not seperating out the database connection

$db_host 		= 'localhost';
$db_user 		= 'root';
$db_password 	= '';
$db_name 		= 'tutorial_db';
	
	
$db = new mysqli($db_host , $db_user ,$db_password, $db_name);

if(!$db) {
	// If there is an error, show this message.
	
	echo 'There was a problem connecting to the database';
} else {
	
	// Check the user has typed something in our input box.
	if(isset($_POST['mysearchString'])) {
		$mysearchString = $db->real_escape_string($_POST['mysearchString']);
		
		// Is the string length greater than 0?
		
		if(strlen($mysearchString) >0) {
			
			// Now we have the string the user entered, we want to
			// be able to use this to search in our database
			// so we use the percentage as the wildcare and use a variable 
			// in the query.
			
			$query = $db->query("SELECT band_name 
								 FROM tutorial_db 
								 WHERE band_name 
								 LIKE '$mysearchString%' 
								 LIMIT 20"); // limits our results list to 20.
			
			if($query) {
				
				// so while there are results from the query
				// we loop through the results and fill out our list items
				
				while ($result = $query ->fetch_object()) {
					
					// create a list item, but also listen for the user clicking 
					// the result so we can fill the text box.
					echo '<li onClick="fill(\''.$result->band_name.'\');">'.$result->band_name.'</li>';
				}
			} else {
				echo 'ERROR: There was a problem with the query.';
			}
		} else {
			// Dont do anything.
		} 
	} else {
		echo 'Access denied.';
	}
}
?>