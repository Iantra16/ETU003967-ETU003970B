<?php
if (isset($_GET['dept_no'])) {
    $dept_no = $_GET['dept_no'];
    $_SESSION['dept_no'] = $dept_no;
}
else {
    $dept_no = $_SESSION['dept_no'];
}

if (!isset($_GET['p'])) {
    $p = 1;
} else {
    $p = $_GET['p'];
}


$depart = getDepart($dept_no);

// $depart = getEmployee_dept($dept_no);

$count_employees = countEmp_dept($dept_no);

$step = 20;
$pmax = Maxpage($count_employees, $step);

?>
<button class="back"><a href="Page.php">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
        viewBox="0 0 16 16">
        <path fill-rule="evenodd"
            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
    </svg>
    <div class="b-text">Back</div></a> 
</button>
    <h1 class="title" >Departements of <?= $depart['dept_name'] ?> </h1>
    <!-- <p><a href="index.php">Back</a></p> -->
    <h2>Liste Employees( <?= formater_nombre($count_employees) ?> employees )</h2>

    <p class="float-end">Page <?= $p ?> of <?= $pmax ?> </p>
    <?php
    $ls_employees = getAll_employees_dept_page($dept_no, $p, $step);
    ?>
    <table border="1" class="table">
        <tr class="text-uppercase">
            <th>name</th>
            <th>hire_date</th>
            <th>contrat</th>
        </tr>
        <?php foreach ($ls_employees as $val) { ?>
        <tr>
            <td><a href="Page.php?model=fiche&&emp_no=<?= $val['emp_no'] ?>"><?= $val['first_name'] ?> <?= $val['last_name'] ?></a>
            </td>
            <td><?= $val['hire_date'] ?></td>
            <td>En Cours</td>
        </tr>
        <?php } ?>
    </table>


    <?php include('../inc/pagination.php') ?>