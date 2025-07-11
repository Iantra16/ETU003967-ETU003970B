<div class="col-lg-6 m-auto py-5 search p">
    <h1 class="text-center label">Search</h1>
    <form class="form m-auto " action="../traitement/traiteSearch.php" method="post">
        <span class="input-span">
            <label class="label" for="dept">Departement</label>
            <input type="text" name="dept" id="dept" required/></span>
        <span class="input-span">
            <label for="emp" class="label">Nom Employee</label>
            <input type="text" name="emp" required /></span>
        <span class="age d-flex">
            <div class="d-flex ">
                <label for="ageMin" class="label">Age min</label>
                <input class="form-control text-center" type="number" name="ageMin"
                    min="15" max="50" value="18">
            </div>

            <div class="d-flex">
                <label for="ageMax" class="label">Age Max</label>
                <input class="form-control text-center " type="number" name="ageMax"
                    min="30" max="200" value="90">
            </div>
        </span>
        <input class="submit" type="submit" value="Search" />
    </form>
</div>

<?php if (isset($_SESSION['val'])) {
    $val = $_SESSION['val'];
    unset($_SESSION['val']); ?>

    <table border="1" class="tab">
        <tr class="text-uppercase">
            <th>dept_no</th>
            <th>nom</th>
            <th>age</th>
        </tr>
        <?php if (!empty($val)) {
            foreach ($val as $key) { ?>
                <tr>
                    <td><?= $key['dept_name'] ?></td>
                    <td><?= $key['first_name'] ?> <?= $key['last_name'] ?></td>
                    <td><?= $key['age'] ?></td>
                </tr>
            <?php }
        } else { ?>
            <p>Aucun resultat trouver</p>
        <?php } ?>

    </table>

<?php } else {
    $val = array();
} ?>