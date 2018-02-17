<?php
class perfilcontroller extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $dados = array();
        $widget = new widget();
        $dados = $widget->dadosTemplate();
        $c = new cliente();     
        
             
   
        if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
            if (!empty($_SESSION['nome'])) {
                $string = $_SESSION['nome'];                
                $nome = explode(' ', $string);  
                    if(isset($nome[1])) {
                        $nome1 = array_reverse($nome);
                        $dados['nome'] = $nome[0].' '.$nome1[0];
                    } else {
                        $dados['nome'] = $string;
                    }
            } else {
                $dados['nome'] = '';
            }
            $id = $_SESSION['ML_login'];
            $dados['dados'] = $c->getDadosCliente($id);
            $this->loadTemplateCliente('meus_dados', $dados);

        } elseif(isset($_POST['login']) && !empty($_POST['login'])) {
            $login = addslashes($_POST['login']);
            $senha = $_POST['senha'];

                if($c->login($login, $senha)) {
                    if (!empty($_SESSION['nome'])) {
                        $string = $_SESSION['nome'];                
                        $nome = explode(' ', $string);  
                            if(isset($nome[1])) {
                                $nome1 = array_reverse($nome);
                                $dados['nome'] = $nome[0].' '.$nome1[0];
                            } else {
                                $dados['nome'] = $string;
                            }
                    } else {
                        $dados['nome'] = '';
                    }
                    $id = $_SESSION['ML_login'];
                    $dados['dados'] = $c->getDadosCliente($id);
                    $this->loadTemplateCliente('meus_dados', $dados);
                } else {
                    $this->loadTemplate('home', $dados);
                }
	}  else {
            header("Location: ".BASE_URL);
        }
    }
    
    public function meus_dados() {
        $dados = array();
        $widget = new widget();
        $dados = $widget->dadosTemplate();
        $c = new cliente();         
        
   
        if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
            if (!empty($_SESSION['nome'])) {
                $string = $_SESSION['nome'];                
                $nome = explode(' ', $string);  
                    if(isset($nome[1])) {
                        $nome1 = array_reverse($nome);
                        $dados['nome'] = $nome[0].' '.$nome1[0];
                    } else {
                        $dados['nome'] = $string;
                    }
            } else {
                $dados['nome'] = '';
            }
            $id = $_SESSION['ML_login'];
            $dados['dados'] = $c->getDadosCliente($id);
           
            if(isset($_SESSION['finalizar'])) {
                if(isset($_GET['tipo'])){
                    $_SESSION['finalizar'] = $_GET['tipo'];
                    $dados['tipo'] = $_SESSION['finalizar'];
                } else {
                    $dados['tipo'] = $_SESSION['finalizar'];
                } 
            } else if(isset($_GET['tipo'])){
                $_SESSION['finalizar'] = $_GET['tipo'];
                $dados['tipo'] = $_SESSION['finalizar'];
            }
            
            $this->loadTemplateCliente('meus_dados', $dados);

        } elseif(isset($_POST['login']) && !empty($_POST['login'])) {
            $login = addslashes($_POST['login']);
            $senha = $_POST['senha'];

                if($c->login($login, $senha)) {
                    if (!empty($_SESSION['nome'])) {
                        $string = $_SESSION['nome'];                
                        $nome = explode(' ', $string);  
                            if(isset($nome[1])) {
                                $nome1 = array_reverse($nome);
                                $dados['nome'] = $nome[0].' '.$nome1[0];
                            } else {
                                $dados['nome'] = $string;
                            }
                    } else {
                        $dados['nome'] = '';
                    }
                    $id = $_SESSION['ML_login'];
                    $dados['dados'] = $c->getDadosCliente($id);
                    
                    if(isset($_SESSION['finalizar'])) {
                        if(isset($_GET['tipo'])){
                            $_SESSION['finalizar'] = $_GET['tipo'];
                            $dados['tipo'] = $_SESSION['finalizar'];
                        } else {
                            $dados['tipo'] = $_SESSION['finalizar'];
                        } 
                    } else if(isset($_GET['tipo'])){
                        $_SESSION['finalizar'] = $_GET['tipo'];
                        $dados['tipo'] = $_SESSION['finalizar'];
                    }
                    
                    $this->loadTemplateCliente('meus_dados', $dados);
                } else {
                    $this->loadTemplate('home', $dados);
                }
	}  else {
            header("Location: ".BASE_URL);
        } 
    }

     public function pedidos() {
        $dados = array();  
        $c = new cliente();
        $widget = new widget();
        $dados = $widget->dadosTemplate();
         if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
            if (!empty($_SESSION['nome'])) {
                $string = $_SESSION['nome'];                
                $nome = explode(' ', $string);  
                    if(isset($nome[1])) {
                        $nome1 = array_reverse($nome);
                        $dados['nome'] = $nome[0].' '.$nome1[0];
                    } else {
                        $dados['nome'] = $string;
                    }
            } else {
                $dados['nome'] = '';
            }
            $id = $_SESSION['ML_login'];
            $dados['dados'] = $c->getPedidos($id);
            
            if(isset($_SESSION['finalizar'])) {
                if(isset($_GET['tipo'])){
                    $_SESSION['finalizar'] = $_GET['tipo'];
                    $dados['tipo'] = $_SESSION['finalizar'];
                } else {
                    $dados['tipo'] = $_SESSION['finalizar'];
                } 
            } else if(isset($_GET['tipo'])){
                $_SESSION['finalizar'] = $_GET['tipo'];
                $dados['tipo'] = $_SESSION['finalizar'];
            }
            
            $this->loadTemplateCliente('meus_pedidos', $dados);

        }
    }
    
     public function enderecos() {
        $dados = array();  
        $c = new cliente();
        $widget = new widget();
        $dados = $widget->dadosTemplate();
         if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
            if (!empty($_SESSION['nome'])) {
                $string = $_SESSION['nome'];                
                $nome = explode(' ', $string);  
                    if(isset($nome[1])) {
                        $nome1 = array_reverse($nome);
                        $dados['nome'] = $nome[0].' '.$nome1[0];
                    } else {
                        $dados['nome'] = $string;
                    }
            } else {
                $dados['nome'] = '';
            }
            $id = $_SESSION['ML_login'];
            $dados['dados'] = $c->getEnderecoCliente($id);
            
            if(isset($_SESSION['finalizar'])) {
                if(isset($_GET['tipo'])){
                    $_SESSION['finalizar'] = $_GET['tipo'];
                    $dados['tipo'] = $_SESSION['finalizar'];
                } else {
                    $dados['tipo'] = $_SESSION['finalizar'];
                } 
            } else if(isset($_GET['tipo'])){
                $_SESSION['finalizar'] = $_GET['tipo'];
                $dados['tipo'] = $_SESSION['finalizar'];
            }
            
            $this->loadTemplateCliente('meus_enderecos', $dados);

        }
    }
    
    public function cartoes() {
        $dados = array();  
        $c = new cliente();
        $widget = new widget();
        $dados = $widget->dadosTemplate();
        
         try {
            $sessionCode = \PagSeguro\Services\Session::create( \PagSeguro\Configuration\Configure::getAccountCredentials()
                    );
            $dados['sessioncode'] = $sessionCode->getResult();
        } catch (Exception $e) {
            echo 'ERRO: '.$e->getMessage();
            exit;
        }
        
         if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
            if (!empty($_SESSION['nome'])) {
                $string = $_SESSION['nome'];                
                $nome = explode(' ', $string);  
                    if(isset($nome[1])) {
                        $nome1 = array_reverse($nome);
                        $dados['nome'] = $nome[0].' '.$nome1[0];
                    } else {
                        $dados['nome'] = $string;
                    }
            } else {
                $dados['nome'] = '';
            }
            $id = $_SESSION['ML_login'];
            $dados['dados'] = $c->getCartoesCliente($id);
            
            if(isset($_SESSION['finalizar'])) {
                if(isset($_GET['tipo'])){
                    $_SESSION['finalizar'] = $_GET['tipo'];
                    $dados['tipo'] = $_SESSION['finalizar'];
                } else {
                    $dados['tipo'] = $_SESSION['finalizar'];
                } 
            } else if(isset($_GET['tipo'])){
                $_SESSION['finalizar'] = $_GET['tipo'];
                $dados['tipo'] = $_SESSION['finalizar'];
            }
            
            $this->loadTemplateCliente('meus_cartoes', $dados);

        }
    }
    
    public function addFoto(){
        $dados = array();
        
        if(isset($_FILES['foto-perfil']) && !empty($_FILES['foto-perfil']['tmp_name'])){
             
            $permitidos = array('image/jpg', 'image/jpeg', 'image/png');
            if(in_array($_FILES['foto-perfil']['type'], $permitidos)) {
                
                $nome = md5(time().rand(0, 999)).'.png';
                move_uploaded_file($_FILES['foto-perfil']['tmp_name'], 'assets/images/perfil/user.png');
                
            }
        }
        
        header("Location: ".BASE_URL.'perfil/meus_dados');
    }
}