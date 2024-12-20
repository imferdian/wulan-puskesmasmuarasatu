<?php
require "config/functions.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    if(resetFoto($id) > 0) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}