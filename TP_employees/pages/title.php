<?php
$allTitre = getTitreSalary();

?>
<style>
</style>
    <h1 class="section-title text-center" >Nos emplois</h1>

    <table class="tab">
        <tr>
            <th>Titre</th>
            <th>Salaire moyenne</th>
            <th>Nbre Homme</th>
            <th>Nbre Femme</th>
            <th>Nbre total employees</th>
        </tr>
        <?php foreach ($allTitre as $val) { ?>
            <tr>
                <td><?= $val['title'] ?></td>
                <td><?= formater_montant($val['moyenn']) ?></td>
                <td><?= formater_nombre(getGender($val['title'], 'M')) ?></td>
                <td><?= formater_nombre(getGender($val['title'], 'F')) ?></td>
                <td><?= formater_nombre($val['nbre']) ?></td>
            </tr>
        <?php } ?>
    </table>
