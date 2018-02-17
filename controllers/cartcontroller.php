<?php
class cartcontroller extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $cart = new carrinho();
        $widget = new widget();
        
        $frete = array();
        $cep = '';
        
        if(!empty($_POST['cep'])) {
            $cep = intval($_POST['cep']);
            $frete = $cart->calculoFrete($cep);
            $_SESSION['frete'] = $frete;
        }
        
        if(!empty($_SESSION['frete'])) {
            $frete = $_SESSION['frete'];
        }
        
        if(!isset($_SESSION['cart']) || (isset($_SESSION['cart']) && count($_SESSION['cart']) == 0)) {
            unset($_SESSION['frete']);
            header("Location: ".BASE_URL);
            exit;
        }
        
        $dados = $widget->dadosTemplate();
        
        $dados['frete'] = $frete;
        $dados['cep'] = $cep;
       

        $dados['lista'] = $cart->getList();

        $this->loadTemplate('carrinho', $dados);
    }
    
    public function add() {
        
        if(!empty($_POST['id_produto'])) {
            $id = intval($_POST['id_produto']);
            $qt = intval($_POST['qt_produto']);  
            
            //incluir os produtos em uma SESSION
            if(!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();             
            }
            
            if(isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] += $qt;
            } else {
                $_SESSION['cart'][$id] = $qt;
            }            
        }
        header("Location: ".BASE_URL."cart");
        exit;
    }
    
    public function del($id){
        if(!empty($id)) {
            unset($_SESSION['cart'][$id]);
            unset($_SESSION['valor_produto']);
            unset($_SESSION['frete']);
            unset($_SESSION['finalizar']);
        }
        header("Location: ".BASE_URL."cart");
        exit;
    }
    
    public function freteDel() {
        if($_SESSION['frete']){
            unset($_SESSION['frete']);
        }
        header("Location: ".BASE_URL."cart");
        exit;
    }
    
    public function meiosPagamento($tipo) {
        $_SESSION['totalCompra'] = $_POST['totalCompra'];
        $_SESSION['totalFrete'] = $_POST['totalFrete'];
        $_SESSION['prazoFrete'] = $_POST['prazo'];
        if(!empty($tipo)) {
            $tipoPagamento = $tipo;
            
            switch ($tipoPagamento){
                case 'cartao':
                    header("Location: ".BASE_URL."pagseguro");
                    exit;
                    break;
                case 'boleto':
                    header("Location: ".BASE_URL."boleto");
                    exit;
                    break;
                case 'paypal':
                    header("Location: ".BASE_URL."paypal");
                    exit;
                    break;
            }
        }
        header("Location: ".BASE_URL."cart");
        exit;
        
    }
}