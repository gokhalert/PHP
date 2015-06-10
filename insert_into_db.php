<?php
include 'php_functions.php';

$server = 'opatija.sdsu.edu:3306';
$user = 'jadrn007’;
$password = ‘floor’;
$database = 'jadrn007’;    

if(!($db = mysqli_connect($server, $user, $password, $database)))
   		write_error_page("Error Connecting to DataBase");

$parent_fname       = addcslashes($parent_fname,"'");
$parent_lname       = addcslashes($parent_lname,"'");
$city               = addcslashes($city,"'");
$child_fname        = addcslashes($child_fname,"'");
$child_lname        = addcslashes($child_lname,"'");
$emergency_name     = addcslashes($emergency_name,"'");
$image_unique_name  = addcslashes($image_unique_name,"'");

$parent_id_query ="select id from parent where email = '$email' ";
$result = mysqli_query($db,$parent_id_query);
$field = $result->fetch_array(); 
$parent_id = $field[0]; 

if (!$parent_id)		// Parent NOT in DB
{	
	// 1. Inserting Parent
	$sql_insert_parent="INSERT INTO parent
				        VALUES ('','$parent_fname','$parent_mname','$parent_lname','$relation','$address1','$address2','$city','$state','$zip','$homephone','$cellphone','$email')";

	if (!mysqli_query($db,$sql_insert_parent))
 		write_error_page("Error while inserting Parent Record");
 	
	echo "<br><span>New Parent Registed !</span>";

	// 2. Inserting Child 
	if(!($result = mysqli_query($db,"select id from parent where email = '$email' ")))
        write_error_page("Error while getting Parent Record");
	$field = $result->fetch_array(); 
	$parent_id = $field[0];    
	
	$sql_insert_child="INSERT INTO child VALUES ('','$parent_id','$child_fname','$child_mname','$child_lname','$nickname','$image_unique_name','$gender','$birthdate','$medical','$dietary','$emergency_name','$emergency_phone')"; 
	if (!mysqli_query($db,$sql_insert_child))
 		write_error_page("Error while inserting Child Record");		
	echo "<br><span> New Child Registered !</span><br>";

	// 3. Inserting Child ID & Camp ID into Enrollment table
	// Getting Child-ID
	$child_id_query = "select id from child where first_name='$child_fname' and parent_id = '$parent_id' and last_name='$child_lname'";
	if(!($result = mysqli_query($db,$child_id_query)))
       write_error_page("Error while getting Child-ID"); 
	$field = $result->fetch_array(); 
	$child_id = $field[0]; 

	// Do it for each camp user has selected in form
              for($i=0; $i < $N; $i++)
               {  
		$camp_id_query = "select id from camp where description='$camp[$i]' ";
		if(!($result = mysqli_query($db,$camp_id_query)))
       		write_error_page("Error while getting Camp-ID");      
		$field = $result->fetch_array(); 
		$camp_id = $field[0];  

		$sql_join_camp = "insert into enrollment values('$camp_id', '$child_id')";
   		if(!(mysqli_query($db, $sql_join_camp)))
       		write_error_page("Error while enrolling kid into a Camp");        
               echo "<br><span>Child <strong>added</strong> to '$camp[$i]' Camp</span>";
	       }
            }
          else 	//	Parent in DB
           {
	    echo "<span>Parent is already registered with Us !</span><br>";
		$child_id_query = "select id from child where parent_id = '$parent_id' and first_name = '$child_fname' and last_name = '$child_lname' ";
		$result = mysqli_query($db,$child_id_query);
		$field = $result->fetch_array();
		$child_id = $field[0];
		
		if (!$child_id)		// Child NOT in DB
		{
			// 1. Insert Child
			$sql_insert_child="INSERT INTO child 
				               VALUES ('','$parent_id','$child_fname','$child_mname','$child_lname','$nickname','$image_unique_name','$gender','$birthdate','$medical','$dietary','$emergency_name','$emergency_phone')"; 

			if (!mysqli_query($db,$sql_insert_child))
 				write_error_page("Error while inserting Child Record");			
			echo "<span>New Child registered !</span><br>";

			// 2. Enroll child in camp
			$child_id_query = "select id from child where first_name='$child_fname' and parent_id = '$parent_id' and last_name='$child_lname'";
			if(!($result = mysqli_query($db,$child_id_query)))
       			write_error_page("Error while getting Child-ID"); 
			$field = $result->fetch_array(); // get the result set array out
			$child_id = $field[0];    // there's just one field

			// Do it for each camp user has selected in form
   			for($i=0; $i < $N; $i++)
   				{  
					$camp_id_query = "select id from camp where description='$camp[$i]' ";
					if(!($result = mysqli_query($db,$camp_id_query)))
       					write_error_page("Error while getting Camp-ID");      
					$field = $result->fetch_array(); // get the result set array out
					$camp_id = $field[0];    // there's just one field 

					$sql_join_camp = "insert into enrollment values('$camp_id', '$child_id')";
   					if(!(mysqli_query($db, $sql_join_camp)))
       					write_error_page("Error while enrolling Child into Camp"); 
        			echo "<br><span>Child <strong>added</strong> to '$camp[$i]' Camp</span>";
				}		
		}
		else		// Child in DB
		{ 	echo "<span>Child is already registered with US !</span> <br>";
			for($i=0; $i < $N; $i++)
   				{  
					$camp_id_query = "select id from camp where description='$camp[$i]' ";
					if(!($result = mysqli_query($db,$camp_id_query)))
       					write_error_page("Error while getting Camp-ID");       
					$field = $result->fetch_array(); // get the result set array out
					$camp_id = $field[0];    // there's just one field 

					$camp_enrolled = "select camp_id from enrollment where child_id = '$child_id' and camp_id ='$camp_id'";
					$result = mysqli_query($db,$camp_enrolled);
					$field = $result->fetch_array(); // get the result set array out
					$enrollment_camp_id = $field[0];
					if(!$enrollment_camp_id) // Child not enrolled in that camp
						{
						//	echo "Child not in Camp";
							$sql_join_camp = "insert into enrollment values('$camp_id', '$child_id')";
		   					if(!(mysqli_query($db, $sql_join_camp)))
       							write_error_page("Error while enrolling Child into Camp"); 
        					echo "<br><span>Child <strong> added</strong> to '$camp[$i]' Camp</span>";
        				}
        			else	// Child enrolled in that camp
        				{
        					echo "<br><span> Child <em>already</em> enrolled in '$camp[$i]' Camp</span>";
        				}
				}		
		}
}        
mysqli_close($db);
?>
