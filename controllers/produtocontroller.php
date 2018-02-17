<?php
class produtocontroller extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {    
        header("Location: ".BASE_URL);
    }
    
    public function abrir($slug){
        $produtos = new produtos();
        $categorias = new categorias();
        $f = new filtros();     
        
        $widget = new widget();        
        $dados = $widget->dadosTemplate();      
            
        $filtros = array();
        
        $prod = $produtos->abrirProduto($slug);
        
        if(count($prod) > 0) {

            //            Filtros
            $dados['filtros'] = $f->getFiltros($filtros);
            $dados['filtros_selecionados'] = $filtros; //filtros selecionados pelo formulario GET

            //        Pegando os dados do Produto
            $dados['produto'] = $prod;
            $dados['opcoes'] = $produtos->getOpcoesProduto($slug);
            $dados['reviews'] = $produtos->getReviews($slug, 5);


            $dados['categorias'] = $categorias->getList();//pega a lista das categorias e subcategorias

            $this->loadTemplate('produto', $dados);
        } else {
            header("Location: ".BASE_URL);
        }
    }

}