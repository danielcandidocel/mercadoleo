
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
    <h3 style="text-align: center" id="noprint"><b>Meus Pedidos</b></h3><br/>
  <?php if(empty($dados)): ?>
        <h5 style="text-align: center"><b>Não Há Pedidos Cadastrados</b></h5>
        
    <?php else: ?>
<div class="table-responsive">
    <table class='table-pedido table table-hover' id="noprint">
    <thead>
        <tr style="text-align: center">
            <th>Pedido</th>
            <th>Data</th>
            <th wi>Valor</th>
            <th>Forma de Pagamento</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php    foreach ($dados as $info): ?>
        <tr>
            <td><a href="javascript:" onclick="pedidos(<?php echo $info['id'];?>)"><?php echo $info['pedido'];?></a></td>
            <td><a href="javascript:" onclick="pedidos(<?php echo $info['id'];?>)"><?php $date = $info['data'];
                        echo date('d/m/Y - H:i', strtotime($date));?></a></td>
            <td><a href="javascript:" onclick="pedidos(<?php echo $info['id'];?>)"><?php echo 'R$ '.number_format($info['valor'], 2, ',','.');?></a></td>
            <td><a href="javascript:" onclick="pedidos(<?php echo $info['id'];?>)"><?php echo $info['forma_de_pagamento'];?></a></td>
            <td><a href="javascript:" onclick="pedidos(<?php echo $info['id'];?>)"><?php 
            switch ($info['status']){
                case '1':
                    echo 'Aguardando Pagamento';
                    break;
                case '2':
                    echo 'Em Análise';
                    break;
                case '3':
                    echo 'Pagamento Aprovado';
                    break;
            };?></a></td>
            
        </tr>
     <?php  endforeach; ?>
    </tbody>
    </table>
</div>
     
        <?php endif;   ?>
</div>

<!--Modal Detalhes do Pedido-->
<div id="pedidos" class=" modal fade" role="dialog">
    <style type="text/css" media="print">
        #danfe {display:none;}
        .menu-account{display:none;}
        footer{display:none;}
        .modal-dialog{width: 80%; margin-left: 10%;}
        .modal-body{width: 80%; margin-left: 10%;}
        .modal-content{margin-left: 0}
        #noprint{display: none}
    </style>
    <div class="modal-dialog">
        <div class="modal-content" style="width:150%; margin-left: -25%">
            <div class="modal-body">
                <h3 style="float: right" id="noprint"><span class="glyphicon glyphicon-remove-sign" onclick="fechar_pedido()"></span></h3>
                <h3><strong>Detalhes do Pedido:</strong> <input type="text" name="pedido" disabled="disabled"/></h3>
                <br/><br/>
               
                    <table class='table table-pedido '>
                        <thead>
                        <tr style="text-align: center">
                            <th id="thleft">Pedido</th>
                            <th id="thleft">Data</th>
                            <th id="thleft">Valor</th>
                            <th id="thleft">Status</th>
                        </tr>
                    </thead>
                    <tbody>                    
                        <tr>
                            <td><input type="text" name="pedido" disabled="disabled"/></td>
                            <td><input type="text" name="data" disabled="disabled"/></td>
                            <td><input type="text" name="valor" disabled="disabled"/></td>
                            <td><input type="text" name="status" disabled="disabled"/></td>
                        </tr>
                    </tbody>
                    </table><br/><hr>
                    <div class="titulo-status col-sm-12">
                        <div style="width: 20%; float: left; text-align: left">Pedido Recebido</div>
                        <div style="width: 20%; float: left; text-align: center">Pagamento Confirmado</div>
                        <div style="width: 20%; float: left; text-align: center">Em Separação</div>
                        <div style="width: 20%; float: left; text-align: center">Postado</div>
                        <div style="width: 20%; float: left; text-align: center">Entregue</div>
                    </div>
                    <div class="timeline">
                        <div class="bar col-sm-11">
                          
                            <div style="width: 26%; height:100%; float: left;">
                                <div id="icone"><h4><span class="glyphicon glyphicon-ok-sign"></span></h4></div> 
                                <div id="barc"></div>
                            </div>
                            <div style="width: 22%; height:100%; float: left;">
                                <div id="icone1"><h4><span class="glyphicon glyphicon-ok-sign"></span></h4></div>
                                <div id="barc1"></div>
                            </div>
                            <div style="width: 22%; height:100%; float: left;">
                                <div id="icone2"><h4><span class="glyphicon glyphicon-ok-sign"></span></h4></div>
                                <div id="barc2"></div>
                            </div>
                            <div style="width: 22%; height:100%; float: left;">
                                <div id="icone3"><h4><span class="glyphicon glyphicon-ok-sign"></span></h4></div>
                                <div id="barc3"></div>
                            </div>
                            <div style="width: 8%; height:100%; float: left;">
                                <div id="icone4"><h4><span class="glyphicon glyphicon-ok-sign"></span></h4></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="data-status col-sm-12">
                        <div style="width: 20%; float: left; text-align: left">
                            <input type="text" name="data" disabled="disabled"/>
                        </div>
                        <div id="data-pgto" style="width: 20%; float: left; text-align: center">
                            
                        </div>
                        <div id="data-separacao" style="width: 20%; float: left; text-align: center">
                            
                        </div>
                        <div id="data-postado" style="width: 20%; float: left; text-align: center">
                            
                        </div>
                        <div id="data-entregue" style="width: 20%; float: left; text-align: center">
                            
                        </div>
                    </div><br/>
                   <div id="rastreador"></div><hr/>
                   <p><strong>Resumo da Compra:</strong></p>
                   <table class='table table-pedido '>
                        <thead>
                        <tr>                            
                            <th>Imagem</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                        </tr>
                    </thead>
                    <tbody id="produto">                    
                        
                    </tbody>
                    </table>
                   
                   <table class='table table-pedido '>
                        <thead>
                        <tr style="text-align: center">
                            <th colspan="6" id="thleft">Endereço de Entrega:</th>
                            
                        </tr>
                    </thead>
                    <tbody>                    
                        <tr>
                            <td class="col-md-1" id="thleft"><strong>Rua:</strong></td>
                            <td colspan="3" ><input type="text" name="rua" class="col-sm-12" disabled="disabled"/></td>
                            <td class="col-md-1" id="thleft"><strong>Nº:</strong></td>
                            <td><input type="text" name="numero" class="col-sm-4" disabled="disabled"/></td>
                           
                        </tr>
                        <tr>
                           <td class="col-md-1" id="thleft"><strong>Bairro:</strong></td>
                           <td colspan="2"><input type="text" name="bairro" class="col-sm-12" disabled="disabled"/></td>
                            <td class="col-md-1" id="thleft"><strong>Complemento:</strong></td>
                            <td colspan="2"><input type="text" name="complemento" class="col-sm-4" disabled="disabled"/></td>
                            
                           
                        </tr>
                        <tr>
                           <td class="col-md-1" id="thleft"><strong>Cidade:</strong></td>
                            <td><input type="text" name="cidade" class="col-sm-12" disabled="disabled"/></td>
                            <td class="col-md-1" id="thleft"><strong>Estado:</strong></td>
                            <td><input type="text" name="estado" class="col-sm-8" disabled="disabled"/></td>
                            <td class="col-md-1" id="thleft"><strong>CEP:</strong></td>
                            <td><input type="text" name="cep" class="col-sm-8" disabled="disabled"/></td>
                        </tr>
                    </tbody>
                    </table>
                    <div class="col-sm-12">
                        <h5><strong>Forma de Pagamento: </strong><input type="text" name="forma_de_pagamento" disabled="disabled"/></h5>
                        <div id="forma-pgto" id="noprint">
                            
                        </div><br/><br/>
                    </div><br/><br/>
                    <a href="" id="danfe">Emitir DANFE</a><br/><br/>
                    <div style="text-align:center">
                        <a href="javascript:self.print()" class="button-logar" id="noprint">Imprimir Pedido</a>
                    </div>
            </div>
        </div>
    </div>
</div>
