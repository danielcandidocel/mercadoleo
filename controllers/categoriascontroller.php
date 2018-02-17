<?php
class categoriascontroller extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        header("Location:" .BASE_URL);  
    }
    
    public function enter($id) {
        
        $produtos = new produtos();
        $categorias = new categorias();
        $f = new filtrosCategorias();  
        $widget = new widget();
        
        $dados = $widget->dadosTemplate();
        $dados['nome_categoria'] = $categorias->getNome($id);        
        if(!empty($dados['nome_categoria'])) {
            $paginaAtual = 1;
            $offset = 0;
            $limit = 9;
            $filtros = array('categoria'=>$id);//filtro para exebição dos produtos por categoria   
            if(!empty($_GET['filtro']) && is_array($_GET['filtro'])) {
                $filtros['filtros'] = $_GET['filtro'];
                
            }
            if(!empty($_GET['p'])) {
                $paginaAtual = $_GET['p'];//pega na url GET o resultado de p, conforme definido no link da paginação do home            
            }        
            
               //        Filtros
                $dados['filtros'] = $f->getFiltros($filtros);
                $dados['filtros_selecionados'] = $filtros; //filtros selecionados pelo formulario GET
                $dados['termoBusca'] = '';
                
                $offset = ($paginaAtual * $limit) - $limit;
                $dados['listaHome'] = $produtos->getList($offset, $limit, $filtros);//pega todos produtos, definindo incio e limite
                $dados['totalProdutos'] = $produtos->getTotalProdutosCat($filtros);//pegando o total de itens do produto para gerar a paginação.
                $dados['numeroPaginas'] = ceil($dados['totalProdutos'] / $limit);//ceil arredonda pra cima
                $dados['paginaAtual'] = $paginaAtual;//pagina atual para activar paginação
                $dados['categorias'] = $categorias->getList();//pega a lista das categorias e subcategorias
                $dados['id_categoria'] = $id;//mandar o id da categoria para o link da paginação no view
                $dados['filtros_categorias'] = $categorias->getCategoriasArvore($id);
               
             
        
                $this->loadTemplate('categorias', $dados);
                
        } else {
                header("Location:" .BASE_URL);
            }
    }
}