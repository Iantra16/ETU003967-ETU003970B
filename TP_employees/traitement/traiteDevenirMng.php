<?php
    include('../inc/function.php');
    $emp_no = $_GET['emp_no'];
    $dateDebut = $_GET['dateDebut'];
    $newdateDebut = $_GET['date'];

    $current_date = new DateTime($dateDebut);
    $new_date = new DateTime($newdateDebut);

    if ($current_date > $new_date) {
        header('Location: ../pages/Page.php?model=becomeMng&&emp_no=' . $emp_no . '&error=1');
    }

    if (($current_date < $new_date) && (Estmanager($emp_no) == false)) {

        $stopDate_mng = stopManager($current_date->format('Y-m-d'), $emp_no, $new_date->format('Y-m-d'));
        $dept_name = getDepartof_employer($emp_no);
        $dept_no = get_dept_no($dept_name);
        $insertNew_mng = insertNew_manager($emp_no,$dept_no,$new_date->format('Y-m-d'));
        // var_dump($insertNew_mng);

        
        if ($stopDate_mng && $insertNew_mng) {
           header('Location: ../pages/Page.php?model=fiche&&emp_no=' . $emp_no);
        } else {
            echo "Erreur lors de la mise à jour du département.";
        }
    }



?>