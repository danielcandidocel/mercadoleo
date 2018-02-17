<h3 style="text-align: center"><strong>Carrinho de Compras</strong></h3><br/><br/>
<table class='table-carrinho'>
    <tr>
        <th width="100">Imagem</th>
        <th>Nome</th>
        <th width="100">Qtd.</th>
        <th width="150">Preço</th>
        <th width="20"></th>
    </tr>
    <?php
    $subtotal = 0;
    ?>
    <?php foreach($lista as $produto): ?>
    <?php
    $subtotal += (floatval($produto['preco']) * intval($produto['qt']));
    ?>
    <tr>
        <td> <a href="<?php echo BASE_URL."produto/abrir/".$produto['slug'];?>"><img src="<?php echo BASE_URL; ?>media/produtos/<?php echo $produto['imagem']; ?>" width="80" /></a></td>
            <td><a href="<?php echo BASE_URL."produto/abrir/".$produto['slug'];?>"><?php echo $produto['nome']; ?></a></td>
            <td><?php echo $produto['qt']; ?></td>
            <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
            <td><a href="<?php echo BASE_URL;?>cart/del/<?PHP echo $produto['id'];?>"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
    <?php endforeach; ?>
    <tr style="height: 50px">    
        <td></td>
        <td></td>
        <td>Sub-total: </td>
        <td class="subtottal"><strong> <?php echo ' R$ '. number_format($subtotal, 2, ',', '.'); ?></strong>
            <input type="text" name="sub" id="sub" value="<?php echo $subtotal; ?>" hidden="" /><br/>
        </td>
    </tr>
    <?php if(!empty($_SESSION['frete'])):?>
     <tr style="height: 50px">    
        <td></td>
        <td></td>       
        <td>CEP: </td>
        <td class="subtottal"><strong>  <?php echo $cep; ?></strong>
            <br/>
        </td>
         <td>                
                <?php if(!empty($_SESSION['frete'])):  ?>
                    <a href="<?php echo BASE_URL;?>cart/freteDel/" alt="Recalcular Frete"><span class="glyphicon glyphicon-remove"></span></a>
                <?php endif;?>
            </td>  
    </tr>
        <?php endif; $payment = 0;?>
    <?php if(!empty($_SESSION['frete'])):?>

        <?php $n = 1; foreach ($frete as $correio):  
            
            ?>
        <tr style="height: 50px">    
            <td></td>
            <td></td>
            <td><?php 
            if ($correio['codigo'] == '41106'): ?>
                <label for="correio[<?php echo $n;?>]" style="margin-right: 10px;">
                    <img src="<?php echo BASE_URL.'/assets/images/pac.png'; ?>" alt="" for="cartao"/>
                </label>
            <?php elseif ($correio['codigo'] == '40010'): ?>
                <label for="correio[<?php echo $n;?>]" style="margin-right: 10px;">
                    <img src="<?php echo BASE_URL.'/assets/images/sedex.png'; ?>" alt="" for="cartao"/>  
                </label>
            <?php elseif ($correio['codigo'] == '40215'): ?>
                <label for="correio[<?php echo $n;?>]" style="margin-right: 10px;">
                    <img src="<?php echo BASE_URL.'/assets/images/sedex10.png'; ?>" alt="" for="cartao"/> 
                </label>
            <?php $n++; endif; ?>
             </td>
            <td><?php  
                if($correio['erro'] == 0):  $payment = 1;?>
                 <label>
                     <input type="radio" name="correio" id="correio[<?php echo $n;?>]" value="<?php echo $correio['preco'].' '.$correio['prazo']; ?>">       
                     <strong><?php echo $correio['preco']; ?></strong> <strong id="prazo">(<?php echo $correio['prazo']+1;?> dia<?php echo($correio['prazo'] == 1)?'':'s';?>)</strong></label>
                <?php  else: 
                    if($correio['erro'] == '008'):
                       
                    ?>
                    <strong style="color:blue; font-size: 14px">Opção Inexistente</strong>
                    <?php  else: ?>
                       <strong style="color:red; font-size: 14px">CEP Incorreto</strong>
                <?php endif;?>
            <?php endif;?>
            </td>
        <?php  
        $n = $n + 1;
        endforeach; ?>
                
        </tr>
    <?php    
    else: ?>
    <tr style="height: 50px">    
        <td></td>
        <td></td>
        <td>Digite o CEP: </td>
        <td><br/>
            <form method="POST">
                <input type="number" name="cep" maxlength="8" /><br/>
                <input type="submit" value="Calcular" style="margin-top: 15px; margin-bottom: 10px;"/>
            </form>                     
        </td>      
    </tr>
    <?php endif;?>
    <tr style="height: 50px">    
        <td></td>
        <td></td>
        <td>Total: </td>
        <td>
            <strong id="total"> </strong>
          
            <form method="POST" name="total">
                <input type="hidden" name="teste" id="teste" value=""/>
        <input  type="hidden" name="totalFrete" id="totalFrete" value=""/>
        <input  type="hidden" name="prazo" id="prazo" value=""/>
        <input  type="hidden" name="totalCompra" id="totalCompra" value=""/>
        </form>
        </td>
    </tr>
    
    
     <tr style="height: 50px">    
         <td colspan="2" class="continuar"><a href='<?php echo BASE_URL;?>home/comprar'><strong>Continuar Comprando</strong></a></td>

       
         <td colspan="2"> <strong>Forma de Pagamento:</strong></td>
        <td></td>
         <td></td>
    </tr>
     <tr style="height: 50px">    
        <td></td>
        
       
        <td colspan="3" align="right"> 
        <div class="formapg">            
            <input type="radio" name="formapg" id="formapg" value="1" checked="checked">
            <label for="formapg" class="label3" style="margin-right: 10px;">
                <!--<strong> Cartão de Crédito </strong>-->
                <img src="<?php echo BASE_URL.'/assets/images/cartoes.png'; ?>" alt="" for="cartao"/>
            </label>            
            <input type="radio" name="formapg" id="formapg2" value="2">
            <label for="formapg2" class="label2" style="margin-right: 10px;">
                <!--<strong> Boleto </strong>-->
                <img src="<?php echo BASE_URL.'/assets/images/boleto.png'; ?>" alt="" for="boleto"/>
            </label>            
            <input type="radio" name="formapg" id="formapg1" value="3">
            <label for="formapg1"  class="label1" style="margin-right: 10px;">
                <!--<strong for="formapg"> Paypal</strong>-->
                <img src="<?php echo BASE_URL.'/assets/images/paypal.png'; ?>" alt=""/>
            </label>
        </div>
        </td>
        <td></td>
         <td></td>
    </tr>
    <input  type="hidden" name="pg" id="pg" value=""/>
</table>
<hr/>

<div class="finalizar_compra col-md-11">
    <form method="POST" name="finalizarCompra" style="float: right" class="form-carrinho" action="<?php echo BASE_URL;?>/cart/meiosPagamento/cartao">
<!--        <select name="tipo_pagamento">
            <option value="cartao">PagSeguro Checkout Transparente</option>
            <option value="paypal">Paypal</option>
        </select>-->
        
        <input  type="hidden" name="totalFrete" id="totalFrete" value=""/>
        <input  type="hidden" name="totalCompra" id="totalCompra" value=""/>
        <input  type="hidden" name="prazo" id="prazo" value=""/>
        <button type="button" onClick="finalizar()" class="button-carrinho">Finalizar Compra</button>
    </form>
</div>

