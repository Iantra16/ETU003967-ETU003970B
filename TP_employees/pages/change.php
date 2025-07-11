<?php
$emp_no = $_GET['emp_no'];
// echo $emp_no;
$dept = getDept_name();
$deptNow = getDepartof_employer($emp_no);
$dateDebut = getDate_debut_dept($emp_no);

?>

<button class="back"><a href="Page.php?model=fiche&&emp_no=<?=$emp_no ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
        viewBox="0 0 16 16">
        <path fill-rule="evenodd"
            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
    </svg>
    <div class="b-text">Back</div></a>
</button>

<div class="col-lg-6 m-auto py-5 search p">
    <h1 class="text-center label text-primary">Changement de departement</h1>

    <div class="text-center mb-4 ">
        <h3>Departement actuel: <?= $deptNow ?></h3>
        <h3>Date de debut: <?= $dateDebut ?></h3>
    </div>


    <form action="../traitement/traiteChangeDept.php" method="get" class="form m-auto ">

        <input type="hidden" name="emp_no" value="<?= $emp_no ?>">
        <input type="hidden" name="dateDebut" value="<?= $dateDebut ?>">

        <span class="input-span">
            <label for="choix" class="label">Choix du nouveau department </label>
            <select name="choix" class="p-2" required>
                <option value=""></option>
                <?php foreach ($dept as $val) {
                    if ($val['dept_name'] != $deptNow) { ?>
                        <option value="<?= $val['dept_name'] ?>"><?= $val['dept_name'] ?></option>
                <?php }
                } ?>
            </select>
        </span>

        <span class="input-span">
            <label for="date" class="label">Date de debut</label>
            <input type="date" name="date" value="<?= $dateDebut ?>" required>

            <?php if (isset($_GET['error'])) { ?>
                <p class="p-2 border border-light text-danger">
                    La date de début du nouveau département est antérieur à la date du début de l'actuel
                </p>
            <?php } ?>
        </span>
        <input class="submit" type="submit" value="Valider">
    </form>
</div>
