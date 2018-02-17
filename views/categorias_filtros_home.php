
<div class="categoryarea" id="red_cat">
    <nav class="navbar">
        <div class="container">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php $this->lang->get('SELECTCATEGORY'); ?>
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo BASE_URL; ?>">Todas as Categorias</a></li>
                  <?php foreach($categorias as $categoria): ?>
                    <li>
                        <a href="<?php echo BASE_URL.'categorias/enter/'.$categoria['id']; ?>">
                            <?php echo $categoria['nome']; ?>
                        </a>
                    </li>
                    <?php
                    //verificar se existe sub e criar um view para colocar estas subcategorias
                        if(count($categoria['subs']) > 0){
                            $this->loadView('menu_subcategoria', array('subs' => $categoria['subs'], 'level' => 1));
                        }
                    ?><li class="divider"></li>
                  <?php endforeach; ?>
                </ul>
              </li>
              <?php if (isset($filtros_categorias)): ?>
                <?php foreach ($filtros_categorias as $lista_categorias): ?>
                <li><a href="<?php echo BASE_URL.'categorias/enter/'.$lista_categorias['id']; ?>">                                 <?php echo $lista_categorias['nome']; ?>
                    </a></li>
                <?php endforeach; ?> <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>

<!--Filtros-->
<div class="col-sm-3">
<aside>
<h1><?php $this->lang->get('FILTER'); ?></h1>				  		
<div class="filterarea">
<form method="GET" onsubmit="window.location.href='#red_cat'">
<input type="hidden" name="s" value="<?php 

echo (!empty($termoBusca))?$termoBusca:''; 

?>" />
<!--<input type="hidden" name="categoria" value="<?php echo $viewData['category']; ?>" />-->

<!--Filtro de Marcas-->    
<div class="filterbox">
    <div class="filtertitle"><?php $this->lang->get('BRANDS'); ?></div>
    <div class="filtercontent">
        <?php foreach ($filtros['marcas'] as $marcas): 
            if($marcas['qtde'] > 0):
            ?>
            <div class="filteritem">
                <input type="checkbox" 
                    <?php 
                    echo (isset($filtros_selecionados['marca']) && in_array($marcas['id'], $filtros_selecionados['marca']))?'checked="checked"':'';
                    ?> 
                       name="filtro[marca][]" value="<?php echo $marcas['id'] ?>" id="filtro_marca<?php echo $marcas['id'] ?>" /> 
                <label for="filtro_marca<?php echo $marcas['id'] ?>"><?php echo $marcas['nome']; ?></label>                        <span style="float:right">(<?php echo $marcas['qtde']; ?>)</span>
            </div>
        <?php endif;
        endforeach;?>
    </div>
</div>

<!-- jQueryUI - para colocar a barra de definição dos preços -->
<div class="filterbox">
    <div class="filtertitle"><?php $this->lang->get('PRICE'); ?></div>
    <div class="filtercontent">
        <input type="hidden" name="filtro[valor0]" id="valor0" value="<?php echo $filtros['valor0']; ?>" />
        <input type="hidden" name="filtro[valor1]" id="valor1" value="<?php echo $filtros['valor1']; ?>" />
        <input type="text" id="amount" readonly>
        <div id="slider-range"></div>
    </div>
</div>

<!--Filtro de Estrelas-->
<div class="filterbox">
    <div class="filtertitle"><?php $this->lang->get('RATING'); ?></div>
    <div class="filtercontent">
    <div class="filteritem">
        <input type="checkbox" 
               <?php 
                    echo (isset($filtros_selecionados['star']) && in_array('0', $filtros_selecionados['star']))?'checked="checked"':'';
                    ?> 
               name="filtro[star][]" value="0" id="filtro_star0" 
            <?php 
                    if(empty($filtros['estrelas'][0])) {
                        echo 'disabled=""';
                    }
                ?>
               /> 
        <label for="filtro_star0">
            <?php $this->lang->get('NOSTAR'); ?>
        </label>
        <span style="float:right">(<?php  
                if(!empty($filtros['estrelas'][0])) {
                  echo  $filtros['estrelas'][0];
                } else {echo '0';} 
            ?>)</span>
    </div>
    <div class="filteritem">
        <input type="checkbox" <?php 
                    echo (isset($filtros_selecionados['star']) && in_array('1', $filtros_selecionados['star']))?'checked="checked"':'';
                    ?> name="filtro[star][]" value="1" id="filtro_star1"
               <?php 
                    if(empty($filtros['estrelas'][1])) {
                        echo 'disabled=""';
                    }
                ?>
               /> 
        <label for="filtro_star1">
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
        </label>
        <span style="float:right">(<?php  
                if(!empty($filtros['estrelas'][1])) {
                  echo  $filtros['estrelas'][1];
                } else {echo '0';} 
            ?>)</span>
    </div>
    <div class="filteritem">
        <input type="checkbox" 
               <?php 
                    echo (isset($filtros_selecionados['star']) && in_array('2', $filtros_selecionados['star']))?'checked="checked"':'';
                    ?>
               name="filtro[star][]" value="2" id="filtro_star2" 
               <?php 
                    if(empty($filtros['estrelas'][2])) {
                        echo 'disabled=""';
                    }
                ?>
               /> 
        <label for="filtro_star2">
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
        </label>
       <span style="float:right">(<?php  
                if(!empty($filtros['estrelas'][2])) {
                  echo  $filtros['estrelas'][2];
                } else {echo '0';} 
            ?>)</span>
    </div>
    <div class="filteritem">
        <input type="checkbox" 
               <?php 
                    echo (isset($filtros_selecionados['star']) && in_array('3', $filtros_selecionados['star']))?'checked="checked"':'';
                    ?>
               name="filtro[star][]" value="3" id="filtro_star3" 
               <?php 
                    if(empty($filtros['estrelas'][3])) {
                        echo 'disabled=""';
                    }
                ?>
               /> 
        <label for="filtro_star3">
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
        </label>
        <span style="float:right">(<?php  
                if(!empty($filtros['estrelas'][3])) {
                  echo  $filtros['estrelas'][3];
                } else {echo '0';} 
            ?>)</span>
    </div>
    <div class="filteritem">
        <input type="checkbox" 
               <?php 
                    echo (isset($filtros_selecionados['star']) && in_array('4', $filtros_selecionados['star']))?'checked="checked"':'';
                    ?>
               name="filtro[star][]" value="4" id="filtro_star4"
               <?php 
                    if(empty($filtros['estrelas'][4])) {
                        echo 'disabled=""';
                    }
                ?>
               /> 
        <label for="filtro_star4">
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
        </label>
        <span style="float:right">(<?php  
                if(!empty($filtros['estrelas'][4])) {
                  echo  $filtros['estrelas'][4];
                } else {echo '0';} 
            ?>)</span>
    </div>
    <div class="filteritem">
        <input type="checkbox" 
               <?php 
                    echo (isset($filtros_selecionados['star']) && in_array('5', $filtros_selecionados['star']))?'checked="checked"':'';
                    ?>
               name="filtro[star][]" value="5" id="filtro_star5" 
               <?php 
                    if(empty($filtros['estrelas'][5])) {
                        echo 'disabled=""';
                    }
                ?>
               /> 
        <label for="filtro_star5">
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" height="18" borde="0" />
        </label>        
        <span style="float:right">(<?php  
                if(!empty($filtros['estrelas'][5])) {
                  echo  $filtros['estrelas'][5];
                } else {echo '0';} 
            ?>)</span>
    </div>
</div>
</div>

<!--Filtro de Promoção-->
<div class="filterbox">
    <div class="filtertitle"><?php $this->lang->get('SALE'); ?></div>
    <div class="filtercontent">
        <div class="filteritem">
            <input type="checkbox" 
                   <?php 
                    echo (isset($filtros_selecionados['promocao']) && $filtros_selecionados['promocao'] == 1)?'checked="checked"':'';
                    ?> 
                   value= "1" name="filtro[promocao]" id="filtro_promocao" 
                   <?php 
            if(empty($filtros['promocao']['qtde'])) { echo 'disabled=""';}
        ?> 
                   /> 
            <label for="filtro_promocao"><?php $this->lang->get('SALE'); ?> </label>
            <span style='float:right'>(<?php echo (!empty($filtros['promocao']['qtde']))? $filtros['promocao']['qtde']:'0'; ?>)</span>
        </div>
    </div>
</div>

<!--Filtro de Opções -->

<div class="filterbox">
    <div class="filtertitle"><?php $this->lang->get('OPTIONS'); ?></div>
    <div class="filtercontent">  
    <?php 
    if(!empty($filtros['opcoes'])):
        foreach($filtros['opcoes'] as $opcoes):
        
            ?>
        <strong><?php echo $opcoes['nome'];?></strong>  
        <?php foreach($opcoes['opcao'] as $op):?>
            <div class="filteritem">     
                <input type="checkbox" 
                       <?php 
                    echo (isset($filtros_selecionados['opcoes']) && in_array($op['valor'], $filtros_selecionados['opcoes']))?'checked="checked"':'';
                    ?> name="filtro[opcoes][]" value="<?php echo $op['valor'] ?>" id="filtro_opcoes<?php echo $op['valor']; ?>"/> 
                <label for="filtro_opcoes<?php echo $op['valor'] ?>"><?php echo $op['valor']; ?></label>                            <span style="float:right">(<?php echo $op['qtde']; ?>)</span>
                <br/>
            </div>
        <?php endforeach;?>
        <br/>        
    <?php     
    endforeach;
    endif;?>
    </div>
</div>

</form>
</div>

<!--Produtos em Destaque-->
<div class="widget">
    <h1><?php $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
    <div class="widget_body">
            <?php $this->loadView('widget_item', array('list'=>$viewData['widget_destaque2'])); ?>
    </div>
</div>
<!--Fim-->   
</aside>
</div>
