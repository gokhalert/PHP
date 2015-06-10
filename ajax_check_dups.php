<?php
include 'helper_functions.php';

# delay for debugging only
# for($i=0; $i < 100000000; $i++) ;

$_POST = $_GET;
$db = get_connection();

if(is_duplicate_parent($db))
    if(is_duplicate_child($db))
        if(is_duplicate_camp($db))
            echo "duplicate";
echo "ok";
?>
