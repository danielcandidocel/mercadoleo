<div class="produto_item">
    <a href="<?php echo BASE_URL."produto/abrir/".$slug;?>">
    <div class="tags_produto">
        <?php if($mais_vendidos == '1'): ?>
        <div class="tag_produto tag_produto_green"><?php $this->lang->get('BESTSELLER'); ?></div>
        <?php endif;
        if($promocao == '1'): ?>
        <div class="tag_produto tag_produto_red"><?php $this->lang->get('SALE'); ?></div>
        <?php endif;
        if($novo == '1'): ?>
        <div class="tag_produto tag_produto_blue"><?php $this->lang->get('NEW'); ?></div>
        <?php endif; ?>
    </div>
    <div class="imagem_produto">
        <img src="<?php echo BASE_URL; ?>/media/produtos/<?php echo $imagens[0]['url'];?>" />
    </div>
      
    <div class="nome_produto"><?php echo $nome; ?></div>
    <div class="marca_produto"><?php echo $marca; ?></div>
    <div class="preco_antigo"><?php 
        if($preco_anterior != '0') {
            echo 'DE: R$'.number_format($preco_anterior, 2, ',','.');
        }
     ?></div>
    <div class="preco_atual"><?php echo 'POR: R$'.number_format($preco, 2, ',','.'); ?></div>
    </a>
</div>
