<?php

class filtrosCategorias extends model {
    
    public function getFiltros($filtros) {
        $marcas = new marcas();
        $produtos = new produtos();
        $array = array(
            'filtros' => array(
                'busca' => '',
                'marcas' => array(),
                'valor0' => 0,
                'valor1' => 0,            
                'estrelas' => array(
                    '0' => 0,
                    '1' => 0,
                    '2' => 0,
                    '3' => 0,
                    '4' => 0,
                    '5' => 0,
                ),              
                'promocao' => 0,                
                'opcoes' => array()
                ),
            'maxprice' =>1000
        );
        
//        Termo de Busca 
        if(isset($filtros['busca'])) {
            $array['filtros']['busca'] = $filtros['busca'];
        }
        
        //metodo para selecionar as marcas no banco e a quantidade de itens cadastrados desta marca
        $marcas = new marcas();
        $array['marcas'] = $marcas->getList();
        $qtProdutoMarca = $produtos->getListaMarcas($filtros);
        //para cada marca, pegar a quantidade de produtos onde o id_marca(produtos) for igual ao id(marca)
        foreach ($array['marcas'] as $key => $marca) {
            $array['marcas'][$key]['qtde'] = '0';
            foreach ($qtProdutoMarca as $produto) {
                if($produto['id_marca'] == $marca['id']) {
                    $array['marcas'][$key]['qtde'] = $produto['qtde'];
                }
            }
        }
        
        //variavel para pegar preço mais alto de acordo com o filtro
        if(isset($filtros['filtros']['valor0'])) {
            $array['filtros']['valor0'] = $filtros['filtros']['valor0'];
        }
        if(isset($filtros['filtros']['valor1'])) {
            $array['filtros']['valor1'] = $filtros['filtros']['valor1'];
        }
        $array['maxprice'] = $produtos->getMaxPriceCat($filtros);
        if($array['filtros']['valor1'] == 0) {
            $array['filtros']['valor1'] = $array['maxprice'];
                     
        }
         
        //variavel das estrelas
        $qtdeEstrelas = $produtos->getListaEstrelasCat($filtros);
        foreach ($array['filtros']['estrelas'] as $key => $item) {
            foreach ($qtdeEstrelas as $estrelas) {
                if($estrelas['estrelas'] == $key) {
                    $array['filtros']['estrelas'][$key] = $estrelas['qtde'];                    
                }
            }
        }
        
       
        //variavel para pegar os itens em promoção
        $array['filtros']['promocao'] = $produtos->getProdutosSaleCat($filtros);
       
        //variavel das opções
        $array['filtros']['opcoes'] = $produtos->getOpcoesCat($filtros);
        
        
        return $array;
    }
}

