<?php

$managerDept = getManager_dept();

?>
    <h1 class="title">Departements</h1>

    <?php
    $num_cards_per_slide = 3;
    ?>

    <div class="list">
        <table class="tab" style="width: 80% ; margin: auto;">
            <thead class="table-info text-uppercase">
                <tr class="">
                    <th>departememt</th>
                    <th>manager</th>
                    <th>employees</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($managerDept as $val) {
                    //  $count_employees = countEmp_dept($val['dept_no']);
                     $count_employees = 203181515;
                ?>
                <tr>
                    <td><?= $val['dept_name'] ?></td>
                    <td class="text-dark"><?= $val['first_name'] ?> <?= $val['last_name'] ?></td>
                    <td><a href="Page.php?model=liste&&dept_no=<?= $val['dept_no'] ?>" class="link"><?= formater_nombre($count_employees) ?>
                            employees</a></td>
                </tr>
                <?php } ?>
            </tbody>

        </table>

    </div>