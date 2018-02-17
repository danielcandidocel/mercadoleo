
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
    <h3 style="text-align: center"><b>Meus Cartões</b></h3><br/>
   <?php if(empty($dados)): ?>
        
        <h5 style="text-align: center"><b>Não há Cartões Cadastrados</b></h5>
        <a href="javascript:;" onclick="abrir_cadastrar_cartao()"><span id="end_cadatrar">Cadastrar</span></a>

    <?php else: ?>
        <a href="javascript:;" onclick="abrir_cadastrar_cartao()"><span id="end_cadatrar">Cadastrar Novo Cartão</span></a>
    <?php    foreach ($dados as $info): ?>       
    
        <div class="col-md-12 endereco">
            <input type="hidden" value="<?php echo $info['id']; ?>" />
            <a href="javascript:;" onclick="abrir_editar_cartao(<?php echo $info['id']; ?>)"><span id="sair">Editar</span></a>
            <div class="col-md-6">                
                <div class="form-group">
                    <label>Bandeira:</label>
                    <em><?php echo ($info['bandeira']); ?></em>
                </div> 
                <div class="form-group">
                    <label>Número:</label>
                    <em><?php echo $info['numero'];?></em>
                </div> 
                <div class="form-group">
                    <label>Titular do Cartão:</label>
                    <em><?php echo $info['titular'];?></em>
                </div>
                <div class="form-group">
                    <?php if($info['principal'] == 1): ?>
                    <label>Cartão de Cobrança: SIM.</label>
                    <?php else: ?>
                    <label>Cartão de Cobrança: <strong style="color:red">NÃO.</strong></label>
                <?php endif; ?>
                </div>

                 <div class="form-group">             
                    <a href="javascrip:;" onclick="excluir_cartao(<?php echo $info['id']; ?>)"><span id="excluir">Excluir Cartão</span></a>     
                </div>
            </div>

            <div class="col-md-5">                
                <div class="form-group">
                    <label>Validade:</label>
                    <em><?php echo $info['validade_mes'].' / '.$info['validade_ano'];?></em>
                </div> 
                <div class="form-group">
                    <label>CVV:</label>
                    <input type="password" value="<?php echo $info['cvv'];?>" disabled="disabled"/>
                </div>
                <div class="form-group">
                    <label>CPF do Titular:</label>
                    <em><?php echo $info['cpf'];?></em>
                </div>
            </div>
        </div>
        <?php  endforeach;       ?>
        <a href="javascript:;" onclick="abrir_cadastrar_cartao()"><span id="end_cadatrar">Cadastrar Novo Cartão</span></a>
        <?php endif;
        ?>
</div>

<!--Modal Cadastrar Novo Endereço-->
<div id="cadastrar_cartao" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="width:150%; margin-left: -25%">
            <div class="modal-body">
                <h3>Cadastrar Novo Cartão:</h3><br/><br/>
                <div class="form-group">                 
                    <label class="col-sm-3">Numero:</label>
                    <input type="text" name="numeroCartao" id="numeroCartao" class="col-sm-4" value="" onblur="marcaCartao()"/>
                    <label class="col-sm-2">Bandeira:</label>
                    <input type="text" name="bandeira" id="titular" class="col-sm-3" placeholder="" disabled="disabled"><br/><br/>
                    <label class="col-sm-3">Titular do Cartão:</label>
                    <input type="text" name="titular" id="titular" class="col-sm-5" placeholder=""><br/><br/>  
                    <label class="col-sm-3">CPF do Titular:</label>
                    <input type="text" name="cpf" id="cpf" class="col-sm-4" placeholder=""size="12" maxlength="11" onblur="CPF()" />
                    <label class="col-sm-1">cvv:</label>
                    <input type="text" name="cvv" id="cvv" class="col-sm-2" placeholder=""><br/><br/>
                    <label class="col-sm-3">Validade do Cartão:</label>
                    <select name="mes_venc">
                        <?php for($q=1;$q<=12;$q++): ?>
                        <option><?php echo $q;?></option>
                        <?php endfor;?>
                    </select>
                    <select name="ano_venc">
                        <?php 
                        $ano = date('Y');
                        for($q=$ano;$q<=($ano+15);$q++): ?>
                        <option><?php echo $q;?></option>
                        <?php endfor;?>
                    </select><br/><br/><br/>
                    <label class="col-sm-3">Cartão de Cobrança:</label>
                    <select name="princ">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select><br/><br/><br/>
                    <div style="text-align: center;">
                        <a href="javascript:;" onclick="cadastrar_cartao(<?php echo $_SESSION['ML_login']; ?>)" class="button-logar" style="margin-right: 50px">Cadastrar</a>
                        <a href="javascript:;" onclick="fechar_cadastrar_cartao()" class="button-cancelar">Cancelar</a>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

<script type="text/javascript">
PagSeguroDirectPayment.setSessionId("<?php echo $sessioncode;?>");
</script>
</div>

<div id="modalcpf" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h2>CPF Inválido.</h2><br/><br/>
                <a href="javascript:;" onclick="fechar_cpf_invalido()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

<div id="cadastro_concluido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h3>Cadastro Concluído com Sucesso!</h3><br/><br/>
                <a href="javascript:;" onclick="fechar_cadastro3()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

<!--Modal para Excluir Endereço-->

<div id="excluir_cartao" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; margin-bottom: 50px">
                <h3><strong>Deseja Realmente Excluir este Cartão?</strong></h3><br/><br/>
                <input type="hidden" name="id" />
                <a href="javascript:;" onclick="sim_excluir_cartao()" class="button-logar">SIM</a>
                <a href="javascript:;" onclick="fechar_excluir_cartao()" class="button-nao">NÃO</a>
            </div>
        </div>
    </div>
</div>

<div id="cartao_excluido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h2>Cartão Excluído com Sucesso!</h2><br/><br/>
<!--                <a href="<?php echo BASE_URL;?>perfil/cartoes" class="button-logar">Fechar</a>-->
            </div>
        </div>
    </div>
</div>

<!--Modais Editar Cartão-->
<div id="editar_cartao" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="width:150%; margin-left: -25%">
            <div class="modal-body">
                <h3>Editar Cartão:</h3><br/><br/>
                <div class="form-group">    
                    <input type="hidden" name="idcartao" />
                    <label class="col-sm-3">Numero:</label>
                    <input type="text" name="numeroCartao" class="col-sm-4" id="numero" value="" onblur="marcaCartao()"/>
                    <label class="col-sm-2">Bandeira:</label>
                    <input type="text" name="bandeira" id="titular" class="col-sm-3" placeholder="" disabled="disabled"><br/><br/>
                    <label class="col-sm-3">Titular do Cartão:</label>
                    <input type="text" name="titular" id="titular" class="col-sm-5" placeholder=""><br/><br/>  
                    <label class="col-sm-3">CPF do Titular:</label>
                    <input type="text" name="cpf" id="cpf" class="col-sm-4" placeholder=""size="12" maxlength="11" onblur="CPF()" />
                    <label class="col-sm-1">cvv:</label>
                    <input type="password" name="cvv" id="cvv" class="col-sm-2" placeholder=""><br/><br/>
                    <label class="col-sm-3">Validade do Cartão:</label>
                    <select name="mes_venc">
                        <?php for($q=1;$q<=12;$q++): ?>
                        <option><?php echo $q;?></option>
                        <?php endfor;?>
                    </select>
                    <select name="ano_venc">
                        <?php 
                        $ano = date('Y');
                        for($q=$ano;$q<=($ano+15);$q++): ?>
                        <option><?php echo $q;?></option>
                        <?php endfor;?>
                    </select><br/><br/><br/>
                    <label class="col-sm-4">Cartão de Cobrança:</label>
                    <select name="princ">
                        <option value="0">Não</option>
                        <option value="1">Sim</option>
                    </select><br/><br/><br/>
                    <div style="text-align: center;">
                        <a href="javascript:;" onclick="editar_cartao(<?php echo $_SESSION['ML_login']; ?>)" class="button-logar" style="margin-right: 50px">Editar</a>
                        <a href="javascript:;" onclick="fechar_editar_cartao()" class="button-cancelar">Cancelar</a>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

<script type="text/javascript">
PagSeguroDirectPayment.setSessionId("<?php echo $sessioncode;?>");
</script>
</div>
<div id="editar_cartao_concluido" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h3>Cartão Editado com Sucesso!</h3><br/><br/>
                <a href="javascript:;" onclick="fechar_editar()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

<div id="campos_obrigatorios" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h2>Todos os Campos são Obrigatórios!</h2><br/><br/>
                <a href="javascript:;" onclick="fechar_campos_obrigatorios_cartao()" class="button-logar">Fechar</a>
            </div>
        </div>
    </div>
</div>

