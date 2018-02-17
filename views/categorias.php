<?php $this->loadView('categorias_filtros_categoria', $viewData); ?>

<div class="col-sm-9">
   
      <div class="row">
          <?php 
          $a = 0; //contar quantos resultados pegou para colocar somente três na tela inicial, e depois abrir nova linha (row);
        foreach ($listaHome as $produto): 
            if (!empty($produto['produto'])):
                foreach ($produto['produto'] as $produto_item): ?>
                    <div class="col-sm-4">
                    <?php $this->loadView('produto_item', $produto_item); ?>
                    </div>
                    <?php 
                    if($a >= 2) {
                        $a = 0;
                        echo '</div><div class="row">';
                    } else {
                        $a++;
                    }  
                endforeach;
            endif;
         endforeach;
        
        ?>         
    </div>
<div class="pag">
    <?php for($q=1;$q<=$numeroPaginas;$q++): ?>
     <div class="paginacao <?php echo ($paginaAtual==$q)?'page_active':''; ?>"><a href="<?php echo BASE_URL;?>?<?php 
        $pag_array = $_GET;
        $pag_array['p'] = $q;
        echo http_build_query($pag_array);?>"><?php echo $q; ?></a>
    </div>
    <?php endfor;?>
</div>
</div>
