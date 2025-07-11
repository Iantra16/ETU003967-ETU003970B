<?php
$emp_no = $_GET['emp_no'];
$getNom = getFiche($emp_no);
$fiche = getHistory($emp_no);
?>
<button class="back"><a href="Page.php?model=liste">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
        viewBox="0 0 16 16">
        <path fill-rule="evenodd"
            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
    </svg>
    <div class="b-text">Back</div></a>
</button>

<?php foreach ($getNom as $name) { ?>
    <h1 class="title"><?= $name['first_name'] ?> <?= $name['last_name'] ?></h1>
    
    <div class="employee-card">
        <p><strong>Birth :</strong> <?= $name['birth_date'] ?>  (<span class="age-info"><?= calcul_age($name['birth_date']) ?>  years old</span>)</p>
        <p><strong>Hiring : </strong> <?= $name['hire_date'] ?></p>
        <p><strong>Gender : </strong> <?= $name['gender'] ?></p>
        <p><strong>Department :</strong>  <?= getDepartof_employer($emp_no) ?></p>
        <?php
        if (Estmanager($emp_no)) { ?>
            <p><strong>Manager of</strong>  <?= Estmanager($emp_no) ?> </p>
        <? }
        ?>
        <p><strong>Emploi avec le plus long duree :</strong>  <?= getEmploiLong($name['emp_no']) ?></p>

    </div>

    <div class="change d-flex float-end">
        <a href="Page.php?model=change&&emp_no=<?= $name['emp_no'] ?>"><button class="btn">Change Department</button></a>
        <a href="Page.php?model=becomeMng&&emp_no=<?= $name['emp_no'] ?>"><button class="btn">Become a manager</button></a>
    </div>
<?php } ?>



<h3>Historique des Salaires et Contrats :</h3>
<table border="1" class="table">
    <tr class="text-uppercase">
        <th>title</th>
        <th>salary</th>
        <th>contrat</th>
    </tr>
    <?php foreach ($fiche as $val) { ?>
        <tr>
            <td><?= $val['title'] ?></td>
            <td><?= formater_montant($val['salary']) ?></td>
            <td><?= $val['from_date'] ?> to <?= $val['to_date'] ?></td>
        </tr>
    <?php } ?>
</table>