<?php
class buscacontroller extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
                
        $produtos = new produtos();
        $categorias = new categorias();
        $f = new filtros();     
        
        $widget = new widget();
        
        $dados = $widget->dadosTemplate();
        
        if(!empty($_GET['s'])) {
            
            $termoBusca = $_GET['s'];
            
//            if(!empty($_GET['categoria'])) {
//                $categoria = $_GET['categoria'];
//            }
            
            $filtros = array('categoria'=>'');
            if(!empty($_GET['filtro']) && is_array($_GET['filtro'])) {
                $filtros = $_GET['filtro'];
            }

            $filtros['busca'] = $termoBusca;
            
//            if(!empty($_GET['categoria'])) {
//                $filtros['categoria'] = $categoria;
//                $dados['categoria'] = $filtros['categoria'];
//            }
            
            $paginaAtual = 1;
            $offset = 0;
            $limit = 9;

            if(!empty($_GET['p'])) {
                $paginaAtual = $_GET['p'];//pega na url GET o resultado de p, conforme definido no link da paginação do home            
            }       
            
             
            //            Filtros
            $dados['filtros'] = $f->getFiltros($filtros);
            $dados['filtros_selecionados'] = $filtros; //filtros selecionados pelo formulario GET
            $dados['termoBusca'] = $termoBusca;
            
            $offset = ($paginaAtual * $limit) - $limit;
            $dados['listaHome'] = $produtos->getProdutos($offset, $limit, $filtros);//pega todos produtos, definindo incio e limite
            $dados['totalProdutos'] = $produtos->getTotalProdutos($filtros);//pegando o total de itens do produto para gerar a paginação.
            $dados['numeroPaginas'] = ceil($dados['totalProdutos'] / $limit);//ceil arredonda pra cima
            $dados['paginaAtual'] = $paginaAtual;//pagina atual para activar paginação
            $dados['categorias'] = $categorias->getList();//pega a lista das categorias e subcategorias
                      
            $this->loadTemplate('busca', $dados);
        } else {
            header("Location:" .BASE_URL); 
        }
    }

}