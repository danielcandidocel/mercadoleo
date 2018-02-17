<?php foreach($list as $widget_item): ?>

<div class="widget_item">
    <a href="<?php echo BASE_URL; ?>produto/abrir/<?php echo $widget_item['slug'];?>">
        <div class="widget_photo">
            <img src="<?php echo BASE_URL; ?>media/produtos/<?php echo $widget_item['imagens'][0]['url']; ?>" />
        </div>
        <div class="widget_info">
            <div class="widget_productname"><?php echo $widget_item['nome']; ?></div>
            <div class="widget_price_old"><span><?php 
            if($widget_item['preco_anterior'] != '0'){
                echo 'De: R$ '.number_format($widget_item['preco_anterior'], 2, ',', '.'); 
            }
            ?></span> </div>
            <div class="widget_price"> <?php 
            if($widget_item['preco_anterior'] != '0'){
            echo 'Por: ';
            }
            echo 'R$ ' .number_format($widget_item['preco'], 2, ',', '.'); ?></div>
        </div>
        
        <div style="clear: both;"></div>
    </a>    
</div>
<?php endforeach; 