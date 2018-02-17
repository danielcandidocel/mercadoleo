<?php
class clientecontroller extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $dados = array();  
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
        }

        $this->loadTemplateCliente('meus_dados', $dados);
     
    }
    
    public function logar() {
        $dados = array();
        $widget = new widget();
        $dados = $widget->dadosTemplate();
        $c = new cliente();  
        //configurações API do Facebook
        $fb = new Facebook\Facebook([
            'app_id' => '126206881515613',
            'app_secret' => 'db14533b745e0f9a2495cc21e1f2ed0b',
            'default_graph_version' => 'v2.11'
        ]);
        
        $helper = $fb->getRedirectLoginHelper();
        
        $permissions = array('email');
        
        $loginurl = $helper->getLoginUrl(BASE_URL.'fb/calback', $permissions);
        $dados['loginurl'] = $loginurl;
        
        if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
            header("Location: ".BASE_URL);
        } else {
            $this->loadTemplateCliente('logar', $dados);
        }
    }

    public function cancelar($id) {
        $c = new cliente();
            $c->cancelar($id);
            unset($_SESSION['ML_login']);
            unset($_SESSION['nome']);
            unset($_SESSION['cart']);                  
    }

    public function login() {
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
            header("Location: ".BASE_URL);
//            $this->loadTemplate('home', $dados);

        } elseif(isset($_POST['login']) && !empty($_POST['login'])) {
            $login = addslashes($_POST['login']);
            $senha = $_POST['senha'];

                if($dado = $c->login($login, $senha)) {
                    if($dado['excluir'] == 2){
                        $dados['retorno'] = 1;
                        $this->loadTemplate('cliente_nao_cadastrado', $dados);
                    } elseif($dado['excluir'] == 1) {
                        $dados['retorno'] = 2;
                        $this->loadTemplate('cliente_nao_cadastrado', $dados);
                    } elseif ($dado['excluir'] == 0){
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
                    if(isset($_SESSION['cart'])){
                        $id = $_SESSION['ML_login'];
                        $dados['dados'] = $c->getDadosCliente($id);
                        header("Location: ".BASE_URL."cart");
                    } else{
                        $id = $_SESSION['ML_login'];
                        $dados['dados'] = $c->getDadosCliente($id);
                        header("Location: ".BASE_URL);
                    }
                } 
            }
	}  else {
            header("Location: ".BASE_URL);
        }          
    }
    
    public function sair(){
        $dados = array();
        unset($_SESSION['ML_login']);
        unset($_SESSION['nome']);
        header("Location: ".BASE_URL);
    }

    public function cadastrar() {
        $dados = array();
        $widget = new widget();
        $dados = $widget->dadosTemplate();
        
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = addslashes($_POST['email']);             
        } else {
            $email = '';
        }
              
        $dados['email'] = $email;
        $this->loadTemplateCliente('cadastrar', $dados);
    }
    
    public function cadastrarEndereco() {
        $c = new cliente();
        
        $id_cliente = addslashes($_POST['cliente']);
        $cep = addslashes($_POST['cep']);
        $rua = addslashes($_POST['rua']);
        $numero = addslashes($_POST['numero']);
        $complemento = addslashes($_POST['complemento']);
        $bairro = addslashes($_POST['bairro']);
        $cidade = addslashes($_POST['cidade']);
        $estado = addslashes($_POST['estado']);
        $endereco_principal = addslashes($_POST['endereco_principal']);        
        
        if(!empty($id_cliente)) {
            if($c->cadastrarEndereco($id_cliente, $cep, $rua, $numero, $complemento, $bairro, $cidade, $estado, $endereco_principal)){
                echo '1';
            } else {
                echo '0';
            }
        }
        
    }
    
    public function getDados() {
        $c = new cliente();
        
        $id = addslashes($_POST['id']);
        
        if(!empty($id)) {
            $array = $c->getDadosCliente($id);
            echo json_encode($array);
            exit();
        }
    }

    public function getCartao() {
        $c= new cliente();
        
        $id = addslashes($_POST['id']);
        $array = $c->getCartao($id);
        echo json_encode($array);
        exit();
    }
    
    public function getEndereco() {
        $c= new cliente();
        
        $id = addslashes($_POST['id']);
        $array = $c->getEnderecos($id);
        echo json_encode($array);
        exit();
    }

    public function editarEndereco() {
        $c = new cliente();
        
        $id_cliente = addslashes($_POST['id_cliente']);
        $id = addslashes($_POST['id']);
        $cep = addslashes($_POST['cep']);
        $rua = addslashes($_POST['rua']);
        $numero = addslashes($_POST['numero']);
        $complemento = addslashes($_POST['complemento']);
        $bairro = addslashes($_POST['bairro']);
        $cidade = addslashes($_POST['cidade']);
        $estado = addslashes($_POST['estado']);
        $endereco_principal = addslashes($_POST['endereco_principal']);        
        
        if(!empty($id)) {
            if($c->editarEndereco($id_cliente, $id, $cep, $rua, $numero, $complemento, $bairro, $cidade, $estado, $endereco_principal)){
                echo '1';
            } else {
                echo '0';
            }
        }
        
    }
    
    public function excluirEndereco () {
        $c = new cliente();
        
        $id = addslashes($_POST['id']);
        
        if(!empty($id)) {
            if($c->excluirEndereco($id)){
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    public function cadastrarCartao() {
        $c = new cliente();
        
        $id_cliente = addslashes($_POST['cliente']);
        $cartao = addslashes($_POST['num_cartao']);
        $bandeira = addslashes($_POST['bandeira']);
//        switch($band){
//            case 'Visa':
//                $bandeira = '1';
//                break;
//            case 'Mastercard':
//                $bandeira = '2';
//                break;
//        }
//        
        $titular = addslashes($_POST['titular']);
        $cpf = addslashes($_POST['cpf']);
        $cvv = addslashes($_POST['cvv']);
        $mes_venc = addslashes($_POST['mes_venc']);
        $ano_venc = addslashes($_POST['ano_venc']);
        $principal = addslashes($_POST['principal']);
                
        if(!empty($id_cliente)) {
            if($c->cadastrarCartao($id_cliente, $cartao, $bandeira, $titular, $cpf, $cvv, $mes_venc, $ano_venc, $principal)){
                echo '1';
            } else {
                echo '0';
            }
        }
    }
    
        public function excluirCartao () {
        $c = new cliente();
        
        $id = addslashes($_POST['id']);
        
        if(!empty($id)) {
            if($c->excluirCartao($id)){
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    public function editarCartao() {
        $c = new cliente();
        
        $id_cliente = addslashes($_POST['id_cliente']);
        $id = addslashes($_POST['id']);
        $cartao = addslashes($_POST['cartao']);
        $bandeira = addslashes($_POST['bandeira']);
        $titular = addslashes($_POST['titular']);
        $cpf = addslashes($_POST['cpf']);
        $cvv = addslashes($_POST['cvv']);
        $mes_venc = addslashes($_POST['mes_venc']);
        $ano_venc = addslashes($_POST['ano_venc']);   
        $principal = addslashes($_POST['principal']);
        
        if(!empty($id)) {
            if($c->editarCartao($id_cliente, $id, $cartao, $bandeira, $titular, $cpf, $cvv, $mes_venc, $ano_venc, $principal)){
                echo '1';
            } else {
                echo '0';
            }
        }
        
    }
    public function editar() {
        $c = new cliente();
        
        $id = addslashes($_POST['id']);
        $nome = addslashes($_POST['nome']);
        $email = addslashes($_POST['email']);
        if ($_POST['mes_nasc'] < 10) {
                $mes_nasc = '0'.addslashes($_POST['mes_nasc']);
            } else {
                $mes_nasc = addslashes($_POST['mes_nasc']);
            }
            if ($_POST['dia_nasc'] < 10) {
                $dia_nasc = '0'.addslashes($_POST['dia_nasc']);
            } else {
                $dia_nasc = addslashes($_POST['dia_nasc']);
            }
        $data_nasc = addslashes($_POST['ano_nasc']).$mes_nasc.$dia_nasc;
        $sexo = addslashes($_POST['sexo']);
        if(!empty($_POST['responsavel'])) {
            $responsavel = addslashes($_POST['responsavel']);
        } else {
            $responsavel = '';
        }
        $tel = addslashes($_POST['tel']);
        $cel = addslashes($_POST['cel']);
        
        if(!empty($id)) {
            if($c->editar($id, $nome, $email, $data_nasc, $sexo, $responsavel, $tel, $cel)){
                echo '1';
            } else {
                echo '0';
            }
        }
        
    }
    public function validaCPF($cpf) {
         //validação do CPF
        
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        $digitoA = 0;
        $digitoB = 0;
        if(strlen($cpf) < 11) {
            echo '1';
            exit();
        };
        for ($i=0, $x=10;$i<=8;$i++, $x--) {
            $digitoA += $cpf[$i] *$x;
        }
        for ($i=0, $x=11;$i<=9;$i++, $x--) {
                if(str_repeat($i, 11) == $cpf) {
                     echo '1';
                     exit();
                }
                $digitoB += $cpf[$i] *$x;            
            }     
        //% = quociente, ou seja o resto da divisão, no caso abaixo é o resto de $digitoA divido por 11, exemplo: 20/11= 1 e resto 9, 9 é o quociente
        $somaA = (($digitoA%11) < 2) ? 0 : 11-($digitoA%11);
        $somaB = (($digitoB%11) < 2) ? 0 : 11-($digitoB%11);
        //indice 9 é o nono digito do CPF
        if($somaA != $cpf[9] || $somaB != $cpf[10]) {        
            echo '1';
        } else {
             echo '0';
        }
        
    }
    
     public function validaCNPJ($cnpj) {
    //validação do CNPJ
        
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        
        $digitoA = 0;
        $digitoB = 0;
        if(strlen($cnpj) < 13) {
            echo '1';
            exit();
        };
       
        for ($i=0, $x=5;$i<=3;$i++, $x--) {
            $digitoA += $cnpj[$i] *$x;
        }
        for ($i=4, $x=9;$i<=11;$i++, $x--) {
            $digitoA += $cnpj[$i] *$x;
        }
       
        for ($i=0, $x=6;$i<=4;$i++, $x--) {
                if(str_repeat($i, 14) == $cnpj) {
                     echo '1';
                     exit();
                }
                $digitoB += $cnpj[$i] *$x;            
            }   
            for ($i=5, $x=9;$i<=12;$i++, $x--) {
                if(str_repeat($i, 14) == $cnpj) {
                     echo '1';
                     exit();
                }
                $digitoB += $cnpj[$i] *$x;            
            }
        //% = quociente, ou seja o resto da divisão, no caso abaixo é o resto de $digitoA divido por 11, exemplo: 20/11= 1 e resto 9, 9 é o quociente
        $somaA = (($digitoA%11) < 2) ? 0 : 11-($digitoA%11);
        $somaB = (($digitoB%11) < 2) ? 0 : 11-($digitoB%11);
        //indice 9 é o nono digito do CPF
        
        if($somaA != $cnpj[12] || $somaB != $cnpj[13]) {        
            echo '1';
        } else {
             echo '0';
        }
     }
     
     public function addPF(){
        $c = new cliente();
        if(isset($_POST['nome']) && !empty($_POST['nome'])){
            $nome = addslashes($_POST['nome']); 
            if ($_POST['mes_nasc'] < 10) {
                $mes_nasc = '0'.addslashes($_POST['mes_nasc']);
            } else {
                $mes_nasc = addslashes($_POST['mes_nasc']);
            }
            if ($_POST['dia_nasc'] < 10) {
                $dia_nasc = '0'.addslashes($_POST['dia_nasc']);
            } else {
                $dia_nasc = addslashes($_POST['dia_nasc']);
            }
            $data_nasc = addslashes($_POST['ano_nasc']).$mes_nasc.$dia_nasc;
            //0 para Masculino e 1 para Feminino
            $sexo = addslashes($_POST['sexo']);
            $cep = addslashes($_POST['cep']);
            $rua = addslashes($_POST['rua']);
            $numero = addslashes($_POST['numero']);
            $bairro = addslashes($_POST['bairro']);
            $complemento = addslashes($_POST['complemento']);
            $cidade = addslashes($_POST['cidade']);
            $estado = addslashes($_POST['uf']);
            $telefone = addslashes($_POST['tel']);
            $celular = addslashes($_POST['cel']);
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
             //1 - para aceito newslwtter e 0 para não aceito
            if(isset($_POST['newsletter'])) {
                $newsletter = 1;  
            } else {
                $newsletter = 0;               
            }
           
            if (isset($_POST['cnpj']) && !empty($_POST['cnpj'])) {
                $cnpj = addslashes($_POST['cnpj']);                                                  
            } else {
                $cnpj = '';
            }
            if(isset($_POST['cpf']) && !empty($_POST['cpf'])) {
                $cpf = addslashes($_POST['cpf']);
            } else {
                $cpf = '';
            }
        }

        $c->addPF($nome, $data_nasc, $sexo, $cep, $rua, $numero, $bairro, $complemento, $cidade, $estado, $telefone, $celular, $email, $senha, $newsletter, $cpf, $cnpj);
         header("Location: ".BASE_URL."cliente/cadastroSucesso");
        
         
     }
     
      public function addPJ(){
        $c = new cliente();
        if(isset($_POST['razao']) && !empty($_POST['razao'])){
            $razao = addslashes($_POST['razao']); 
            $responsavel = addslashes($_POST['responsavel']);
            $cep = addslashes($_POST['cep1']);
            $rua = addslashes($_POST['rua1']);
            $numero = addslashes($_POST['numero1']);
            $bairro = addslashes($_POST['bairro1']);
            $complemento = addslashes($_POST['complemento1']);
            $cidade = addslashes($_POST['cidade1']);
            $estado = addslashes($_POST['uf1']);
            $telefone = addslashes($_POST['tel1']);
            $celular = addslashes($_POST['cel1']);
            $email = addslashes($_POST['email1']);
            $senha = addslashes($_POST['senha1']);
             //1 - para aceito newslwtter e 0 para não aceito
            if(isset($_POST['newsletter1'])) {
                $newsletter = 1;  
            } else {
                $newsletter = 0;               
            }
           
            if (isset($_POST['cnpj']) && !empty($_POST['cnpj'])) {
                $cnpj = addslashes($_POST['cnpj']);                                                  
            } else {
                $cnpj = '';
            }
            if(isset($_POST['cpf']) && !empty($_POST['cpf'])) {
                $cpf = addslashes($_POST['cpf']);
            } else {
                $cpf = '';
            }
        }

        $c->addPJ($razao, $responsavel, $cep, $rua, $numero, $bairro, $complemento, $cidade, $estado, $telefone, $celular, $email, $senha, $newsletter, $cpf, $cnpj);
         header("Location: ".BASE_URL."cliente/cadastroSucesso");
        
         
     }
     
     public function cadastroSucesso() {
        $dados = array();
        $widget = new widget();
        
        $dados = $widget->dadosTemplate();
         
        $this->loadTemplateCliente('cadastroSucesso', $dados);
     }
     
         
    public function pesquisarCPF($cpf) {
        
        $c = new cliente();
        if($c->pesquisarCPF($cpf)){            
            echo '1';
        } else {
            echo '0';
        }  
    }
    
    public function pesquisarCNPJ($cnpj) {
        
        $c = new cliente();
        if($c->pesquisarCNPJ($cnpj)){            
            echo '1';
        } else {
            echo '0';
        }  
    }
    
    public function pesquisarEmail($email) {

        $c = new cliente();
        if($c->pesquisarEmail($email)){            
            echo '1';
        } else {
            echo '0';
        }     
    }
    
    public function pesquisarEmailCliente() {
        $c = new cliente();
        $id = addslashes($_POST['id']);
        $email = addslashes($_POST['email']);
        if($c->pesquisarEmailCliente($id, $email)){            
            echo '1';
        } else {
            echo '0';
        }
    }

    public function esqueci() {
        $dados = array();
        $widget = new widget();
        
        $dados = $widget->dadosTemplate();
        
        $c = new cliente();
        
        $dados['retorno'] = 1;
        if(!empty($_POST['email'])){
            //verificar se email exite
            $email = addslashes($_POST['email']);
            if($c->getEmail($email)){
                $dados['token'] = $c->esqueciSenha($email);
                $token = $dados['token'];
                $link = '<a href="'.BASE_URL.'cliente/redefinir?token='.$token.'">LINK</a>';
                //configuração do envio do email
                $name = 'MercadoLeo';
//                $email = $_REQUEST[ 'contact-email' ];
                $subject = 'Redefinir Senha';
                $message = '<h2 style="text-align:center"><strong>Clique <a href="'.BASE_URL.'cliente/redefinir?token='.$token.'">Aqui</a> para redefinir sua Senha:</strong></h2><br/>';
                $mail_subject = $subject . "contato@mercadoleo.com.br";
                $message = "Name: ".$name."<br /><br />  Assunto: ".$subject."<br /> <br /> Menssagem:<br /> ".$message;
        
                include("class/class.phpmailer.php");
 

                $mail = new PHPMailer(true);

                // Define os dados do servidor e tipo de conexão
                // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                $mail->IsMail(); // Define que a mensagem será SMTP

                try {
                     $mail->Host = 'smtp.jlcreative.com.br';
                     $mail->SMTPAuth   = true;  
                     $mail->Port       = 587; 
                     $mail->Username = 'contato@mercadoleo.com.br'; 
                     $mail->Password = 'mercadoleo524629'; 

                     //Define o remetente
                     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
                     $mail->SetFrom('contato@mercadoleo.com.br', $email); //DE: PARA:
                     $mail->AddReplyTo($email, 'Redefinir'); //RESPOSTA PARA:
                     $mail->Subject = $subject;//Assunto do e-mail


                     //Define os destinatário(s)
                     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                     $mail->AddAddress($email, $subject);

                     //Campos abaixo são opcionais 
                     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
                     //$mail->AddCC('danielcandidocel@gmail.com', $email); // Copia
                     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
                     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo

                     //Define o corpo do email
                     $mail->MsgHTML($message); 

                     ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
                     //$mail->MsgHTML(file_get_contents('arquivo.html'));

                     $mail->Send();
                    

                    //caso apresente algum erro é apresentado abaixo com essa exceção.
                    }catch (phpmailerException $e) {
                      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
                }
                
                
                
                $dados['retorno'] = 2;                
            } else {
                $dados['retorno'] = 3;
            }
        }
            $this->loadTemplateCliente('esqueci_senha', $dados);
    }
    
    public function redefinir(){
        $dados = array();
        $widget = new widget();
        $c = new cliente();
        $dados = $widget->dadosTemplate();
        
        $dados['retorno'] = 1;
        if(!empty($_GET['token'])){
            $token = addslashes($_GET['token']);
            $id = $c->verificarToken($token);
            if($id > 0){
                $senha = addslashes($_POST['senha']);
                $senha1 = addslashes($_POST['senha1']);
                $dados['retorno'] = 1;
                if(!empty($senha) && !empty($senha1)){
                    if($senha == $senha1){
                        $c->atualizarSenha($id, $senha, $token);
                        $dados['retorno'] = 2;
                    } else {
                        $dados['retorno'] = 3;
                    }
                }
            } else {
                $dados['retorno'] = 4;
            }
            
        } else {
            
        }
        $this->loadTemplateCliente('redefinir', $dados);
    }
    
    public function pedido() {
        $c= new cliente();
        
        $id = addslashes($_POST['id']);
        $array = $c->pedido($id);
        echo json_encode($array);
        exit();
    }
    
    public function endereco() {
        $c= new cliente();
        
        $id = addslashes($_POST['id_endereco']);
        $array = $c->endereco($id);
        echo json_encode($array);
        exit();
    }
    
    public function dadosVenda() {
        $c= new cliente();
        
        $id = addslashes($_POST['id_pedido']);
        $array = $c->dadosVendas($id); 
        echo json_encode($array);
        exit();
    }
    public function dadosCartao() {
        $c= new cliente();
        
        $id = addslashes($_POST['id_pedido']);
        $array = $c->dadosCartoes($id); 
        echo json_encode($array);
        exit();
    }
    
        public function dadosProduto() {
        $c= new cliente();
        
        $id = addslashes($_POST['id_pedido']);
        $array = $c->dadosProdutos($id); 
        echo json_encode($array);
        exit();
    }
}