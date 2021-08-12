<?php

require 'config.php';

include __DIR__.'/inc/_head.php';

$cadastro = $GLOBALS['MovieDB']->GetMovie(isset($_GET['id'])?$_GET['id']:0);

?>
<style>
.results{
    top:100%;
    left:0;
    overflow:auto;
    max-height:320px;
    width: max-content;
    z-index:9999;
}
.result-item>input[type="radio"]:checked+.info{
    background-color:#AAA;
}
</style>
<main role="main" class="container">
    <h1 class="mt-5">Cadastro</h1>
    <section>
        
        <form id="cadastro" method="post" class="pb-5">

            <div id="tmdb_cnt" class="p-relative">
                <label>TMDB ID<br />
                <input name="tmdb" type="text" data-field="true" value="<?=$cadastro['id'];?>" placeholder="Buscar..." class="form-control" /></label>
                <div class="results p-absolute" style="top:100%;"></div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="d-block">Foto<br />
                    <input name="foto" data-field="true" value="<?=$cadastro['foto'];?>" type="text" class="form-control" /></label>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <label class="d-block">Título<br />
                    <input name="titulo" data-field="true" value="<?=$cadastro['titulo'];?>" type="text" class="form-control" /></label>
                </div>
            </div>

            <hr />

            <button class="btn btn-primary">Salvar</button>
            <a href="movies.php" class="btn btn-outline-secondary">Cancelar</a>
            <button type="button" class="btn btn-outline-danger" onclick="remover();">Remover</button>
        
        </form>
        <script>
        <?php
        if($cadastro['id']>0)
        {
            ?>
        function remover()
        {
            MM.pergunta({
                icone:'?',
                titulo:'Remover <?=$cadastro['titulo'];?>',
                mensagem:'<p class="text-center">Confirma remoção deste registro?</p>',
                botoes:[
                    {
                        label:'Sim',
                        class:'btn btn-primary',
                        dismiss:false,
                        acao:function()
                        {
                            $.post('controller/admin.php?a=remover-movie',{
                                id:'<?=$cadastro['id'];?>'
                            },function(data){
                                location.href="movies.php";
                            });
                        }
                    },
                    {
                        label:'Não',
                        icone:'fas fa-times fa-fw',
                        class:'btn btn-secondary',
                        dismiss:true
                    }
                ]
            });
        }
            <?php
        }
        ?>
        var tmdb = $('#cadastro').find('input[name="tmdb"]');
        $('#cadastro').submit(function(){
            var fData = new FormData();
            $.each($('#cadastro *[data-field="true"]'),function(i,v){
                fData.append($(v).attr('name'),$(v).val());
            });

            $.ajax({
                url: 'controller/admin.php?a=salvar-tmdb',
                data: fData,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                method: 'POST',
                success: function(data)
                {
                    window.location.href="movies.php";
                },
                error: function(data)
                {
                    SIGX.erro({
                        titulo:'Erro',
                        mensagem:'<p class="text-center">'+data.mensagem+'</p>'
                    });
                }
            });

        });

        var tmdbDlay = null;
        var results = $('#tmdb_cnt').children('.results');

        tmdb.on('keyup click change',function(){
            if(tmdbDlay)
            {
                tmdbDlay.abort();
                tmdbDlay = null;
            }
            tmdbDlay = $.get('controller/action.php',{
                a:'tmdb-busca',
                q:$(this).val()
            },function(data){
                results.html('');
                $.each(data.dados.results,function(i,v){
                    
                    var content = '<label class="result-item d-block border" data-titulo="'+v.title+'" data-foto="'+v.poster_path+'">';
                    content+= '<input type="radio" name="tmdb-sear" class="d-none" value="'+v.id+'" />';
                    content+= '<span class="info d-block border-1 p-2">';
                    content+= '<img src="<?=TMDB_IMAGE_PATH;?>w500/'+v.poster_path+'" width="40" height="60" class="d-inline-block me-2 img-fluid" />';
                    content+= '<span class="title">'+v.original_title+'</span>';
                    content+= '</span>';
                    content+= '</label>';

                    var item = $(content);

                    results.append(item);
                    
                    item.children('input[name="tmdb-sear"]').change(function(){
                        tmdb.val($(this).val());
                        $('#cadastro').find('input[name="titulo"]').val($(this).parent().data('titulo'));
                        $('#cadastro').find('input[name="foto"]').val($(this).parent().data('foto'));
                        results.html('');
                    });
                });
            });
        });
        $('#cadastro').submit(function(e){
            e.preventDefault();
        });
        $(document).ready(function(){
        });
        </script>

    </section>
</main>
<?php

include __DIR__.'/inc/_footer.php';

?>