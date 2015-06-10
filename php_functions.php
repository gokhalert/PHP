<?php
function write_error_page($message)
 {
	print <<< EOF
	<!DOCTYPE html>
	<head>
    <meta charset="utf-8">
    <title>Error Page</title>
    <style>
        h1 { text-align: center; }
    </style>
	</head>
	<body>
EOF;

print $message;	
print "</body></html>\n";
exit;  
}
	
function check_camp ($camp, $error_flag)
{
	global $error_flag;
	global $campErr;
	if(count($camp) == 0)
	{
       	$campErr = "Select atleast One Camp";
     	$error_flag = 1;
	}
}
	
	
function check_parent_fname ($parent_fname, $error_flag)
{
	global $error_flag;
	global $parent_fnameErr;
	if (empty($parent_fname))
     {	
     	$parent_fnameErr = "* Mandatory";
     	$error_flag = 1;
     }
   else
     {
      if (!preg_match("/^[ a-zA-Z'-.]*$/",$parent_fname))
       {
       $error_flag = 1;
       $parent_fnameErr = "*Alpha/Hyphen/Apostrophe"; 
       }
     }
}	

function check_parent_lname ($parent_lname, $error_flag)
{
	global $error_flag;
	global $parent_lnameErr;
    if (empty($parent_lname))
     {	$parent_lnameErr = "* Mandatory";
     	$error_flag = 1;
     }
   else
     {
     if (!preg_match("/^[ a-zA-Z'-.]*$/", $parent_lname))
       {
       $error_flag = 1;
       $parent_lnameErr = "*Alpha/Hyphen/Apostrophe"; 
       }
     }
 }    

function check_relation ($relation, $error_flag)
{
	global $error_flag;
	global $relationErr;
	if($relation == -1)
	{
       	$relationErr = "Pick your relation with kid";
     	$error_flag = 1;
	}
}

function check_email ($email, $error_flag)   
{
	global $error_flag;
	global $emailErr;
   if (empty($email))
     {
     	$emailErr = "* Mandatory";
    	 $error_flag = 1;
     }
   else
     {
     if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
       {
       $emailErr = "*Invalid Format"; 
       $error_flag = 1;
       }
     }
}


function check_child_fname ($child_fname, $error_flag)
{
	global $error_flag;
	global $child_fnameErr;
	if (empty($child_fname))
     {	
     	$child_fnameErr = "* Mandatory";
     	$error_flag = 1;
     }
   else
     {
      if (!preg_match("/^[ a-zA-Z'-.]*$/",$child_fname))
       {
       $error_flag = 1;
       $child_fnameErr = "*Alpha/Hyphen/Apostrophe"; 
       }
     }
}	

function check_child_lname ($child_lname, $error_flag)
{
	global $error_flag;
	global $child_lnameErr;
    if (empty($child_lname))
     {	
        $child_lnameErr = "* Mandatory";
     	$error_flag = 1;
     }
   else
     {
     // check if name only contains letters and whitespace
     if (!preg_match("/^[ a-zA-Z'-.]*$/", $child_lname))
       {
       $error_flag = 1;
       $child_lnameErr = "*Alpha/Hyphen/Apostrophe"; 
       }
     }
 }    
	
function check_image ($image, $image_size, $image_error, $error_flag)
{
	global $error_flag;
	global $imageErr;

    $UPLOAD_DIR = 'sixthjune/';

    /*if(file_exists("$UPLOAD_DIR".$image)) 
     {
     	$error_flag = 1;
        $imageErr =" $image already exists on the server !";
     }
    else */
    if($image_size > 1000000)
    {
        $error_flag = 1;
        $imageErr ="Max size: 1MB";
    }   
    elseif($image_error > 0) 
    {
	    $error_flag = 1;
        $imageErr = "Image Error !";
    }     
}

function check_date ($day, $m, $year, $error_flag )
{
	global $error_flag;
	global $dateErr;

switch ($m)
	 {
    case "January" :
        $month = '1';
        break;
    case "February":
        $month = '2';
        break;
    case "March":
        $month = '3';
        break;
    case "April" :
        $month = '4';
        break;
    case "May":
        $month = '5';
        break;
    case "June":
        $month = '6';
        break;
    case "July" :
        $month = '7';
        break;
    case "August":
        $month = '8';
        break;
    case "September":
        $month = '9';
        break;
    case "October" :
        $month = '10';
        break;
    case "November":
        $month = '11';
        break;
    case "December":
        $month = '12';
        break;
}
	if (!(checkdate($month,$day,$year)))
	{
		$error_flag = 1;
		$dateErr = "*Wrong Date Picked !";
	}
}
?>
