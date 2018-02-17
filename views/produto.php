
<div class="row">
    
    <div class="col-sm-5">
        <div class="mainphoto">
            <img src="<?php echo BASE_URL; ?>media/produtos/<?php echo $produto['imagens'][0]['url']; ?>" />
        </div>
        <div class="gallery">
             <?php foreach ($produto['imagens'] as $img): ?>
            <div class="photo-item">
               <img src="<?php echo BASE_URL; ?>media/produtos/<?php echo $img['url']; ?>" />
            </div>            
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-sm-7">
        <h2><?php echo $produto['nome']; ?><br/></h2>
        <small><?php echo $produto['marca']; ?><br/></small>
        <?php if($produto['estrelas'] != '0'): ?>
            <?php for($q=0;$q<intval($produto['estrelas']);$q++): ?>
                <img src="<?php echo BASE_URL; ?>assets/images/star.png" border="0" height="18" />
            <?php endfor; ?>
        <?php endif; ?>
        <hr/>
        <p><?php echo utf8_encode($produto['descricao_peq']); ?></p>
        <hr/>
        <div class="product_price_old view1"> 
            <?php if($produto['preco_anterior'] != '0'): ?>
            <small><?php echo 'De: '; ?></small>
                <?php echo 'R$ ' . number_format($produto['preco_anterior'], 2, ',', '.');
            endif;
            ?>
        </div>
        <div class="product_price view">
           <?php  if($produto['preco_anterior'] != '0'): ?>
            <small><?php echo 'Por: '; ?>
            </small>
            <?php endif; 
             echo 'R$ ' . number_format($produto['preco'], 2, ',', '.'); ?>
            
        </div><div style="clear:both"></div>
        <br/>
       
        <form method="POST" class="addtocartform" action="<?php echo BASE_URL; ?>cart/add">
            <input type="hidden" name="id_produto" value="<?php echo $produto['id']; ?>"/>            
            <input type="hidden" name="qt_produto" value="1" />
            <input type="hidden" name="valor_produto" value="<?php echo number_format($produto['preco'], 2, ',', '.');?>"/>
            <button data-action="decrease">-</button>
            <input type="text" name="qt" value="1" class="addtocart_qt"  disabled />
            <button data-action="increase">+</button>
            <input class="addtocart_submit"type="submit" value="<?php $this->lang->get('ADDCART'); ?>" />
        </form>
    </div>        
</div>
<?php if(!empty($opcoes) || !empty($reviews[0]['comentario'])):?>
        <hr/>
        <?php         endif;?>
<div class="row">
    <div class="col-sm-6">
        <?php if(!empty($opcoes)):?>
        
        <h3><?php $this->lang->get('OPTIONS'); ?></h3>
        <?php
            foreach ($opcoes as $po): ?>        
                <strong><?php echo $po['nome']; ?></strong>: <br><?php 
                 foreach ($po['opcao'] as $op):

                echo $op; ?><br>
                <?php endforeach;?> 
            <?php endforeach;
        endif; ?>
    </div>
    <div class="col-sm-6 reviews">
        <?php if(!empty($reviews[0]['comentario'])): ?>
        <h3><?php $this->lang->get('REVIEWS'); ?>:</h3>
        <?php
            foreach ($reviews as $res): ?>
                <strong><?php echo $res['cliente']; ?> </strong>
                    <?php for ($q=0;$q<intval($res['pontos']);$q++): ?>
                        <img src="<?php echo BASE_URL; ?>assets/images/star.png" border="0" height="18" />
                    <?php endfor; ?> <br><br>
                <?php echo $res['comentario']; ?><br><hr/>
            <?php         endforeach; 
        endif;?><br>
    </div>
</div>
<div class="row">
    <hr/><p> <img src="<?php echo BASE_URL; ?>media/products/img_descripition/<?php echo $descripition[0]['url']; ?>" width="100%" /></p>
</div>