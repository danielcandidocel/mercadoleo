<?php
class homecontroller extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $filtros= array();//variavel para atualização dos filtros
        
        $produtos = new produtos();
        $categorias = new categorias();
        $widget = new widget();
        
        $dados = $widget->dadosTemplate();
        
        $fb = new Facebook\Facebook([
            'app_id' => '126206881515613',
            'app_secret' => 'db14533b745e0f9a2495cc21e1f2ed0b',
            'default_graph_version' => 'v2.11'
        ]);
        
        $helper = $fb->getRedirectLoginHelper();
        
        $permissions = array('email');
        
        $loginurl = $helper->getLoginUrl(BASE_URL.'fb/calback', $permissions);
        $dados['loginurl'] = $loginurl;
        
        $f = new filtros();
        
         $filtros = array('categoria'=>'');
        if(!empty($_GET['filtro']) && is_array($_GET['filtro'])) {
            $filtros = $_GET['filtro'];
        }
        
        
        $paginaAtual = 1;
        $offset = 0;
        $limit = 9;
              
        if(!empty($_GET['p'])) {
            $paginaAtual = $_GET['p'];//pega na url GET o resultado de p, conforme definido no link da paginação do home            
        }     
         //        Filtros
        $dados['filtros'] = $f->getFiltros($filtros);
        $dados['filtros_selecionados'] = $filtros; //filtros selecionados pelo formulario GET
        $dados['termoBusca'] = '';
        
        $offset = ($paginaAtual * $limit) - $limit;
        $dados['listaHome'] = $produtos->getProdutos($offset, $limit, $filtros);//pega todos produtos, definindo incio e limite
        $dados['totalProdutos'] = $produtos->getTotalProdutos($filtros);//pegando o total de itens do produto para gerar a paginação.
        $dados['numeroPaginas'] = ceil($dados['totalProdutos'] / $limit);//ceil arredonda pra cima
        $dados['paginaAtual'] = $paginaAtual;//pagina atual para activar paginação
        
       
        
        $this->loadTemplate('home', $dados);
    }
    public function comprar() {
        unset($_SESSION['frete']);
        header("Location: ".BASE_URL);
    }

}