<?php

if(isset($_REQUEST)){
    echo "<pre>";
    print_r($_REQUEST);
    echo "</pre>";
}

if(isset($_FILES)){
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
}


?>