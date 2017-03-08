<meta charset="UTF-8">
<?php  
	if (isset($_POST['ok'])) {
		// Get file content
	    $file = file_get_contents($_POST['link']);
	    preg_match_all("/<p>(.*)<\/p>/", $file, $result);

	    // a new MongoDB connection
	    $conn = new MongoClient("mongodb://localhost:27017");
	    // connect to dictionary database
	    $collection = $conn->dictionary->characters;

	    // Translate
	    foreach ($result[1] as $item) {
	      $source = $item;    
	      $target = "";
	      for ($i = 0; $i < mb_strlen($source, 'UTF-8'); $i++) {
	          $ch = mb_substr($source, $i, 1, 'UTF-8');
	          if (preg_match("/\p{Han}+/u", $ch)) {
	            $character = $collection->findOne(array('character' => $ch));
	            if ($character) {
	              $target .= $character['mean'].' ';
	            } else {
	              $target .= $ch;
	            }
	          } else {
	            $target .= $ch;
	          }
	        }
	      echo "<p>$source</p>";
	      echo "<p>$target</p>";
	    }
	}
?>

<form method="POST" action="#">
	Link: <input type="text" name="link" size="30" /><br /><br />
	<input type="submit" name="ok" value="Dịch" />
</form>
