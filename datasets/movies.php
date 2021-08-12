<?php
$fav = isset($_GET['fav'])?($_GET['fav']=='true'?1:0):null;

if(!isset($GLOBALS['IS_DATASET']))
{
    ?>
<h1 class="mt-5">Movies</h1>

<div class="row">
    <div class="col-6">
        <form class="d-flex flex-row mt-2 mt-md-0">
            <input name="q" class="form-control mr-sm-2" type="text" placeholder="Pesquisar por algo..." aria-label="Buscar" style="width:200px;">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </div>
    <div class="col-6 text-end">
        <a href="movies-cadastro.php" class="btn btn-outline-secondary">Cadastro</a>
    </div>
</div>
    <?php
}
else
{
    ?>
<h2 class="mt-5">Movies</h2>
    <?php
}

$where = '';
if(!is_null($fav)) $where.='mf.id IS '.($fav?'NOT':'').' NULL';
$q = isset($_GET['q'])?$_GET['q']:'';
if($q!='')
{
    $q = str_replace("'","''",$q);
    $where.=($where!=''?' AND ':'')."m.titulo LIKE '%".$q."%'";
}
?>
<section>
    <?php
    $registros = $GLOBALS['MovieDB']->ListMovies(array(
        'pagina'=>1,
        'limite'=>20,
        'where'=>$where,
        'order'=>''
    ));
    if(count($registros['list'])>0)
    {
        ?>
    <div class="row py-4">
        <?php
        foreach($registros['list'] as $reg)
        {
            ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card movie" style="width: 18rem;" data-id="<?=$reg['id'];?>">
                <img class="card-img-top" src="<?=TMDB_IMAGE_PATH.'w500/'.$reg['foto'];?>" alt="<?=$reg['titulo'];?>">
                <div class="card-body">
                    <h5 class="card-title"><?=$reg['titulo'];?></h5>
                    <p class="card-text"></p>
                    <div class="row">
                        <div class="col-9">
                            <a href="movies-cadastro.php?id=<?=$reg['id'];?>" class="btn btn-outline-secondary">Alterar</a>
                        </div>
                        <div class="col-3 text-end">
                            <a href="javascript:void(0);" class="fav<?=$reg['favorito']?' faved':'';?> btn btn-outline-link" onclick="fav(this,<?=$reg['id'];?>);" data-toggle="tooltip" title="Filme favorito">★</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <?php
        }
        ?>
    </div>
        <?php
    }
    else
    {
        ?>
    <div class="py-3">
        <div class="alert alert-warning">Nenhum filme encontrado</div>
    </div>
        <?php
    }
    ?>
</section>
<script>
function refresh_labels()
{
    $.each($('.fav'),function(i,v){
        $(this).tooltip('dispose');
        if($(this).hasClass('faved')) $(this).attr('title','Remover favorito');
        else $(this).attr('title','Adicionar aos favoritos');
    });
    $('*[data-toggle="tooltip"]').tooltip();
}
var fav_P = null;
function fav(el, id)
{
    if(fav_P)
    {
        fav_P.abort();
        fav_P = null;
    }
    fav_P = $.post('controller/action.php?a=favoritar',{
        id:id,
        action:!$(el).hasClass('faved')
    },function(data){
        if($(el).hasClass('faved')) $(el).removeClass('faved');
        else $(el).addClass('faved');
        refresh_labels();
    });
}
$(document).ready(function(){
    refresh_labels();
});
</script>