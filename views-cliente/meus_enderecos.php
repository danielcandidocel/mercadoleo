
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
<div class="col-md-9">   
    <h3 style="text-align: center"><b>Meus Endereços</b></h3><br/>
  <?php if(empty($dados)): ?>
        <h5 style="text-align: center"><b>Não Há Endereços Cadastrados</b></h5>
        <a href="javascript:;" onclick="abrir_cadastrar_endereco()"><span id="end_cadatrar">Cadastrar</span></a>

    <?php else: ?>
        <a href="javascript:;" onclick="abrir_cadastrar_endereco()"><span id="end_cadatrar">Cadastrar Novo Endereço</span></a>
  <?php    foreach ($dados as $info): ?>
    <div class="col-md-12 endereco">
        <a href="javascrip:;" onclick="abrir_editar_endereco(<?php echo $info['id']; ?>)"><span id="sair">Editar</span></a>
        <div class="col-md-6">
            <div class="form-group">
                <label>Rua:</label>
                <em><?php echo $info['rua'];?></em>
            </div>  
            <div class="form-group">
                <label>Bairro:</label>
                <em><?php echo $info['bairro'];?></em>
            </div> 
            <div class="form-group">
                <label>Cidade:</label>
                <em><?php echo $info['cidade'];?></em>
            </div> 
                 
            <div class="form-group">
                <?php if($info['entrega'] == 1): ?>
                <label>Endereço de Entrega: SIM.</label>
                <?php else: ?>
                <label>Endereço de Entrega: <strong style="color:red">NÃO.</strong></label>
            <?php endif; ?>
            </div>
              <div class="form-group">
             
        <a href="javascrip:;" onclick="excluir_endereco(<?php echo $info['id']; ?>)"><span id="excluir">Excluir Endereço</span></a>
     
            </div>
        </div>

        <div class="col-md-5">
            <div class="form-group">
                <label>Número:</label>
                <em><?php echo $info['numero'];?></em>
            </div>
            <?php if (!empty($info['complemento'])): ?>
            <div class="form-group">
                <label>Complemento:</label>
                <em><?php echo $info['complemento'];?></em>
            </div> 
            <?php endif; ?>
            <div class="form-group">
                <label>Estado:</label>
                <em><?php echo $info['estado'];?></em>
            </div>    
            <div class="form-group">
                <label>Cep:</label>
                <em><?php echo $info['cep'];?></em>
            </div> 
          
        </div>  
        
    </div>         
    <?php  endforeach; ?>          
        <a href="javascript:;" onclick="abrir_cadastrar_endereco()"><span id="end_cadatrar">Cadastrar Novo Endereço</span></a>
        <?php endif;
        ?>
</div>

<!--Modal Cadastrar Novo Endereço-->
<div id="cadastrar_endereco" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="width:150%; margin-left: -25%">
            <div class="modal-body">
                <h3>Cadastrar Novo Endereço:</h3><br/><br/>
                <div class="form-group">                 
                    <label class="col-sm-2">CEP:</label>
                    <input type="text" name="cep" class="col-sm-4" id="cep" value="" size="10" maxlength="9" onblur="pesquisacep(this.value);"  /><br/><br/>
                    <label class="col-sm-2">Rua:</label>
                    <input type="text" name="rua" id="rua" class="col-sm-10" placeholder=""><br/><br/>
                    <label class="col-sm-2">Numero:</label>
                    <input type="text" name="numero" id="numero" class="col-sm-2" placeholder="">
                    <label class="col-sm-2">Complemento:</label>
                    <input type="text" name="complemento" id="complemento" class="col-sm-6" placeholder="" ><br/><br/>
                    <label class="col-sm-2">Bairro:</label>
                    <input type="text" name="bairro" id="bairro" class="col-sm-4" placeholder=""><br/><br/>
                    <label class="col-sm-2">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" class="col-sm-6" placeholder="">
                    <label class="col-sm-2">Estado:</label>
                    <input type="text" name="uf" id="uf" class="col-sm-2" placeholder=""><br/><br/>
                    <label class="col-sm-4">Endereço Principal (Entrega):</label>
                    <select name="end">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select><br/><br/><br/>
                    <div style="text-align: center;">
                        <a href="javascript:;" onclick="cadastrar_endereco(<?php echo $_SESSION['ML_login']; ?>)" class="button-logar" style="margin-right: 50px">Cadastrar</a>
                        <a href="javascript:;" onclick="fechar_cadastrar_endereco()" class="button-cancelar">Cancelar</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cep_obrigatorio" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h2>O CEP é Obrigatório!</h2><br/><br/>
                <a href="javascript:;" onclick="fechar_cep()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

<div id="cadastro_concluido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h3>Cadastro Concluído com Sucesso!</h3><br/><br/>
                <a href="javascript:;" onclick="fechar_cadastro2()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

<!--Modal Editar Endereço-->
<div id="editar_endereco" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="width:150%; margin-left: -25%">
            <div class="modal-body">
                <h3>Editar Endereço:</h3><br/><br/>
                <div class="form-group">  
               
                    <input type="hidden" name="id" id="id">
                    <label class="col-sm-2">CEP:</label>
                    <input type="text" name="cep" class="col-sm-4" id="cep" value="" size="10" maxlength="9" onblur="pesquisacep(this.value);" /><br/><br/>
                    <label class="col-sm-2">Rua:</label>                    
                    <input type="text" name="rua" id="rua2" class="col-sm-10" placeholder=""><br/><br/>
                    <label class="col-sm-2">Numero:</label>
                    <input type="text" name="numero" id="numero" class="col-sm-2" placeholder="">
                    <label class="col-sm-2">Complemento:</label>
                    <input type="text" name="complemento" id="complemento" class="col-sm-6" placeholder=""><br/><br/>
                    <label class="col-sm-2">Bairro:</label>
                    <input type="text" name="bairro" id="bairro2" class="col-sm-4" placeholder=""><br/><br/>
                    <label class="col-sm-2">Cidade:</label>
                    <input type="text" name="cidade" id="cidade2" class="col-sm-6" placeholder="">
                    <label class="col-sm-2">Estado:</label>
                    <input type="text" name="uf" id="uf2" class="col-sm-2" placeholder=""><br/><br/>
                    <label class="col-sm-4">Endereço Principal (Entrega):</label>                    
                    <select name="end">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select><br/><br/><br/>
             
                    <div style="text-align: center;">
                        <a href="javascript:;" onclick="editar_endereco(<?php echo $_SESSION['ML_login']; ?>)" class="button-logar" style="margin-right: 50px">Editar</a>
                        <a href="javascript:;" onclick="fechar_editar_endereco()" class="button-cancelar">Cancelar</a>
                        
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="editar_concluido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h3>Endereço Editado com Sucesso!</h3><br/><br/>
                <a href="javascript:;" onclick="fechar_editar()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

<!--Modal para Excluir Endereço-->

<div id="excluir_endereco" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; margin-bottom: 50px">
                <h3><strong>Deseja Realmente Excluir este Endereço?</strong></h3><br/><br/>
                <input type="hidden" name="id" />
                <a href="javascript:;" onclick="sim_excluir_endereco()" class="button-logar">SIM</a>
                <a href="javascript:;" onclick="fechar_excluir_endereco()" class="button-nao">NÃO</a>
            </div>
        </div>
    </div>
</div>

<div id="endereco_excluido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h2>Endereço Excluído com Sucesso!</h2><br/><br/>
                <a href="<?php echo BASE_URL;?>perfil/enderecos" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>