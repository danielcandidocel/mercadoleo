<?php $this->loadView('categorias_filtros_home', $viewData);
 
?>
<div class="col-sm-9">
      <div class="row">
          <?php 
          $a = 0; //contar quantos resultados pegou para colocar somente três na tela inicial, e depois abrir nova linha (row);
        foreach ($listaHome as $produto): 
            ?>
                <div class="col-sm-4">
                    <?php $this->loadView('produto_item_home', $produto); ?>
                </div>
                <?php 
                if($a >= 2) {
                    $a = 0;
                    echo '</div><div class="row">';
                } else {
                    $a++;
                }  
            
         endforeach;
        
        ?>         
    </div>
<div class="pag">
    <div class="pager">
        <?php
        if(isset($_GET['p']) && !empty($_GET['p'])){
            $atual = intval($_GET['p']);
        } else{
            $atual = 1;
        }
            $a = $atual - 1;
            $anterior = 'p='.$a;
            $p = $atual  + 1;
            $proxima = 'p='.$p;
        ?>  
        <button><a href="<?php echo BASE_URL;?>?<?php echo $anterior;?>">Página Anterior</a></button>
            <button><a href="<?php echo BASE_URL;?>?<?php echo $proxima;?>">Próxima Página</a></button>
        </div>
</div>
</div>
