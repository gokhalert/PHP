 <?php

		$error_flag = 0;
		require_once('php_functions.php');

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{

	session_start();
	// Program Selected
	$_SESSION['camp'] =$camp= $_POST['camp'];

	// Parent_Details
	$_SESSION['parent_fname'] = $parent_fname = $_POST['parent_fname'];
	$_SESSION['parent_mname'] =$parent_mname = $_POST['parent_mname'];
	$_SESSION['parent_lname'] =$parent_lname = $_POST['parent_lname'];
	$_SESSION['relation'] = $relation = $_POST['relation'];
	$_SESSION['address1'] = $address1 = $_POST['address1'];
	$_SESSION['address2'] = $address2 = $_POST['address2'];
	$_SESSION['city'] = $city = $_POST['city'];
	$_SESSION['state'] = $state = $_POST['statesdropdown'];
	$_SESSION['zip'] = $zip = $_POST['zip'];
	$_SESSION['homephone'] = $homephone = $_POST['homephone'];
	$_SESSION['cellphone'] = $cellphone = $_POST['cellphone']; 
	$_SESSION['email'] = $email = $_POST['email'];

	// Child Details
	$_SESSION['child_fname'] = $child_fname = $_POST['child_fname'];
	$_SESSION['child_mname'] = $child_mname = $_POST['child_mname'];
	$_SESSION['child_lname'] = $child_lname = $_POST['child_lname'];
	$_SESSION['nickname'] = $nickname = $_POST['nickname'];
	
	$_SESSION['image'] = $image = $_FILES['image']['name'];
	$image_size   = $_FILES['image']['size'];
	$image_error  = $_FILES['image']['error'];
	
	$_SESSION['gender'] = $gender = $_POST['gender'];
	$_SESSION['birthdate'] = $birthdate = $_POST['daydropdown'].$_POST['monthdropdown'].$_POST['yeardropdown'];
	$_SESSION['medical'] = $medical = $_POST['medical'];
	$_SESSION['dietary'] = $dietary = $_POST['dietary'];
	$_SESSION['emergency_name'] = $emergency_name = $_POST['emergency_name'];
	$_SESSION['emergency_phone'] = $emergency_phone = $_POST['emergency_phone'];

	$day   = $_POST['daydropdown'];
	$m     = $_POST['monthdropdown'];
	$year  = $_POST['yeardropdown'];

  	  check_camp($camp, $error_flag);
      check_parent_fname($parent_fname, $error_flag);
   	  check_parent_lname($parent_lname, $error_flag);
   	  check_relation($relation, $error_flag);
      check_email($email, $error_flag);
   	  check_child_fname($child_fname, $error_flag);
  	  check_child_lname($child_lname, $error_flag);
	  check_image($image, $image_size, $image_error, $error_flag);
	  check_date ($day, $m, $year, $error_flag );	
	
    if($error_flag == 0) 
	{
		// If processing was successful, upload image in folder and redirect
		$_SESSION['unique_image_name'] = $image_unique_name = $image.$email.$child_fname;
	    $UPLOAD_DIR = 'sixthjune/';
        move_uploaded_file($_FILES['image']['tmp_name'], "$UPLOAD_DIR".$image_unique_name);
        header("Location: http://jadran.sdsu.edu/~jadrn007/proj2/enroll_03.php");
	    exit;
    }	
}
?>
