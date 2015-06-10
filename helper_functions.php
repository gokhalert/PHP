<?php
    
# Connecting to the server

function get_connection() {
    $server = 'opatija.sdsu.edu:3306';
    $user = 'jadrn007’;
    $password = ‘floor’;
    $database = 'jadrn007’;          
    if(!($db = mysqli_connect($server, $user, $password, $database))) 
        die('SQL ERROR: Connection failed: '.mysqli_error($db));
    return $db;
    }    
    
function do_disconnect($db) {
    if($db)
        mysqli_close($db);
        }
               

# It is possible to have two children with the same name, but different parents        
function get_child_id($db) 
{ 
    $parent_id = get_parent_id($db);

    $child_fname       = addcslashes($_POST['child_fname'],"'");
    $child_lname       = addcslashes($_POST['child_lname'],"'");
    
    $child_id_query = "select id from child where parent_id = '$parent_id' and first_name='$child_fname' and last_name='$child_lname'";

    if(!($result = mysqli_query($db,$child_id_query)))
        die('SQL ERROR: '.mysqli_error($db));
    $field = $result->fetch_array();
    $child_id = $field[0];
    return $child_id;
    }   

# Using first name, last name and phone number as the check for duplicates    
function get_parent_id($db) {
   $parent_id_query ="select id from parent where email = '$_POST[email]'";

   if(!($result = mysqli_query($db,$parent_id_query)))
       die('SQL ERROR: '.mysqli_error($db));
   $field = $result->fetch_array();
   $parent_id = $field[0]; 
   return $parent_id;
   }       

                  
function is_duplicate_parent($db) {
    
// Uniqueness of each Parent is determined by his/her EMail ID.
    $check_dup_query = "SELECT first_name, last_name, email FROM parent ";
    $check_dup_query .= "WHERE email='$_POST[email]' ";
   
    if(!($result = mysqli_query($db,$check_dup_query)))
        die('SQL ERROR: '.mysqli_error($db));    
    
    $field = $result->fetch_array(); # get one row of the result set array out
    if(count($field) == 0)
        return false;
    return true;
    }

      
function is_duplicate_child($db) {

    $parent_id = get_parent_id($db);   
    if(!($parent_id)) return false;
    
    $child_fname       = addcslashes($_POST['child_fname'],"'");
    $child_lname       = addcslashes($_POST['child_lname'],"'");

    $check_dup_query  = "SELECT first_name, last_name, parent_id FROM child ";
    $check_dup_query .= "WHERE first_name='$child_fname'";
    $check_dup_query .= "AND last_name='$child_lname'";
    $check_dup_query .= "AND parent_id='$parent_id'";  
          
    if(!($result = mysqli_query($db,$check_dup_query)))
        die('SQL ERROR: '.mysqli_error($db));  
          
    $field = $result->fetch_array(); # get one row of the result set array out
    if(count($field) == 0)
        return false;
    return true;
    }
    
  
function is_duplicate_camp($db)
 {
    $camps = $_POST['camp'];
    $child_id = get_child_id($db);
    foreach($camps as $selected_camp) 
    {
       	$camp_id_query = "select id from camp where description='$selected_camp' ";
			if(!($result = mysqli_query($db,$camp_id_query)))
       					die('SQL ERROR while getting Camp-ID: '.mysqli_error($db));       
		$field = $result->fetch_array(); 
		$camp_id = $field[0]; 

        $camp_check = "SELECT * FROM enrollment WHERE camp_id='$camp_id' ";
        $camp_check .= "AND child_id='$child_id'";
                
        if(!($result = mysqli_query($db,$camp_check)))
            die('SQL ERROR: '.mysqli_error($db));
        $field = $result->fetch_array();
        
        if(count($field) != 0)            
            return true;
    }
        return false;
}    
?>    
