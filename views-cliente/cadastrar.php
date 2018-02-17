<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#PF">Pessoa Física</a></li>
  <li><a data-toggle="tab" href="#PJ">Pessoa Jurídica</a></li>
</ul>

<div class="tab-content">
    <div id="PF" class="tab-pane fade in active">
        <h2><strong>Preencha os Campos Abaixo:</strong></h2>
        <form class="form-horizontal" name="cadastrarPF" action="<?php echo BASE_URL;?>cliente/addPF" method="POST">
            <div class="col-md-6 cadastrar-pf">
                <div class="form-group">
                    <label class="control-label col-sm-4">Nome: *</label>
                    <div class="col-sm-8">
                        <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite seu Nome" required="required">
                    </div>
                </div>                           
                <div class="form-group">
                    <label class="control-label col-sm-4">CPF (somente números): *</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Digite seu CPF" size="12" maxlength="11" onblur="CPF()">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Data de Nascimento:</label>
                    <div class="col-sm-5"> 
                        <select name="dia_nasc">
                            <?php for($q=1;$q<=31;$q++): ?>
                            <option><?php echo $q;?></option>
                            <?php endfor;?>
                        </select>
                        <select name="mes_nasc">
                            <?php for($q=1;$q<=12;$q++): ?>
                            <option value="<?php echo $q; ?>"><?php
                            switch ($q) {
                            case 1 : 
                                $mes = 'Janeiro';
                                break;
                            case 2 : 
                                $mes = 'Fevereiro';
                                break;
                            case 3 : 
                                $mes = 'Março';
                                break;
                            case 4 : 
                                $mes = 'Abril';
                                break;
                            case 5 : 
                                $mes = 'Maio';
                                break;
                            case 6 : 
                                $mes = 'Junho';
                                break;
                            case 7 : 
                                $mes = 'Julho';
                                break;
                            case 8 : 
                                $mes = 'Agosto';
                                break;
                            case 9 : 
                                $mes = 'Setembro';
                                break;
                            case 10 : 
                                $mes = 'Outubro';
                                break;
                            case 11 : 
                                $mes = 'Novembro';
                                break;
                            case 12 : 
                                $mes = 'Dezembro';
                                break;
                            }
                            echo $mes;?></option>
                            <?php endfor;?>
                        </select>
                        <select name="ano_nasc">
                            <?php 
                            $ano = date('Y');
                            for($q=$ano;$q>=($ano-80);$q--): ?>
                            <option><?php echo $q;?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <label class="control-label col-sm-1" style="margin-left: -24px;">Sexo:</label>
                    <div class="col-sm-2"> 
                     <select name="sexo">
                         <option value="0">Masculino</option>
                         <option value="1">Feminino</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">CEP:</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="cep" class="form-control" id="cep" value="" size="10" maxlength="9" onblur="pesquisacep(this.value);"  />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Rua:</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="rua" id="rua" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Nº:</label>
                    <div class="col-sm-2"> 
                        <input type="text" name="numero" id="numero" class="form-control" placeholder="Nº">
                    </div>
                    <label class="control-label col-sm-1">Bairro:</label>
                    <div class="col-sm-5"> 
                        <input type="text" name="bairro" id="bairro" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Complemento:</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="complemento" id="complemento" class="form-control" placeholder="Digite o Complemento">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Cidade:</label>
                    <div class="col-sm-4"> 
                        <input type="text" name="cidade" id="cidade" class="form-control" placeholder="">
                    </div>
                    <label class="control-label col-sm-2">Estado:</label>
                    <div class="col-sm-2"> 
                        <input type="text" name="uf" id="uf" class="form-control" placeholder="">
                    </div>
                </div>
            </div>

            <div class="col-md-6 cadastrar-pf">
                <div class="form-group">
                    <label class="control-label col-sm-4">Telefones:</label>
                    <div class="col-sm-4">
                      <input type="text" name="tel" class="form-control" placeholder="Digite seu Telefone">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="cel" class="form-control" placeholder="Digite seu Celular">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">E-mail: *</label>
                    <div class="col-sm-8">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu E-mail" required="required" value="<?php echo $email;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Repita seu E-mail: *</label>
                    <div class="col-sm-8">
                        <input type="email" name="email2" id="email2" class="form-control" placeholder="Repita seu E-mail" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Senha: *</label>
                    <div class="col-sm-8"> 
                        <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite a Senha de Acesso" required="required">
                    </div>
                </div>   
                <div class="form-group">
                    <label class="control-label col-sm-4">Repita a Senha: *</label>
                    <div class="col-sm-8"> 
                        <input type="password" name="senha2" id="senha2" class="form-control" placeholder="Repita a Senha" required="required">
                    </div>
                </div> 
                <div class="form-group"> 
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="checkbox">
                            <label><input type="checkbox" checked="checked" name="newsletter"> Receber Mensagens com Promoções e Informativos</label>
                        </div>
                    </div>
                </div>
                 <div class="form-group"> 
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="checkbox">
                            <label><input type="checkbox" name="politica" id="politica" required="required"> Concordo com a Política de Privacidade</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="float:right"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="button" onclick="addClientePF()" class="button-logar" value="Cadastrar" />
                    </div>
                </div>
            </div>
        </form>
  </div>
  
    <!--Cadastro Pessoa Jurídica-->
    <div id="PJ" class="tab-pane fade">
    <h2><strong>Preencha os Campos Abaixo:</strong></h2>
        <form class="form-horizontal" name="cadastrarPJ" action="<?php echo BASE_URL;?>cliente/addPJ" method="POST">
            <div class="col-md-6 cadastrar-pf">
                <div class="form-group">
                    <label class="control-label col-sm-4">Razão Social: *</label>
                    <div class="col-sm-8">
                        <input type="text" name="razao" class="form-control" placeholder="Digite a Razão Social" required="required">
                    </div>
                </div>                           
                <div class="form-group">
                    <label class="control-label col-sm-4">CNPJ (somente números): *</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="Digite CNPJ" size="15" maxlength="14">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Responsável:</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="responsavel" id="responsavel" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">CEP:</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="cep1" class="form-control" id="cep" value="" size="10" maxlength="9" onblur="pesquisacep2(this.value);"  />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Rua:</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="rua1" id="rua1" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Nº:</label>
                    <div class="col-sm-2"> 
                        <input type="text" name="numero1" id="numero" class="form-control" placeholder="Nº">
                    </div>
                    <label class="control-label col-sm-1">Bairro:</label>
                    <div class="col-sm-5"> 
                        <input type="text" name="bairro1" id="bairro1" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Complemento:</label>
                    <div class="col-sm-8"> 
                        <input type="text" name="complemento1" id="complemento" class="form-control" placeholder="Digite o Complemento">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Cidade:</label>
                    <div class="col-sm-4"> 
                        <input type="text" name="cidade1" id="cidade1" class="form-control" placeholder="">
                    </div>
                    <label class="control-label col-sm-2">Estado:</label>
                    <div class="col-sm-2"> 
                        <input type="text" name="uf1" id="uf1" class="form-control" placeholder="">
                    </div>
                </div>
            </div>

            <div class="col-md-6 cadastrar-pf">
                <div class="form-group">
                    <label class="control-label col-sm-4">Telefones:</label>
                    <div class="col-sm-4">
                      <input type="text" name="tel1" class="form-control" placeholder="Telefone de Contato">
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="cel1" class="form-control" placeholder="Celular de Contato">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">E-mail: *</label>
                    <div class="col-sm-8">
                        <input type="email" name="email1" id="email1" class="form-control" placeholder="Digite um E-mail de Contato" required="required" value="<?php echo $email;?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Repita seu E-mail: *</label>
                    <div class="col-sm-8">
                        <input type="email" name="email3" id="email3" class="form-control" placeholder="Repita o E-mail" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Senha: *</label>
                    <div class="col-sm-8"> 
                        <input type="password" name="senha1" id="senha1" class="form-control" placeholder="Digite uma Senha de Acesso" required="required">
                    </div>
                </div>   
                <div class="form-group">
                    <label class="control-label col-sm-4">Repita a Senha: *</label>
                    <div class="col-sm-8"> 
                        <input type="password" name="senha3" id="senha3" class="form-control" placeholder="Repita a Senha" required="required">
                    </div>
                </div> 
                <div class="form-group"> 
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="checkbox">
                            <label><input type="checkbox" checked="checked" name="newsletter1" value="1"> Receber Mensagens com Promoções e Informativos</label>
                        </div>
                    </div>
                </div>
                 <div class="form-group"> 
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="checkbox">
                            <label><input type="checkbox" name="politica1" id="politica1" required="required"> Concordo com a Política de Privacidade</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="float:right"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="button" onclick="addClientePJ()" class="button-logar" value="Cadastrar" />
                    </div>
                </div>
            </div>
        </form>
  
    </div>
    
</div>
<!--Modal Senha Diferente-->

<div class="modal fade" role='dialog' id='modalsenha' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Repita a Senha conforme a Senha digitada acima.</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM Modal Senha Diferente-->

<!--Modal E-mail Diferente-->

<div class="modal fade" role='dialog' id='modalemail' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Repita o E-mail conforme o E-mail digitado acima.</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal Campos Obrigatórios-->

<div class="modal fade" role='dialog' id='modalcampos' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Preencha os Campos Obrigatórios</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal Politica de Privacidade-->

<div class="modal fade" role='dialog' id='modalpolitica' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Selecione a Política de Privacidade</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal CPF Vazio-->

<div class="modal fade" role='dialog' id='modalcpfvazio' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Preencha o CPF</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal CPF Inválido-->

<div class="modal fade" role='dialog' id='modalcpf' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>CPF Inválido</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal CPF Vazio-->

<div class="modal fade" role='dialog' id='modalcnpjvazio' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Preencha o CNPJ</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal CPF Inválido-->

<div class="modal fade" role='dialog' id='modalcnpj' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>CNPJ Inválido</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal Cadastro Realizado com Sucesso-->

<div class="modal fade" role='dialog' id='modalcadastrosucesso' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Cadastro Realizado com Sucesso</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal Cadastro Realizado com Sucesso-->

<div class="modal fade" role='dialog' id='cpfjacadastrado' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>CPF Já Cadastrado</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal Cadastro Realizado com Sucesso-->

<div class="modal fade" role='dialog' id='emailjacadastrado' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Email Já Cadastrado</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->

<!--Modal Cadastro Realizado com Sucesso-->

<div class="modal fade" role='dialog' id='cnpjjacadastrado' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>CNPJ Já Cadastrado</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->
<div id="CEPInvalido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; margin-bottom: 50px">
                <h3><strong>CEP Inválido</strong></h3><br/><br/>
                
                <a href="javascript:;" onclick="fechar_cep_invalido()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>