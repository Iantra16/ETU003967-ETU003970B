<?php
    include('../inc/function.php');
    $dept_no = $_POST['dept'] ?? '';
    $emp_name = $_POST['emp'];
    $ageMin = $_POST['ageMin'] ; 
    $ageMax = $_POST['ageMax'] ; 

    echo $dept_no . " ". $emp_name." ".$ageMin . " " . $ageMax;
    $val = getResult_Recherche($dept_no,$emp_name,$ageMin,$ageMax);
    $_SESSION['val'] = $val;
    header('Location:../pages/Page.php?model=search');
?>