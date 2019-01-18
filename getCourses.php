<?php
include ("../include/config.php");
include("../include/functions.php");
if(!empty($_GET['id'])){
        echo'<form>
    		<select>
    		<?php
    		//get content from database
                $query = $db->query("SELECT * FROM courses");
    		while($courseData = $query->fetch()){
    		$coursecode = $courseData[coursecode];
                echo "<option value=\'$coursecode\'>$coursecode</option>";
    		 }
    		 ?>
    		</select>
    	     </form>';
}
   else{
        echo 'Content not found....';
    }
?>