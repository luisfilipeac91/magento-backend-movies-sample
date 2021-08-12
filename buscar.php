<?php

require 'config.php';

include __DIR__.'/inc/_head.php';

$q = isset($_GET['q'])?$_GET['q']:'';

?>
<main role="main" class="container">
    <h1 class="mt-5">Busca por "<?=$q;?>"</h1>
    <div class="d-flex flex-row">
        <div class="flex-1"></div>
    </div>
    <section id="datasets">
        <?php
        
        $GLOBALS['IS_DATASET'] = true;
        require __DIR__.'/datasets/movies.php';

        ?>
    </section>
</main>
<?php

include __DIR__.'/inc/_footer.php';

?>