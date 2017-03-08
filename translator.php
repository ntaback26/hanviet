<?php
	// Get collection
	$conn = new MongoClient();
	$db = $conn->hanviet;
	$collection = $db->characters;

	// Source text
	$source = $_POST['source']; 

	// Find all chinese characters in source text
	$chineseCharacters = [];
	for ($i = 0; $i < mb_strlen($source, 'UTF-8'); $i++) { // loop UTF-8 string
		$ch = mb_substr($source, $i, 1, 'UTF-8');
	  	if (preg_match("/\p{Han}+/u", $ch)) { // if character is Chinese character
		    array_push($chineseCharacters, $ch);
	  	} 
	}
	array_unique($chineseCharacters);

	// Translate
	$target = $source;
	$dbCharacters = $collection->find(['character' => ['$in' => $chineseCharacters]]);
	foreach ($dbCharacters as $dbCharacter) {
		$target = str_replace($dbCharacter['character'], $dbCharacter['mean'].' ', $target);
	}

   	$conn->close();

   	// Target text
   	echo $target;