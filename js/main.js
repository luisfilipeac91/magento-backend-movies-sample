"use strict";

var MM = {
    gerar_codigo:function(options)
    {
        var settings = $.extend({},{
            caracteres:'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
            tamanho:20
        },options);
        
        var saida = '';
        for(var i=0;i<settings.tamanho;i++)
            saida+=settings.caracteres[Math.floor(Math.random()*settings.caracteres.length)];
        return saida;
    },
    criar_modal:function(options)
    {
        var settings = $.extend({},{
            tamanho:''
        },options);
        
        var rnd = MM.gerar_codigo({tamanho:20});
        var content = '<div class="modal zoom" id="modal-'+rnd+'" tabindex="-1" role="dialog" aria-labelledby="m_'+rnd+'_lbl" aria-hidden="true">';
        content += '<div class="modal-dialog';
        if(settings.tamanho!='')
            content+= ' modal-'+settings.tamanho;
        content += '" role="document">';
        content += '<div class="modal-content">';
        content += '<div class="modal-header">';
        content += '<h5 class="modal-title" id="m_'+rnd+'_lbl"></h5>';
        content += '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
        content += '<span aria-hidden="true">&times;</span>';
        content += '</button>';
        content += '</div>';
        content += '<div class="modal-body">';
        content += '</div>';
        content += '<div class="modal-footer">';
        content += '<button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>';
        content += '</div>';
        content += '</div>';
        content += '</div>';
        content += '</div>';
        
        if($('.modal').length==0) $('body').prepend(content);
        else $(content).insertAfter($('.modal').last());
        return 'modal-'+rnd;
    },
    pergunta:function(options)
    {
        var settings = $.extend({},{
            icone:'',
            titulo:'Pergunta',
            mensagem:'Descritivo',
            onload:function(){},
            onshown:function(){},
            ondispose:function(){},
            botoes:[
                {
                    label:'Sim',
                    icone:'fas fa-check fa-fw',
                    class:'btn btn-primary',
                    dismiss:false,
                    acao:function(){}
                },
                {
                    label:'Não',
                    icone:'fas fa-times fa-fw',
                    class:'btn btn-secondary',
                    dismiss:true,
                    acao:function(){}
                }
            ]
        },options);
        var mId = MM.criar_modal();
        $('#'+mId).addClass('md-mensagem');
        if(settings.icone!='')
            $('#'+mId).find('.modal-header').prepend('<span class="h-icone"><i class="'+settings.icone+'"></i></span>');
        $('#'+mId).find('.modal-title').html(settings.titulo);
        $('#'+mId).find('.modal-body').html(settings.mensagem);
        $('#'+mId).find('.modal-footer').html('');
        $.each(settings.botoes,function(i,v){ 
            var content = '<button type="button" class="';
            if(v.class==undefined || v.class=='')
                v.class = 'btn btn-secondary';
            content+= v.class+'"';
            if(v.dismiss) content+= ' data-bs-dismiss="modal"';
            content+= ' data-label="'+v.label+'">';
            if(v.icone!='')
            content+= '<i class="'+v.icone+'"></i> ';
            content+= v.label;
            content+= '</button>';
            var $content = $(content);
            $('#'+mId).find('.modal-footer').append($content);
            $content.on('click',function(){
                if($.isFunction(v.acao)) v.acao();
            });
        });
        settings.onload($('#'+mId));
        $('#'+mId).on('hidden.bs.modal',function(){
            $(this).remove();
            settings.ondispose();
        }).on('shown.bs.modal',function(){
            $.each(settings.botoes,function(i,v){
                if(v.focus!==undefined && v.focus==true)
                $('#'+mId+' .modal-footer button[data-label="'+v.label+'"]').focus();
            });
            settings.onshown({
                modal_id:mId
            });
        }).modal({backdrop: 'static', keyboard: false});
        $('#'+mId).modal('show');
    },
};