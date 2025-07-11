<?php
session_start();
ini_set("display_errors", "1");
require('connection.php');

function formater_montant($nombre)
{
    $ret = "$ " . number_format($nombre, 2, ',', ' ');
    return $ret;
}

function formater_nombre($nombre)
{
    $ret = number_format($nombre, 0, ',', ' ');
    return $ret;
}

function getDepart($dept_no)
{
    $sql = "SELECT * from departments WHERE dept_no = '%s' ";
    $sql = sprintf($sql, $dept_no);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        return mysqli_fetch_assoc($requet);
    }
    return NULL;
}


function getManager_dept()
{
    $sql = "SELECT * FROM v_manager_dept_current order by dept_name asc";
    $requet = mysqli_query(dbconnect(), $sql);
    if (!$requet) {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return [];
    }
    $rep = array();
    while ($val = mysqli_fetch_assoc($requet)) {
        $rep[] = $val;
    }
    return $rep;
}

// function getManager($dept_name)
// {
//     $sql = "SELECT * FROM v_manager_dept_current where dept_name = '%s'";
//     $sql = sprintf($sql, $dept_name);
//     $requet = mysqli_query(dbconnect(), $sql);
//     $rep = array();
//     while ($val = mysqli_fetch_assoc($requet)) {
//         $rep[] = $val;
//     }
//     return $rep;
// }

function getNom_manager($dept_name) {
    $sql = "SELECT * FROM v_manager_dept_current where dept_name = '%s'";
    $sql = sprintf($sql, $dept_name);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        $val = mysqli_fetch_assoc($requet);
        return $val['first_name'] . " " . $val['last_name'];
    }
    return 0;
}

function getDate_debut_mng($dept_name){
    $sql = "SELECT * FROM v_manager_dept_current where dept_name = '%s'";
    $sql = sprintf($sql, $dept_name);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        $val = mysqli_fetch_assoc($requet);
        return $val['from_date'];
    }
    return 0;
}


function countEmp_dept($dept_no)
{
    $sql = "SELECT count(emp_no) as nb_employer FROM v_employees_Dept_current where dept_no = '%s'";
    $sql = sprintf($sql, $dept_no);
    $requet = mysqli_query(dbconnect(), $sql);
    if (!$requet) {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return [];
    }
    $rep = mysqli_fetch_assoc($requet);
    return $rep['nb_employer'];
}

function getTitreSalary()
{
    $sql = "SELECT * from v_title_salary_emp";
    $requet = mysqli_query(dbconnect(), $sql);
    if (!$requet) {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return [];
    }
    $rep = array();
    while ($val = mysqli_fetch_assoc($requet)) {
        $rep[] = $val;
    }
    return $rep;
}

function getGender($type, $sexe)
{
    $sql = "SELECT nbre from v_gender where title = '%s' and sexe= '%s'";
    $sql = sprintf($sql, $type, $sexe);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        $val = mysqli_fetch_assoc($requet);
        return $val['nbre'];
    }
    return 0;
}

function getAll_employees_dept_page($dept_no, $p, $step)
{

    $co = ($p - 1) * $step;
    $sql = "SELECT e.*,de.from_date,de.to_date  FROM employees e 
            JOIN dept_emp de on e.emp_no = de.emp_no 
            WHERE de.dept_no = '%s' and de.to_date > now() ORDER BY e.first_name ASC LIMIT %d,%d  ";
    $sql = sprintf($sql, $dept_no, $co, $step);
    // echo $sql;
    $requet = mysqli_query(dbconnect(), $sql);
    $rep = array();
    while ($val = mysqli_fetch_assoc($requet)) {
        $rep[] = $val;
    }
    return $rep;
}

function getHistory($emp_no)
{
    $sql = "SELECT * from v_employees_fiche where emp_no = '%s'";
    $sql = sprintf($sql, $emp_no);
    $requet = mysqli_query(dbconnect(), $sql);
    if (!$requet) {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return [];
    }
    $rep = array();
    while ($val = mysqli_fetch_assoc($requet)) {
        $rep[] = $val;
    }
    return $rep;
}

function getFiche($emp_no)
{
    $sql = "SELECT * FROM employees e WHERE e.emp_no = '%s'";
    $sql = sprintf($sql, $emp_no);
    $requet = mysqli_query(dbconnect(), $sql);
    $rep = array();
    while ($val = mysqli_fetch_assoc($requet)) {
        $rep[] = $val;
    }
    return $rep;
}


function getDepartof_employer($emp_no)
{
    $sql = "SELECT * from v_employees_Dept_current where emp_no = '%s'";
    $sql = sprintf($sql, $emp_no);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        $val = mysqli_fetch_assoc($requet);
        return $val['dept_name'];
    }
    return NULL;
}

function getDate_debut_dept($emp_no)
{
    $sql = "SELECT * from v_employees_Dept_current where emp_no = '%s'";
    $sql = sprintf($sql, $emp_no);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        $val = mysqli_fetch_assoc($requet);
        return $val['from_date'];
    }
    return NULL;
}

// function getDate_debut_manager($emp_no)
// {
//     $sql = "SELECT * from v_manager_dept_current where emp_no = '%s'";
//     $sql = sprintf($sql, $emp_no);
//     echo $sql;
//     $requet = mysqli_query(dbconnect(), $sql);
//     if ($requet) {
//         $val = mysqli_fetch_assoc($requet);
//         return $val['from_date'];
//     }
//     return NULL;
// }

function changeDept($from_date, $emp_no, $to_date)
{
    $sql = "UPDATE dept_emp set to_date = '%s' 
            WHERE emp_no = '%s' and from_date = '%s' and to_date = '9999-01-01'";
    $sql = sprintf($sql, $to_date, $emp_no, $from_date);
    $requet = mysqli_query(dbconnect(), $sql);
    if (!$requet) {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return false;
    }
    return $requet;
}

function stopManager($from_date, $emp_no, $to_date)
{
    $sql = "UPDATE dept_manager set to_date = '%s' 
            WHERE emp_no = '%s' and from_date = '%s' and to_date = '9999-01-01'";
    $sql = sprintf($sql, $to_date, $emp_no, $from_date);
    $requet = mysqli_query(dbconnect(), $sql);
    if (!$requet) {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return false;
    }
    return $requet;
}

function insertNew_manager($emp_no, $dept_no, $newDate)
{
    $sql = "INSERT into dept_manager (emp_no,dept_no,from_date,to_date) 
            values ('%s','%s','%s','9999-01-01')";
    $sql = sprintf($sql, $emp_no, $dept_no, $newDate);
    echo $sql;
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        return true;
    } else {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return false;
    }
    return false;
}

function get_dept_no($name)
{
    $sql = "SELECT dept_no from departments where dept_name = '%s'";
    $sql = sprintf($sql, $name);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        $val = mysqli_fetch_assoc($requet);
        return $val['dept_no'];
    }
    return NULL;
}

function insert_into_dept($emp_no, $dept_no, $newDate)
{
    $sql = "INSERT into dept_emp (emp_no,dept_no,from_date,to_date) 
            values ('%s','%s','%s','9999-01-01')";
    $sql = sprintf($sql, $emp_no, $dept_no, $newDate);
    echo $sql;
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        return true;
    } else {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return false;
    }
    return false;
}

function Estmanager($emp_no)
{
    $sql = "SELECT d.dept_name FROM dept_manager dm JOIN departments d 
                    on dm.dept_no = d.dept_no
                    WHERE emp_no = '%s' and to_date > now()";
    $sql = sprintf($sql, $emp_no);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        $rep = mysqli_fetch_assoc($requet);
        if (!$rep) {
            return NULL;
        }
        return $rep['dept_name'];
    }
    return NULL;
}

function calcul_age($birth)
{
    $birthDate = new DateTime($birth);
    $today = new DateTime();
    $age = $today->diff($birthDate);
    return $age->y;
}

function getDept_name()
{
    $sql = "SELECT Distinct dept_name from departments";
    $requet = mysqli_query(dbconnect(), $sql);
    if (!$requet) {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return [];
    }
    $rep = array();
    while ($val = mysqli_fetch_assoc($requet)) {
        $rep[] = $val;
    }
    return $rep;
}



function getResult_Recherche($dept_no, $nom, $min, $max)
{
    $sql = "SELECT
                e.*,
                d.dept_name,
                TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) AS age
            FROM
                employees e
            JOIN dept_emp dm ON dm.emp_no = e.emp_no
            join departments d on dm.dept_no = d.dept_no
            WHERE 1=1
                and d.dept_name like '%%%s%%'
                AND (e.last_name like '%%%s%%' OR e.first_name like '%%%s%%')
                AND TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) between %d and %d";
    $sql = sprintf($sql, $dept_no, $nom, $nom, $min, $max);
    echo $sql;
    $requet = mysqli_query(dbconnect(), $sql);
    if (!$requet) {
        echo "Erreur sql:" . mysqli_error(dbconnect());
        return [];
    }
    $rep = array();
    while ($val = mysqli_fetch_assoc($requet)) {
        $rep[] = $val;
    }
    return $rep;
}

function getEmploiLong($emp_no)
{
    $sql = "SELECT title from v_titre_plusLong where emp_no = '%s'";
    $sql = sprintf($sql, $emp_no);
    $requet = mysqli_query(dbconnect(), $sql);
    if ($requet) {
        $val = mysqli_fetch_assoc($requet);
        return $val['title'];
    }
    return 0;
}




////////////////////// pagination ///////////////////////

function Maxpage($count_employees, $step)
{
    if ($count_employees == 0) {
        return 1;
    }
    $max = ceil($count_employees / $step);
    return (int)$max;
}

function active($pp, $p, $pmax)
{

    if ($pp == $p) {
        return " active ";
    }
    if ($pp > $pmax || $pp < 1) {
        return " disabled ";
    }

    return "";
}
