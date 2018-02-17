$(function(){
    if(typeof maxprice != 'undefined'){
        $( "#slider-range" ).slider({
          range: true,
          min: 0,
          max: maxprice,
          values: [$('#valor0').val(), $('#valor1').val() ],
          slide: function( event, ui ) {
            $( "#amount" ).val( "R$ " + ui.values[ 0 ] + " - R$ " + ui.values[ 1 ] );
          },
          change: function( event, ui ){
              //ui.handleIndex identifica qual bolinha foi alterada
              $('#valor'+ui.handleIndex).val(ui.value);
              $('.filterarea form').submit();  
          }
        });
    }

$( "#amount" ).val( "R$ " + $( "#slider-range" ).slider( "values", 0 ) + " - R$ " + $( "#slider-range" ).slider( "values", 1 ) );

//Para atualizar a pagina quando algum filtro for selecionado
$('.filterarea').find('input').on('change', function(){
    $('.filterarea form').submit();  
    });
    
//  Funcçoes de mudança de quantidade do carrinho no produto  
$('.addtocartform button').on('click', function(e){
    e.preventDefault();
       
    var qt = parseInt($('.addtocart_qt').val());
    var action = $(this).attr('data-action');
       
       if(action == 'decrease') {
           if(qt-1 >= 1) {
               qt = qt - 1;
           }
       } else  if(action == 'increase') {
                if(qt+1 <= 10) {
               qt = qt + 1;
           }
        }
        
    $('.addtocart_qt').val(qt);//muda o valor visual da quantidade
    $('input[name=qt_produto]').val(qt);//muda o campo input para o envio do formulario
  
});

//Valores do Frete
$(document).ready(function () {
    if($('input[name=sub]').val() > 0) {
    var sub = document.getElementById("sub").value; 
     
    $('input[name=totalCompra]').val(sub);  
     
    var c = parseFloat($('#totalCompra').val().replace(",", "."));
    var soma = c.toFixed(2).replace('.',',');
    document.getElementById('total').innerHTML = 'R$ '+soma;
   
    $('.finalizar_compra').hide();
    $('.formapg').hide();
   
    $('input[name="correio"]').change(function () {
        var correio = document.querySelector('input[name="correio"]:checked').value;
        $('input[name=teste]').val(sub);
        var correio = correio.split(" ");
        $('input[name=totalFrete]').val(correio[0]);        
        $('input[name=prazo]').val(correio[1]);
        var a = parseFloat($('#teste').val().replace(",", "."));
        var b = parseFloat($('#totalFrete').val().replace(",", "."));
        var c = a + b;    
        var soma = c.toFixed(2).replace('.',',');
        $('input[name=totalCompra]').val(soma);
        document.getElementById('total').innerHTML = 'R$ '+soma;
        $('.finalizar_compra').show();
        $('.formapg').show();
    });

    }
    
});
    /* Video Youtube - Menu Fixo com CSS e jQuery - StudyClassOficial
 $(window).scroll(function(){   
    if($(window).scrollTop() > $('.categoryarea').offset().top){
       $('#nav').addClass('navbar-scroll');
       $('#nav').removeClass('navbar topnav');
    }else{
        $('#nav').removeClass('navbar-scroll');
        $('#nav').addClass('topnav');
    }
        
});*/

//Ação de clique para trocar a foto do produto
$('.photo-item').on('click', function(){
    var url = $(this).find('img').attr('src');
    $('.mainphoto').find('img').attr('src', url);
});

$(document).ready(function(){
  $('.mainphoto img')
    .wrap('<span style="display:inline-block"></span>')
    .css('display', 'block')
    .parent()
    .zoom();
});

$(document).ready(function(){
    if($('input[name="formapg"]').val() > 0) {
        var pg = document.querySelector('input[name="formapg"]:checked').value;
        $('input[name=pg]').val(pg);

        $('input[name="formapg"]').change(function () {
            var pg = document.querySelector('input[name="formapg"]:checked').value;
            $('input[name=pg]').val(pg);
        });
    }
});

});
