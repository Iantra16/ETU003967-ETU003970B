<?php
include('../inc/header.php');
include('../inc/function.php');

$page = "accueil";
if (isset($_GET['model'])) {
    $page = $_GET['model'];
}
   
?>

<main>
    <div class="container">

        <?php include($page.'.php');?>

    </div>
</main>

<?php 
 include('../inc/footer.php'); 
 ?>