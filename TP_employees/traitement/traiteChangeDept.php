<?php
    include('../inc/function.php');
    $emp_no = $_GET['emp_no'];
    $dateDebut = $_GET['dateDebut'];
    $newDept = $_GET['choix'];
    $newdateDebut = $_GET['date'];

    $current_date = new DateTime($dateDebut);
    $new_date = new DateTime($newdateDebut);

    if ($current_date > $new_date) {
        header('Location: ../pages/Page.php?model=change&&emp_no=' . $emp_no . '&error=1');
    }
    else {
        $new_dept_no = get_dept_no($newDept);
        $updating = changeDept($current_date->format('Y-m-d'), $emp_no, $new_date->format('Y-m-d'));
        $insert = insert_into_dept($emp_no, $new_dept_no, $new_date->format('Y-m-d'));

        if ($updating && $insert) {
            header('Location: ../pages/Page.php?model=fiche&&emp_no=' . $emp_no);
        } else {
            echo "Erreur lors de la mise à jour du département.";
        }
    }



?>