//Validação fo Formulário de Cliente Pessoa Fisica
function addClientePF(){
    var senha = document.getElementById('senha').value;
    var senha2 = document.getElementById('senha2').value;
    var email = document.getElementById('email').value;
    var email2 = document.getElementById('email2').value;
    var politica = document.getElementById('politica');

    if ($('input[name="nome"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPF.nome.focus();
    }    
    else if ($('input[name="email"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPF.email.focus();
    }
    else if ($('input[name="email2"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPF.email2.focus();
    }
    else if ($('input[name="senha"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPF.senha.focus();
    }
    else if ($('input[name="senha2"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPF.senha2.focus();
    }
    else if (email != email2){
        $('#modalemail').modal('show');
            cadastrarPF.email2.focus();
    } 
    else if (senha != senha2){
        $('#modalsenha').modal('show');
            cadastrarPF.senha2.focus();
    } else if (politica.checked == false){
        $('#modalpolitica').modal('show');
            cadastrarPF.senha2.focus();
    } else if ($('input[name="cpf"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPF.cpf.focus();
    } else {
        var cpf = document.getElementById('cpf').value;
        
        $.ajax({
            url:BASE_URL+"cliente/validaCPF/"+cpf,
            type:'POST',
            success:function(msg) {
                if (msg != '1' ){  

                    $.ajax({                        
                        url:BASE_URL+"cliente/pesquisarCPF/"+cpf,                        
                        type:'POST',
                        success:function(msg2) {				
                            
                            if (msg2 === '1' ){
                                $('#cpfjacadastrado').modal('show');  
                                cadastrarPF.cpf.focus();
                            } else if (msg2 === '0' ){
                                
                                var email = document.getElementById('email').value;
                                
                                $.ajax({                        
                                    url:BASE_URL+"cliente/pesquisarEmail/"+email,                        
                                    type:'POST',
                                    success:function(msg3) {				
                                        
                                        if (msg3 === '1' ){
                                            $('#emailjacadastrado').modal('show');  
                                            cadastrarPF.email.focus();
                                        } else if (msg3 === '0' ){
                                            document.cadastrarPF.submit();
                                        }
                                    }
                                });
                                
                            }
                        }
                    });                       


                } else {
                    $('#modalcpf').modal('show');
                    cadastrarPF.cpf.focus();

                }
            }
        });  
          
    }
   
}

//Validação fo Formulário de Cliente Pessoa Jurídica
function addClientePJ(){
    var senha1 = document.getElementById('senha1').value;
    var senha3 = document.getElementById('senha3').value;
    var email1 = document.getElementById('email1').value;
    var email3 = document.getElementById('email3').value;
    var politica1 = document.getElementById('politica1');

    if ($('input[name="razao"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPJ.razao.focus();
    }    
    else if ($('input[name="email1"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPJ.email1.focus();
    }
    else if ($('input[name="email3"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPJ.email3.focus();
    }
    else if ($('input[name="senha1"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPJ.senha1.focus();
    }
    else if ($('input[name="senha3"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPJ.senha3.focus();
    }
    else if (email1 != email3){
        $('#modalemail').modal('show');
            cadastrarPJ.email2.focus();
    } 
    else if (senha1 != senha3){
        $('#modalsenha').modal('show');
            cadastrarPJ.senha3.focus();
    } else if (politica1.checked == false){
        $('#modalpolitica').modal('show');
            cadastrarPJ.senha3.focus();
    } else if ($('input[name="cnpj"]').val() <= 0){
        $('#modalcampos').modal('show');
        cadastrarPJ.cnpj.focus();
    } else {
        var cnpj = document.getElementById('cnpj').value;
        
        $.ajax({
            url:BASE_URL+"cliente/validaCNPJ/"+cnpj,
            type:'POST',
            success:function(msg) {
                if (msg != '1' ){  
                    
                    $.ajax({                        
                        url:BASE_URL+"cliente/pesquisarCNPJ/"+cnpj,                        
                        type:'POST',
                        success:function(msg2) {				
                            
                            if (msg2 === '1' ){
                                $('#cnpjjacadastrado').modal('show');  
                                cadastrarPJ.cnpj.focus();
                            } else if (msg2 === '0' ){
                                
                                var email = document.getElementById('email1').value;
                                
                                $.ajax({                        
                                    url:BASE_URL+"cliente/pesquisarEmail/"+email,                        
                                    type:'POST',
                                    success:function(msg3) {				
                                        
                                        if (msg3 === '1' ){
                                            $('#emailjacadastrado').modal('show');  
                                            cadastrarPJ.email1.focus();
                                        } else if (msg3 === '0' ){
                                            document.cadastrarPJ.submit();
                                        }
                                    }
                                });
                                
                            }
                        }
                    });                       


                } else {
                    $('#modalcpf').modal('show');
                    cadastrarPF.cpf.focus();

                }
            }
        });  
          
    }
   
}

//Preenchimento Endereço Automático pelo CEP - Webservice ViaCEP dos correios - Pessoa Jurídica
function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
            document.getElementById('ibge').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('rua2').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('bairro2').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('cidade2').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
            document.getElementById('uf2').value=(conteudo.uf);
            document.getElementById('ibge').value=(conteudo.ibge);
              
        } //end if.
        else {
            //CEP não Encontrado.
//            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
       
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
//                document.getElementById('rua').value="...";
//                document.getElementById('bairro').value="...";
//                document.getElementById('cidade').value="...";
//                document.getElementById('uf').value="...";
//                document.getElementById('ibge').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
//                limpa_formulário_cep();
                $('#CEPInvalido').modal('show');
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
//            limpa_formulário_cep();
            $('#CEPInvalido').modal('show');
        }
    };

//Preenchimento Endereço Automático pelo CEP - Webservice ViaCEP dos correios - Pessoa Jurídica


    function my_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            
            document.getElementById('rua1').value=(conteudo.logradouro);
            document.getElementById('bairro1').value=(conteudo.bairro);
            document.getElementById('cidade1').value=(conteudo.localidade);
            document.getElementById('uf1').value=(conteudo.uf);
            document.getElementById('ibge1').value=(conteudo.ibge);
              
        } //end if.
        else {
            //CEP não Encontrado.
//            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
       
    }
        
    function pesquisacep2(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=my_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
//                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
//            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    };


    
//    Validando CPF
function validaCPF(cpf) {
    if ($('input[name="cpf"]').val() <= 0){
        $('#modalcpfvazio').modal('show');
        cadastrarPF.cpf.focus();
    } else if (cadastrarPF.cpf.value.length < 11) {
        $('#modalcpf').modal('show');
        cadastrarPF.cpf.focus();
    } else {
        $.ajax({
            url:BASE_URL+"cliente/validaCPF/"+cpf,
            type:'POST',
            success:function(msg) {
                if (msg != '1' ){  
                    
                } else {
                    $('#modalcpf').modal('show');
                    cadastrarPF.cpf.focus();
                }
            }
        });
    }
}

//    Validando CNPJ
function validaCNPJ(cnpj) {
   
    if ($('input[name="cnpj"]').val() <= 0){
        $('#modalcnpjvazio').modal('show');
        cadastrar.cnpj.focus();
    } else {
        
        $.ajax({
            url:BASE_URL+"cliente/validaCNPJ/"+cnpj,
            type:'POST',
            success:function(msg) {
          
                if (msg != '1' ){ 
                    
                   
                } else {
                    $('#modalcnpj').modal('show');
                    cadastrarPJ.cnpj.focus();
                 
                }
            }
        });
    }
}

function finalizar() {

        var pg = document.querySelector('input[name="formapg"]:checked').value;

        if (pg === "2"){
        document.finalizarCompra.action="cart/meiosPagamento/boleto";
        document.finalizarCompra.submit();
        } else if(pg === "3") {
        document.finalizarCompra.action="cart/meiosPagamento/paypal";
        document.finalizarCompra.submit();
        } else if(pg === "1"){
            document.finalizarCompra.submit();
        }
 
}
 
 function cadastrar(){
      window.location.href = BASE_URL+'cliente/cadastrar';
 }
 
// Modais do Editar Dados do Cliente
 function editar_perfil(id) {
     $.ajax({
        url:BASE_URL+"cliente/getDados/",
        type:'POST',
        data:{
            id:id
        },
        dataType:'json',            
        success:function(json) {
            var data = json.dt_nascimento.split("-") ;
            
            if(data[1] < 10){
                var mes = data[1].split("");
                $('select[name=mes_nasc]').val(mes[1]); 
            } else {
                $('select[name=mes_nasc]').val(data[1]);
            } 
            if(data[2] < 10) {
                var dia = data[2].split("");
               
                $('select[name=dia_nasc]').val(dia[1]); 
                
            } else {
                $('select[name=dia_nasc]').val(data[2]); 
                 
            }
            $('select[name=ano_nasc]').val(data[0]); 
            $('select[name=sexo]').val(json.sexo); 
      
            $('#editar_dados').modal('show');
            
            },
        error:function(){
            alert('ERRO');
        }
    });
    
     

 }
 
 function editar_conta(id) {
    if ($('input[name="nome"]').val() <= 0){
        $('#campos_obrigatorios').modal('show');
    } else if ($('input[name="email"]').val() <= 0){
        $('#campos_obrigatorios').modal('show');
    } else {
        var nome = $('input[name=nome]').val();
        var email = $('input[name=email]').val();
        var dia_nasc = $('select[name=dia_nasc]').val();
        var mes_nasc = $('select[name=mes_nasc]').val();
        var ano_nasc = $('select[name=ano_nasc]').val();
        var sexo = $('select[name=sexo]').val();
        var responsavel = $('input[name=responsavel]').val();
        var tel = $('input[name=tel]').val();
        var cel = $('input[name=cel]').val();    
        
        $.ajax({                        
            url:BASE_URL+"cliente/pesquisarEmailCliente/",
            type:'POST',
            data:{
                id:id,
                email:email
            },
            success:function(msg3) {	
                if (msg3 === '1' ){
                    
                    $.ajax({
                        url:BASE_URL+"cliente/editar",
                        type:'POST',
                        data:{
                            id:id,
                            nome:nome,
                            email:email,
                            dia_nasc:dia_nasc,
                            mes_nasc:mes_nasc,
                            ano_nasc:ano_nasc,
                            sexo:sexo,
                            responsavel:responsavel,
                            tel:tel,
                            cel:cel
                        },
                        success:function(res) {
                          
                            if (res === '1') {
                                $('#editar_concluido').modal('show');
                                $('#editar_dados').modal('hide');
                                window.setTimeout("location.href='"+BASE_URL+"perfil/meus_dados'",2000); 
                            } else if (res === '0') {
                                $('#editar_dados').modal('hide');
                            }
                            
                        }
                    });
                } else if (msg3 === '0' ){
                   $.ajax({                        
                        url:BASE_URL+"cliente/pesquisarEmail/"+email,
                        type:'POST',
                        success:function(msg3) {	
                            if (msg3 === '1' ){
                                $('#emailjacadastrado').modal('show');  
                                cadastrarPJ.email1.focus();
                            } else if (msg3 === '0' ){
                               $.ajax({
                                    url:BASE_URL+"cliente/editar",
                                    type:'POST',
                                    data:{
                                        id:id,
                                        nome:nome,
                                        email:email,
                                        dia_nasc:dia_nasc,
                                        mes_nasc:mes_nasc,
                                        ano_nasc:ano_nasc,
                                        sexo:sexo,
                                        responsavel:responsavel,
                                        tel:tel,
                                        cel:cel
                                    },
                                    success:function(res) {

                                        if (res === '1') {
                                            $('#editar_concluido').modal('show');
                                            $('#editar_dados').modal('hide');
                                            window.setTimeout("location.href='"+BASE_URL+"perfil/meus_dados'",2000); 
                                        } else if (res === '0') {
                                            $('#editar_dados').modal('hide');
                                        }

                                    }
                                });
                            }
                        }
                    });
                }
            },
            error:function(){
                alert('erro');
            }
        });

        
        
    }
 }
 
 function fechar_edtconcluido() {
     $('#editar_concluido').modal('hide');
     window.setTimeout("location.href='"+BASE_URL+"perfil/meus_dados'");
 }
 
  function fechar_cadastro() {
     $('#emailjacadastrado').modal('hide');
 }
 function fechar_campos(){
     $('#campos_obrigatorios').modal('hide');
 }
 
 function excluir_conta(id) {
     $('#excluir_conta').modal('show');
 }
 
 function conta_cancelada(id){
    
     $.ajax({
        url:BASE_URL+"cliente/cancelar/"+id,
        type:'POST',
        success:function() {
            $('#excluir_conta').modal('hide');
            $('#conta_cancelada').modal('show');
            window.setTimeout("location.href='"+BASE_URL+"'",3000);
        }
    });     
 }
 function fechar_excluir_conta() {
     $('#excluir_conta').modal('hide');
 }
 function fechar_editar_conta() {
     $('#editar_dados').modal('hide');
     window.setTimeout("location.href='"+BASE_URL+"perfil/meus_dados'");
 }
 
// Modais Cadastrar Endereço
function abrir_cadastrar_endereco() {
     $('#cadastrar_endereco').modal('show');
 }
 function fechar_cadastrar_endereco() {
     $('#cadastrar_endereco').modal('hide');
 }
function fechar_cep() {
    $('#cep_obrigatorio').modal('hide');
 }
 function cadastrar_endereco(cliente) {
    if ($('input[name="cep"]').val() <= 0){
        $('#cep_obrigatorio').modal('show');
    } else {
        var cep = $('input[name=cep]').val();
        var rua = $('input[name=rua]').val();
        var numero = $('input[name=numero]').val();
        var complemento = $('input[name=complemento]').val();
        var bairro = $('input[name=bairro]').val();
        var cidade = $('input[name=cidade]').val();
        var estado = $('input[name=uf]').val();
        var endereco_principal = $('select[name=end]').val();
         
        
        $.ajax({                        
            url:BASE_URL+"cliente/cadastrarEndereco/",
            type:'POST',
            data:{
                cliente:cliente,
                cep:cep,
                rua:rua,
                numero:numero,
                complemento:complemento,
                bairro:bairro,
                cidade:cidade,
                estado:estado,
                endereco_principal:endereco_principal
            },
            success:function(res) {
               
                if (res === '1') {
                    $('#cadastro_concluido').modal('show');
                    $('#cadastrar_endereco').modal('hide');
                    window.setTimeout("location.href='"+BASE_URL+"perfil/enderecos'",2000); 
                } else if (res === '0') {
                    $('#cadastrar_endereco').modal('hide');
                }
            }
            
         });
     }
 }
  function fechar_cadastro2() {
     $('#cadastro_concluido').modal('hide');
 }
 
 //Modais Editar Endereços
 function abrir_editar_endereco(id) {
     
     $.ajax({                        
            url:BASE_URL+"cliente/getEndereco/",
            type:'POST',
            data:{
                id:id
            },
            dataType:'json',            
            success:function(json) {
               $('input[name=id]').val(json[0].id);
                              
               $('input[name=cep]').val(json[0].cep);
                              
               $('input[name=rua]').val(json[0].rua);
                             
               $('input[name=numero]').val(json[0].numero);
                              
               $('input[name=complemento]').val(json[0].complemento);
               
               $('input[name=bairro]').val(json[0].bairro);
              
               $('input[name=cidade]').val(json[0].cidade);
              
               $('input[name=uf]').val(json[0].estado);
               
               $('select[name=end]').val(json[0].entrega);
               
               $('#editar_endereco').modal('show');
            }, 
            error:function(){
                alert("Erro");
            }
            
         });
 }
function fechar_editar_endereco() {
     $('#editar_endereco').modal('hide');
 }
 function editar_endereco(cliente) {
    if ($('input[name="cep"]').val() <= 0){
        $('#cep_obrigatorio').modal('show');
    } else {   

        var id = $('#editar_endereco').find('.modal-body').find('input[name=id]').val();
        var cep = $('#editar_endereco').find('.modal-body').find('input[name=cep]').val();
        var rua = $('#editar_endereco').find('.modal-body').find('input[name=rua]').val();
        var numero = $('#editar_endereco').find('.modal-body').find('input[name=numero]').val();
        var complemento = $('#editar_endereco').find('.modal-body').find('input[name=complemento]').val();
        var bairro = $('#editar_endereco').find('.modal-body').find('input[name=bairro]').val();
        var cidade = $('#editar_endereco').find('.modal-body').find('input[name=cidade]').val();
        var estado = $('#editar_endereco').find('.modal-body').find('input[name=uf]').val();
        var endereco_principal = $('#editar_endereco').find('.modal-body').find('select[name=end]').val();

        $.ajax({                        
            url:BASE_URL+"cliente/editarEndereco/",
            type:'POST',
            data:{
                id_cliente:cliente,
                id:id,
                cep:cep,
                rua:rua,
                numero:numero,
                complemento:complemento,
                bairro:bairro,
                cidade:cidade,
                estado:estado,
                endereco_principal:endereco_principal
            },
            success:function(res) {
               
                if (res === '1') {
                    $('#editar_concluido').modal('show');
                    $('#editar_endereco').modal('hide');
                    window.setTimeout("location.href='"+BASE_URL+"perfil/enderecos'",2000); 
                } else if (res === '0') {
                    $('#editar_endereco').modal('hide');
                }
            },
            error:function(){
                alert('ERRO');
            }
            
         });

     }
 }
function editar_concluido() {
     $('#editar_concluido').modal('hide');
 }
 
 function excluir_endereco(id) {
     $('input[name=id]').val(id);
     $('#excluir_endereco').modal('show');
 }
 
 function sim_excluir_endereco(){
     var id = $('input[name=id]').val();
    
     $.ajax({
        url:BASE_URL+"cliente/excluirEndereco/",
        type:'POST',
        data:{
            id:id
        },
        success:function(res) {
          
            if (res === '1') {
                $('#endereco_excluido').modal('show');
                $('#excluir_endereco').modal('hide');
                window.setTimeout("location.href='"+BASE_URL+"perfil/enderecos'",2000); 
            } else if (res === '0') {
                $('#excluir_endereco').modal('hide');
            }
            },
        error:function(){
            alert('ERRO');
        }
    });     
 }
 function fechar_excluir_endereco() {
     $('#excluir_endereco').modal('hide');
 }
 
 // Modais Cadastrar Cartão
function abrir_cadastrar_cartao() {
    document.getElementById('numeroCartao').focus();
    $('#cadastrar_cartao').modal('show');
 }
 function fechar_cadastrar_cartao() {
    $('input[name=numeroCartao]').val('');
    $('input[name=bandeira]').val('');
    $('input[name=titular]').val('');
    $('input[name=cpf]').val('');
    $('input[name=cvv]').val('');
    $('#cadastrar_cartao').modal('hide');
      
 }
function fechar_campos_obrigatorios_cartao() {
    $('#campos_obrigatorios').modal('hide');
 }
 function cadastrar_cartao(cliente) {
    if ($('input[name="numeroCartao"]').val() <= 0){
        $('#campos_obrigatorios').modal('show');
    } else if ($('input[name="titular"]').val() <= 0){
        $('#campos_obrigatorios').modal('show');
    } else if ($('input[name="cpf"]').val() <= 0){
        $('#campos_obrigatorios').modal('show');
    } else if ($('input[name="cvv"]').val() <= 0){
        $('#campos_obrigatorios').modal('show');
    } else {
        var num_cartao = $('input[name=numeroCartao]').val();
        var bandeira = $('input[name=bandeira]').val();
        var titular = $('input[name=titular]').val();
        var cpf = $('input[name=cpf]').val();
        var cvv = $('input[name=cvv]').val();
        var mes_venc = $('select[name=mes_venc').val();
        var ano_venc = $('select[name=ano_venc').val();
        var principal = $('select[name=princ]').val();
      
        $.ajax({                        
            url:BASE_URL+"cliente/cadastrarCartao",
            type:'POST',
            data:{
                cliente:cliente,
                num_cartao:num_cartao,
                bandeira:bandeira,
                titular:titular,
                cpf:cpf,
                cvv:cvv,
                mes_venc:mes_venc,
                ano_venc:ano_venc,
                principal:principal
            },
            success:function(res) {
                if (res === '1') {
                    $('#cadastro_concluido').modal('show');
                    $('#cadastrar_cartao').modal('hide');
                    window.setTimeout("location.href='"+BASE_URL+"perfil/cartoes'",2000); 
                } else if (res === '0') {
                    $('#cadastrar_cartao').modal('hide');
                }
            },
            error:function(){
                alert('Não');
            }
            
         });
     }
 }
function fechar_cadastro3() {
     $('#cadastro_concluido').modal('hide');
 }
function fechar_cpf() {
     $('#modalcpfvazio').modal('hide');
}
function fechar_cpf_invalido() {
     $('#modalcpf').modal('hide');
 }
 
  //
 function marcaCartao(){
    PagSeguroDirectPayment.getBrand({
     cardBin: $('input[name=numeroCartao]').val(),
     success:function(r) {
//        Variável Global armazena nome da bandeira
  
        var band = r.brand.name;
        //transforma primeira letra da string em Maiuscula
        var bandeira = band.substr().toUpperCase();
         $('input[name=bandeira]').val(bandeira);
         },
         error:function() {
        alert("Numero do Cartão Incorreto");     
         }
    });
 
}

 //Modais Excluir Cartao
  function excluir_cartao(id) {
     $('input[name=id]').val(id);
     $('#excluir_cartao').modal('show');   
 }
 
 function sim_excluir_cartao(){
     var id = $('input[name=id]').val();
    
     $.ajax({
        url:BASE_URL+"cliente/excluirCartao/",
        type:'POST',
        data:{
            id:id
        },
        success:function(res) {
          
            if (res === '1') {
                $('#cartao_excluido').modal('show');
                $('#excluir_cartao').modal('hide');
                window.setTimeout("location.href='"+BASE_URL+"perfil/cartoes'",700); 
            } else if (res === '0') {
                $('#excluir_cartao').modal('hide');
            }
            },
        error:function(){
            alert('ERRO');
        }
    });     
 }
 function fechar_excluir_cartao() {
     $('#excluir_cartao').modal('hide');
 }
 
//Verificando CPF no cadastro do Cartão
function CPF() {
    
    var cpf = $('input[name=cpf]').val();

   $.ajax({
            url:BASE_URL+"cliente/validaCPF/"+cpf,
            type:'POST',
            success:function(msg) {
                if (msg != '1' ){  
                    
                } else {
                    $('#modalcpf').modal('show');
                    
                }
            }
        });
    
}

//Modais Editar Cartao
 function abrir_editar_cartao(id) {
   
     $.ajax({                        
            url:BASE_URL+"cliente/getCartao/",
            type:'POST',
            data:{
                id:id
            },
            dataType:'json',            
            success:function(json) {
                $('input[name=idcartao]').val(json[0].id);
                 
                $('input[name=numeroCartao]').val(json[0].numero);
                              
               $('input[name=bandeira]').val(json[0].bandeira);
                              
                $('input[name=titular]').val(json[0].titular);
                             
                $('input[name=cpf]').val(json[0].cpf);
                              
               $('input[name=cvv]').val(json[0].cvv);
               
                $('select[name=mes_venc]').val(json[0].validade_mes);
              
                $('select[name=ano_venc]').val(json[0].validade_ano);    
               
                $('#editar_cartao').modal('show');
            }, 
            error:function(){
                alert("Erro");
            }
            
         });
 }
function fechar_editar_cartao() {
    $('input[name=numeroCartao]').val('');
    $('input[name=bandeira]').val('');
    $('input[name=titular]').val('');
    $('input[name=cpf]').val('');
    $('input[name=cvv]').val('');
    $('#editar_cartao').modal('hide');
 }
 function editar_cartao(cliente) {
    var id = $('#editar_cartao').find('.modal-body').find('input[name=idcartao]').val();
    var cartao = $('#editar_cartao').find('.modal-body').find('input[name=numeroCartao]').val();
    var bandeira = $('#editar_cartao').find('.modal-body').find('input[name=bandeira]').val();
    var titular = $('#editar_cartao').find('.modal-body').find('input[name=titular]').val();
    var cpf = $('#editar_cartao').find('.modal-body').find('input[name=cpf]').val();
    var cvv = $('#editar_cartao').find('.modal-body').find('input[name=cvv]').val();
    var mes_venc = $('#editar_cartao').find('.modal-body').find('select[name=mes_venc]').val();
    var ano_venc = $('#editar_cartao').find('.modal-body').find('select[name=ano_venc]').val();
    var principal = $('#editar_cartao').find('.modal-body').find('select[name=princ]').val();
    
    if (cartao <= 0){
        $('#campos_obrigatorios').modal('show');
    } else if (titular <= 0){
        $('#campos_obrigatorios').modal('show');
        } else if (cpf <= 0){
            $('#campos_obrigatorios').modal('show');
            } else if (cvv <= 0){
                $('#campos_obrigatorios').modal('show');
                } else { 
                    
                    $.ajax({                        
                        url:BASE_URL+"cliente/editarCartao/",
                        type:'POST',
                        data:{
                            id_cliente:cliente,
                            id:id,
                            cartao:cartao,
                            bandeira:bandeira,
                            titular:titular,
                            cpf:cpf,
                            cvv:cvv,
                            mes_venc:mes_venc,
                            ano_venc:ano_venc,
                            principal:principal
                        },
                        success:function(res) {

                            if (res === '1') {
                                $('#editar_cartao_concluido').modal('show');
                                $('#editar_cartao').modal('hide');
                                window.setTimeout("location.href='"+BASE_URL+"perfil/cartoes'",2000); 
                            } else if (res === '0') {
                                $('#editar_cartao').modal('hide');
                            }
                        },
                        error:function(){
                            alert('ERRO');
                        }

                     });

                 }
 }
function editar_cartao_concluido() {
     $('#editar_cartao_concluido').modal('hide');
 }
 
 function abrir_editar_foto() {
     $('#editar_foto').modal('show');
 }
 //Editar Foto do Perfil
 function fecharfoto() {
     event.preventDefault();
     $('#editar_foto').modal('hide');
 }
 //Pedidos
 function pedidos(id) {
     $.ajax({
        url:BASE_URL+"cliente/dadosProduto",
        type:'POST',
        data:{
            id_pedido:id
        },
        dataType:'json',
        success:function(json){
           for (var i = 0; i <= json.length; i++){               
            var valor = number_format(json[i].valor_produto,2, ',', '.');
            var html = '';
            html = '<tr><td><img src="'+BASE_URL+'media/produtos/'+json[i].imagem+'" width="80"/></td>\n\
                <td>'+json[i].nome+'</td>\n\
                <td>'+json[i].quantidade+'</td>\n\
                <td>R$ '+valor+'</td></tr>';
            $("#produto").html(html);  
            }
        },
        error:function(){
         alert("Erro");
         }
     });
    
     $.ajax({                        
            url:BASE_URL+"cliente/pedido/",
            type:'POST',
            data:{
                id:id
            },
            dataType:'json',            
            success:function(json) {
//                $('input[name=idcartao]').val(json[0].id);
                
            var date = json[0].data.split("-");
            var date1 = date[2].split(" ");
            var date2 = date1[1].split(":");
            var data = date1[0]+"/"+date[1]+"/"+date[0]+" "+date2[0]+":"+date2[1];
            
           
                $('input[name=pedido]').val(json[0].pedido);                              
                $('input[name=data]').val(data);                              
                $('input[name=forma_de_pagamento]').val(json[0].forma_de_pagamento);
                
                if(json[0].forma_de_pagamento === 'Cartão'){
                    $.ajax({
                        url:BASE_URL+"cliente/dadosCartao",
                        type:'POST',
                        data:{
                            id_pedido:id
                        },
                        dataType:'json',
                        success:function(json){
                            var html = '';
                            html = '<label>Titular: </label> <input name="titular" disabled="disabled" \n\
value="'+json[0].titular+'" /><label>Número do Cartão: </label> <input name="numero" disabled="disabled" \n\
value="'+json[0].numero+'" /><label>Bandeira: </label> <input name="bandeira" disabled="disabled" \n\
value="'+json[0].bandeira+'" />';
                            $("#forma-pgto").html(html);  
                        },
                        error:function(){
                         alert("Erro");
                         }
                     });
                     
                } else if(json[0].forma_de_pagamento === 'Boleto'){
                    $.ajax({
                        url:BASE_URL+"cliente/dadosVenda",
                        type:'POST',
                        data:{
                            id_pedido:id
                        },
                        dataType:'json',
                        success:function(json){
                            var html = '';
                            html = '<a href="'+json[0].link_boleto+'" target="_blank" id="noprint">Imprimir Boleto</a>';
                            $("#forma-pgto").html(html);  
                        },
                        error:function(){
                         alert("Erro Link Boleto");
                         }
                     });
                     
                } else{
                    var html = '';
                    
                    $("#forma-pgto").html(html); 
                }
                id_endereco = json[0].id_endereco;
               $.ajax({
                   url:BASE_URL+"cliente/endereco",
                   type:'POST',
                   data:{
                       id_endereco:id_endereco,
                   },
                   dataType:'json',
                   success:function(json){
                       $('input[name=rua]').val(json[0].rua);
                       $('input[name=numero]').val(json[0].numero);
                       $('input[name=bairro]').val(json[0].bairro);
                       $('input[name=complemento]').val(json[0].coplemento);
                       $('input[name=cidade]').val(json[0].cidade);
                       $('input[name=estado]').val(json[0].estado);
                       $('input[name=cep]').val(json[0].cep);
                   },
                   error:function(){
                    alert("Erro");
                    }
                });
                $.ajax({                       
                    url:BASE_URL+"cliente/dadosVenda",
                    type:'POST',
                    data:{
                        id_pedido:id
                    },
                    dataType:'json',
                    success:function(json){
                        $('input[name=valor]').val("R$ "+number_format(json[0].total_compra,2, ',', '.'));
                        

                        switch(json[0].status_pagamento){
                            case '1':
                            $('input[name=status]').val('Aguardando Pagamento');
                            break;
                            case '2':
                            $('input[name=status]').val('Em Análise');
                            break;
                            case '3':
                            $('input[name=status]').val('Pagamento Aprovado');
                                var date = json[0].pagamento_confirmado.split("-");
                                var date1 = date[2].split(" ");
                                var date2 = date1[1].split(":");
                                var data = date1[0]+"/"+date[1]+"/"+date[0]+" "+date2[0]+":"+date2[1];
                                var html = '';
                                html = '<input name="datas" disabled="disabled" \n\
    value="'+data+'" />';
                                $("#data-pgto").html(html);  
                                document.getElementById("barc").style.background = "#1B2956";
                                document.getElementById("icone1").style.color = "#1B2956";
                          
                            break;
                        }
                        if(json[0].separacao === "1") {
                            var date = json[0].separacao_em.split("-");
                            var date1 = date[2].split(" ");
                            var date2 = date1[1].split(":");
                            var data = date1[0]+"/"+date[1]+"/"+date[0]+" "+date2[0]+":"+date2[1];
                            var html = '';
                            html = '<input name="datas" disabled="disabled" \n\
value="'+data+'" />';
                            $("#data-separacao").html(html);  
                            document.getElementById("barc1").style.background = "#1B2956";
                            document.getElementById("icone2").style.color = "#1B2956";
                        }
                        if(json[0].postado === "1") {
                            var date = json[0].postado_em.split("-");
                            var date1 = date[2].split(" ");
                            var date2 = date1[1].split(":");
                            var data = date1[0]+"/"+date[1]+"/"+date[0]+" "+date2[0]+":"+date2[1];
                            var html = '';
                            html = '<input name="datas" disabled="disabled" \n\
value="'+data+'" />';
                            $("#data-postado").html(html);  
                            document.getElementById("barc2").style.background = "#1B2956";
                            document.getElementById("icone3").style.color = "#1B2956";
                            var rastreador = '';
                            rastreador = '<label>Código de Rastreio: </label> <input name="datas" disabled="disabled" \n\
value="'+json[0].rastreador+'" />';
                            $("#rastreador").html(rastreador);
                        } else {
                            var date = json[0].prazo.split("-");
                            var data = date[2]+"/"+date[1]+"/"+date[0];
                            var rastreador = '';
                            rastreador = '<label>Previsão de Entrega: </label> <input name="datas" disabled="disabled" \n\
value="'+data+'" />';
                            $("#rastreador").html(rastreador);
                        }
                         if(json[0].entregue === "1") {
                            var date = json[0].entregue_em.split("-");
                            var date1 = date[2].split(" ");
                            var date2 = date1[1].split(":");
                            var data = date1[0]+"/"+date[1]+"/"+date[0]+" "+date2[0]+":"+date2[1];
                            var html = '';
                            html = '<input name="datas" disabled="disabled" \n\
value="'+data+'" />';
                            $("#data-entregue").html(html);  
                            
                            document.getElementById("barc3").style.background = "#1B2956";
                            document.getElementById("icone4").style.color = "#1B2956";
                        }
                    },
                    error:function(){
                        alert("ERRO");
                    }
                });
                $('#pedidos').modal('show');
            }, 
            error:function(){
                alert("Erro");
            }
            
         });
 }
  function fechar_pedido() {
     $('#pedidos').modal('hide');
     window.setTimeout("location.href='"+BASE_URL+"perfil/pedidos'");
 }
function fechar_cep_invalido(){
    $('#CEPInvalido').modal('hide');
}
function number_format( number, decimals, dec_point, thousands_sep ) {
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "," : dec_point;
    var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};