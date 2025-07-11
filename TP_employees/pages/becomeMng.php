<?php
$emp_no = $_GET['emp_no'];
// echo $emp_no;

$dept_name = getDepartof_employer($emp_no);
$nomManager = getNom_manager($dept_name);
$dateDebut = getDate_debut_mng($dept_name);
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
    <h1 class="text-center label"><?= $dept_name ?></h1>
    <h3 class="text-center label text-primary">Devenez manager</h3>

    <div class="text-center mb-4 ">
        <?php if (Estmanager($emp_no)) { ?>
            <h3>Vous etes deja manager du <?= Estmanager($emp_no) ?> </h3>
            <h4>Date de debut : <?= $dateDebut ?></h4>
        <? } else { ?>
            <h3>Manager en cours : <?= $nomManager ?></h3>
            <h4>Date de debut : <?= $dateDebut ?></h4>
    </div>


    <form action="../traitement/traiteDevenirMng.php" method="get" class="form m-auto ">
        <!-- input hidden -->
        <input type="hidden" name="emp_no" value="<?= $emp_no ?>">
        <input type="hidden" name="dateDebut" value="<?= $dateDebut ?>">

        <span class="input-span">
            <label for="date" class="label">Date de debut</label>
            <input type="date" name="date" value="<?= $dateDebut ?>" required>

            <?php if (isset($_GET['error'])) { ?>
                <p class="p-2 border border-light text-danger">
                    La date de début du nouveau manager est antérieur à la date du début de celui d'actuel
                </p>
            <?php } ?>
        </span>

        <input class="submit" type="submit" value="Devenir Manager">
    </form>

<?php } ?>
</div>
