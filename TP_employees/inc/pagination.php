
    <div aria-label="..." class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item <?= active(($p - 1), $p, $count_employees) ?> ">
                <a class="page-link" href="?model=<?=$page?>&&p=<?= $p - 1 ?>">Previous</a>                                  <!-- Previous $p-1 -->
            </li>
            <?php if ( $p > 1 ) { ?>
                <li class="page-item"><a class="page-link" href="?model=<?=$page?>&&p=1">1</a></li>
            <?php } ?>

            <?php if ($p - 2 > 1) { ?>
                <li class="page-item"><a class="page-link" href="?model=<?=$page?>&&p=<?= $p - 2 ?>">...</a></li>
            <?php } ?>
            <?php if ($p - 1 > 1) { ?>
                <li class="page-item"><a class="page-link" href="?model=<?=$page?>&&p=<?= $p - 1 ?>"><?= $p - 1 ?></a></li>
            <?php } ?>
            
            <li class="page-item active" aria-current="page"> 
                <a class="page-link " href="?model=<?=$page?>&&p=<?= $p ?>"> <?= $p ?> </a>                                  <!-- active $p -->
            </li>

            <?php if ($p + 1 <= $pmax ) { ?>
                <li class="page-item"><a class="page-link" href="?model=<?=$page?>&&p=<?= $p + 1 ?>"> <?= $p + 1 ?> </a></li>
            <?php } ?>

            <?php if ($p + 2 < $pmax ) { ?>
                <li class="page-item"><a class="page-link" href="?model=<?=$page?>&&p=<?= $p + 2 ?>">...</a></li>
            <?php } ?>

            <?php if ( $p  <= $pmax-2  ) { ?>
                <li class="page-item"><a class="page-link" href="?model=<?=$page?>&&p=<?= $pmax ?>"><?= $pmax ?></a></li>
            <?php } ?>

            <li class="page-item">
                <a class="page-link <?= active(($p + 1), $p ,$count_employees) ?> " href="?model=<?=$page?>&&p=<?= $p + 1 ?>">Next</a> <!-- netx $p+1 -->
            </li>
        </ul>
    </div>
    