
<form method="POST">
    
<div class="container finalizar" style="padding-bottom: 30px;padding-top: 30px">
<h1 style="text-align: center"><b>Finalizar Compra - Paypal</b></h1><br/>


    <div class="col-md-11 user">

        <h4><b>Dados Pessoais</b></h4>

        <div class="col-md-12 endereco" style="padding-bottom: 10px;padding-top: 10px">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="hidden" id="nome" name="nome" value="<?php echo $dados['nome'];?>" />
                    <input id="nome" name="nome1" value="<?php echo $dados['nome'];?>" disabled="disabled"/>
                </div>  
                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="hidden" id="email" name="email" value="<?php echo $dados['email'];?>"/>
                    <input id="email" name="email1" value="<?php echo $dados['email'];?>" disabled="disabled"/>
                </div>   
                <div class="col-md-10">
                    <a href="<?php echo BASE_URL?>perfil/meus_dados?tipo=paypal"><span id="sair">Editar Dados</span></a>
                </div>
            </div>

            <div class="col-md-6">
                <?php if($dados['cpf'] > 0):?>            
                <div class="form-group">        
                    <label>CPF:</label>
                    <input type="hidden "id="cpf" name="doc" value="<?php echo $dados['cpf'];?>" />
                    <input id="cpf" name="doc1" value="<?php echo $dados['cpf'];?>" disabled="disabled"/>
                    </div>
                    <?php else: ?>
                <div class="form-group">
                    <label>CNPJ:</label>
                    <input type="hidden" id="cnpj" name="doc" value="<?php echo $dados['cnpj'];?>" >
                    <input id="cnpj" name="doc1" value="<?php echo $dados['cnpj'];?>" disabled="disabled"/>
                </div>
            <?php endif; ?>
                <div class="form-group">
                    <label>Celular:</label>
                    <input type="hidden" id="cel" name="cel" value="<?php echo $dados['cel'];?>" />
                    <input id="cel" name="cel1" value="<?php echo $dados['cel'];?>" disabled="disabled"/>
                </div>
            </div>

        </div>

            <h4><b>Endereço de Entrega</b></h4>

        <div class="col-md-12 endereco" style="padding-bottom: 10px; padding-top: 10px">

        <?php if(!isset($dados['endereco'])): ?>
            <h5><b style="background:#000; color:#FFFF99">Não Há Endereço de Entrega Cadastrado</b></h5>
            <a href="<?php echo BASE_URL?>perfil/enderecos?tipo=paypal"><span id="sair">Editar Endereco de Entrega</span></a>
        <?php else: ?>

            <div class="col-md-5">
                <div class="form-group">
                    <label>Rua:</label>
                    <input type="hidden" id="id_endereco" name="id_endereco" value="<?php echo $dados['endereco']['id'];?>" />
                    <input type="hidden" id="rua" name="rua" value="<?php echo $dados['endereco']['rua'];?>" />
                    <input id="rua" name="rua1" value="<?php echo $dados['endereco']['rua'];?>" disabled="disabled"/>
                </div>  
                <div class="form-group">
                    <label>Complemento:</label>
                    <input type="hidden" id="complemento" name="complemento" value="<?php echo $dados['endereco']['complemento'];?>" />
                    <input id="complemento" name="complemento1" value="<?php echo $dados['endereco']['complemento'];?>" disabled="disabled"/>
                </div>     
                <div class="form-group">
                    <label>Bairro:</label>
                    <input type="hidden" id="bairro" name="bairro" value="<?php echo $dados['endereco']['bairro'];?>" />
                    <input id="bairro" name="bairro1" value="<?php echo $dados['endereco']['bairro'];?>" disabled="disabled"/>
                </div>   
                <div class="col-md-10">
                    <a href="<?php echo BASE_URL?>perfil/enderecos?tipo=paypal"><span id="sair">Editar Endereço de Entrega</span></a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Número:</label>
                    <input type="hidden" id="numero" name="numero" value="<?php echo $dados['endereco']['numero'];?>" />
                    <input id="numero" name="numero1" value="<?php echo $dados['endereco']['numero'];?>" disabled="disabled"/>
                </div>  
                <div class="form-group">
                    <label>CEP:</label>
                    <input type="hidden" id="cep" name="cep" value="<?php echo $dados['endereco']['cep'];?>" />
                    <input id="cep" name="cep1" value="<?php echo $dados['endereco']['cep'];?>" disabled="disabled"/>
                </div> 
                <div class="col-md-12" style="padding: 0">
                    <div class="col-md-8" style="padding: 0">
                        <div class="form-group">
                            <label>Cidade:</label>
                            <input type="hidden" id="cidade" name="cidade" value="<?php echo $dados['endereco']['cidade'];?>" />
                            <input id="cidade" name="cidade1" value="<?php echo $dados['endereco']['cidade'];?>" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="col-md-4" style="padding: 0">
                        <div class="form-group">
                            <label>Estado:</label>
                            <input type="hidden" id="estado" name="estado" value="<?php echo $dados['endereco']['estado'];?>" />
                            <input id="estado" name="estado1" value="<?php echo $dados['endereco']['estado'];?>" disabled="disabled"/>
                        </div>
                    </div>
                </div>                
            </div>
            <?php  endif; ?>
        </div>
            
        <h4><b>Dados da Compra</b></h4>
        <table class='table-carrinho'>
    <tr>
        <th width="100"></th>
        <th></th>
        <th width="100">Qtd.</th>
        <th>Preço</th>
        <th>Sub-total</th>
    </tr>
        <?php foreach($lista as $produto): ?>
            
            <tr>
            <td>
                <img src="<?php echo BASE_URL; ?>media/produtos/<?php echo $produto['imagem']; ?>" width="80" />
            </td>
            <td><?php echo $produto['nome']; ?></td>
            <input type="hidden" id="nomeProduto" value="<?php echo $produto['nome']?>"/>
            <td><?php echo $produto['qt']; ?></td>
            <input type="hidden" id="qtProduto" value="<?php echo $produto['qt']?>"/>
            <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
            <input type="hidden" id="precoProduto" value="<?php echo number_format($produto['preco'], 2, ',', '.'); ?>"/>
            <?php $sub = $produto['qt']*$produto['preco']; ?>
            <td>R$ <?php echo number_format($sub, 2, ',', '.'); ?></td>
            
            
    </tr>
    <?php endforeach; ?>
        <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Frete:</td>
        <td>R$ <?php echo $_SESSION['totalFrete'];?></td>
        <input type="hidden" id="frete" value="<?php echo $_SESSION['totalFrete'];?>"/>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td style="height: 70px"><strong>Total:</strong></td>
        <td><strong>R$ <?php echo $_SESSION['totalCompra'];?></strong></td>
    <input type="hidden" id="totalCompra" name="totalCompra" value="<?php echo $_SESSION['totalCompra'];?>"/>
    </tr>
        </table>

<!--        <h4><b>Forma de Pagamento</b></h4>
        <strong>Parcelas:</strong><br/>
        <strong name="bandeira"></strong><br/>
        <select name="parcelas"></select>-->
    </div>
</div>
    
<div class="col-md-4">
    <a href='<?php echo BASE_URL;?>cart'><strong>Trocar Forma de Pagamento</strong></a>
</div>
    
<div class="col-md-12" style="text-align: center; padding-bottom: 50px">
    <input type="submit" class="button-carrinho finalizarCompra" value="<?php if(!isset($dados['endereco'])){ echo 'Preencha todos os Dados" disabled="disabled" style="background:#000; color:#FFFF99'; } else { echo 'Efetuar Compra';} ?>" />
</div>
</form>

