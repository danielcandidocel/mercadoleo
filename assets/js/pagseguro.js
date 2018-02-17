$('.finalizarCompra').on('click', function(){
//    ID -> identificador da compra necessário para a interação com o PagSeguro, criado por ele mesmo
    var id = PagSeguroDirectPayment.getSenderHash();
    
    var nome = $('input[name=nome]').val();
    var doc = $('input[name=doc]').val();
    var email = $('input[name=email]').val();
    var cel = $('input[name=cel]').val();
 
    var id_endereco = $('input[name=id_endereco]').val();
    var cep = $('input[name=cep]').val();
    var rua = $('input[name=rua]').val();
    var numero = $('input[name=numero]').val();
    var complemento = $('input[name=complemento]').val();
    var bairro = $('input[name=bairro]').val();
    var cidade = $('input[name=cidade]').val();
    var estado = $('input[name=estado]').val();
    
    var id_cartao = $('input[name=id_cartao]').val();
    var nome_titular = $('input[name=titular]').val();
    var doc_titular = $('input[name=doc_titular]').val();
    var numero_cartao = $('input[name=numeroCartao]').val();
    var cvv =  $('input[name=cvv]').val();
    var v_mes =  $('input[name=validade_mes]').val();
    var v_ano =  $('input[name=validade_ano]').val();
    var totalCompra = $('input[name=totalCompra]').val();
    
    var parcelas = $('select[name=parcelas]').val();

    if(numero_cartao != '' && cvv != '' && v_mes != '' && v_ano != '') {
        
//        criando token do cartão com o PagSeguro
        PagSeguroDirectPayment.createCardToken({
            cardNumber:numero_cartao,
            brand:window.cardBrand,
            cvv:cvv,
            expirationMonth:v_mes,
            expirationYear:v_ano,
            success:function(r) {
                    window.cardToken = r.card.token;
                
//                Criar uma reuisição ajax para interagir com o controller do pagseguro

                $.ajax({
                    url:BASE_URL+'pagseguro/checkcout',
                    type:'POST',
                    data:{
                        id:id,
                        nome:nome,
                        doc:doc,
                        email:email,
                        cel:cel,
                        id_endereco:id_endereco,
                        cep:cep,
                        rua:rua,
                        numero:numero,
                        complemento:complemento,
                        bairro:bairro,
                        cidade:cidade,
                        estado:estado,
                        id_cartao:id_cartao,
                        nome_titular:nome_titular,
                        doc_titular:doc_titular,
                        numero_cartao:numero_cartao,
                        cvv:cvv,
                        v_mes:v_mes,
                        v_ano:v_ano,
                        cartao_token:window.cardToken,
                        totalCompra:totalCompra,
                        parcelas:parcelas,
                    },
                    dataType:'json',                    
                    beforeSend:function(){
                        
                        $('#modal_pagseguro').modal('show');
                    },
                    success:function(json) {
                            if(json.error == true) {
                                    alert(json.msg);
                            } else {
                                    window.location.href = BASE_URL+'pagseguro/obrigado';
                            }
                    },
                    error:function() {
                          alert('Erro de Conexão...Tente Mais Tarde.');
                    }
                });
            },
            error:function(r) {
                console.log(r);
            },
            complete:function(r) {}
        });
    } else {
        alert('Preencha Todos os Campos');
    }
       
});

window.onload = function(){
 var bandeira = document.getElementById("bandeira").value;
 var totalCompra = document.getElementById("totalCompra").value;
 var numeroCartao = document.getElementById("numeroCartao").value;
 var valor = parseFloat($('input[name=totalCompra]').val().replace(".", "").replace(",", ".")); 
 
 PagSeguroDirectPayment.getBrand({
     cardBin: $('input[name=numeroCartao]').val(),
     success:function(r) {
//        Variável Global armazena nome da bandeira
        window.cardBrand = r.brand.name;
        
//        Informações de Parcelamento do PagSeguro
        PagSeguroDirectPayment.getInstallments({

            
            amount: valor,
            brand:window.cardBrand,
            maxInstallmentNoInterest:2,
            success:function(r) {
               
                if(r.error == false){
                    var parcelas = r.installments[window.cardBrand];
                    var teste = window.cardBrand;
                    var html = '';
                    
                    for(var i in parcelas) {
                        var optionValue = parcelas[i].quantity+';'+parcelas[i].installmentAmount+';';
                        if(parcelas[i].interestFree == true) {
                            optionValue += 'true';
                        } else {
                            optionValue += 'false';
                        }
                        html += '<option value="'+optionValue+'">'+parcelas[i].quantity+' x de R$ '+parcelas[i].installmentAmount.toFixed(2).replace('.',',')+' - Total = R$ '+parcelas[i].totalAmount.toFixed(2).replace('.',',')+'</option>';
                    }
                    $('strong[name=bandeira').html(teste);
                    $('select[name=parcelas').html(html);
                }
            },
            error:function(r) {
                alert("ERRO0");
            },
            complete:function(r) {}
        });
    },
    error:function(r) {
        alert("ERRO1");
    },
    complete:function(r) {}
 });



};
