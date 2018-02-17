
<?php $this->loadViewCliente('conta', $viewData);

?>
<div class="back-finalizar">
    <?php if(isset($tipo)):
        if ($tipo == 'boleto'): ?>
            <a href="<?php echo BASE_URL?>boleto"><span>Voltar para Finalizar Compra</span></a>
        <?php elseif ($tipo == 'paypal'): ?>
            <a href="<?php echo BASE_URL?>paypal"><span>Voltar para Finalizar Compra</span></a>
        <?php elseif ($tipo == 'pagseguro'): ?>
            <a href="<?php echo BASE_URL?>pagseguro"><span>Voltar para Finalizar Compra</span></a>
        <?php endif; ?>
    <?php endif; ?>
</div>
<div class="col-md-9 user">
    
    <h3 style="text-align: center"><b>Meus Dados</b></h3><br/>
    <a href="javascript:;" onclick="editar_perfil(<?php echo $dados['id']; ?>)"><span id="sair">Editar</span></a>
    <div class="form-group">
        <label>Nome:</label>
        <em><?php echo $dados['nome'];?></em>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <em><?php echo $dados['email'];?></em>
    </div>
    <?php if($dados['cpf'] > 0):?>
    <div class="form-group">
        <label>Sexo:</label>
        <em><?php 
        $sexo = $dados['sexo'];
        if($sexo == 0) {
            echo 'Masculino';
        } else { echo 'Feminino';}
        ?></em>
    </div>
    <div class="form-group">
        <label>Data de Nascimento:</label>
        <em><?php 
        $date = $dados['dt_nascimento'];
        echo date('d/m/Y', strtotime($date));?></em>
    </div>
    <div class="form-group">        
        <label>CPF:</label>
        <em><?php echo $dados['cpf'];?></em>
        </div>
        <?php else: ?>
    <div class="form-group">
        <label for="nome">CNPJ:</label>
        <em><?php echo $dados['cnpj'];?></em>        
    </div>
    <div class="form-group">
        <label>Responsavel:</label>
        <em><?php echo $dados['responsavel'];?></em>
    </div>  
        <?php endif; ?>
    <div class="form-group">
        <label>Telefone:</label>
        <em><?php echo $dados['tel'];?></em>
    </div>
    <div class="form-group">
        <label>Celular:</label>
        <em><?php echo $dados['cel'];?></em>
    </div>
   
    <h6 id="cancel_account"><a href="javascript:;" onclick="excluir_conta(<?php echo $dados['id']; ?>)">Cancelar Conta</a></h6>

</div>


<!--Modal para Editar Dados-->

<div id="editar_dados" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="width:150%; margin-left: -25%">
            <div class="modal-body">
                <h3><b>Editar Meus Dados</b></h3><br/>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $dados['id']; ?>" />
                    <label class="col-sm-3">Nome:</label>
                    <input class="col-sm-9" type="text" name="nome" value="<?php echo $dados['nome']; ?>" /><br/><br/>
                        
                    <label class="col-sm-3">E-mail:</label>
                    <input class="col-sm-9" type="text" name="email" value="<?php echo $dados['email']; ?>" /><br/><br/>
                          
                <?php if($dados['cpf'] > 0):?>               
               
                    <label class="col-md-3">Data de Nascimento:</label>
                    <div class="col-md-9">
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
                    </div><br/><br/>
               
                    <label class="col-md-3">Sexo:</label>
                    <div class="col-md-9"> 
                     <select name="sexo">
                         <option value="0">Masculino</option>
                         <option value="1">Feminino</option>
                        </select>
                    </div><br/><br/>
               
                    <?php else: ?>
                
                    <label class="col-md-3">Responsavel:</label>
                   <input class="col-md-9" type="text" name="responsavel" value="<?php echo $dados['responsavel'];?>" /><br/><br/>
                    <?php endif; ?>
                
                    <label class="col-md-3">Telefone:</label>

                        <input class="col-md-9" type="tel" name="tel" value="<?php echo $dados['tel'];?>" /><br/><br/>

                
                    <label class="col-md-3">Celular:</label>

                        <input class="col-md-9" type="tel" name="cel" value="<?php echo $dados['cel'];?>" /><br/><br/>

                </div>
                <div style="text-align: center;">
                    <a href="javascript:;" onclick="editar_conta(<?php echo $dados['id']; ?>)" class="button-logar" style="margin-right: 50px">Salvar</a>
                    <a href="javascript:;" onclick="fechar_editar_conta()" class="button-cancelar">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="campos_obrigatorios" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h2>Preencha os Campos Obrigatórios!</h2><br/><br/>
                <a href="javascript:;" onclick="fechar_campos()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

<div id="editar_concluido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h3>Campos Editados com Sucesso!</h3><br/><br/>
                <a href="javascript:;" onclick="fechar_edtconcluido()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

<div id="emailjacadastrado" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h3>E-mail Já Cadastrado!</h3><br/><br/>
                <a href="javascript:;" onclick="fechar_cadastro()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>
<!--Modal para Excluir Conta-->

<div id="excluir_conta" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; margin-bottom: 50px">
                <h3><strong>Deseja Realmente Cancelar a Conta?</strong></h3><br/><br/>
                <a href="javascript:;" onclick="conta_cancelada(<?php echo $dados['id']; ?>)" class="button-logar">SIM</a>
                <a href="javascript:;" onclick="fechar_excluir_conta()" class="button-nao">NÃO</a>
            </div>
        </div>
    </div>
</div>

<div id="conta_cancelada" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h2>Conta Cancelada!</h2><br/><br/>
                <a href="<?php echo BASE_URL;?>" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>
