<?php
class pagsegurocontroller extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $produtos = new produtos();     
        $widget = new widget();
        $c = new cliente();
        $cart = new carrinho();
       
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
            $id = $_SESSION['ML_login'];
            $dados['dados'] = $c->consultar($id);
            $dados['lista'] = $cart->getList();
        } else {
            header("Location: ".BASE_URL."cliente/logar");
        }
        $this->loadTemplate('finalizar_compra', $dados);
    }
    
    public function checkcout() {

        $v = new vendas();
        $cart = new carrinho();
        
        if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
            
            $id_cliente = $_SESSION['ML_login'];
            //id de identificação da transação do Pagseguro, vindo pelo JS
            $id = addslashes($_POST['id']);
            $nome = addslashes($_POST['nome']);
            $doc = addslashes($_POST['doc']);
            $email = addslashes($_POST['email']);
            $cel = addslashes($_POST['cel']);
            $cep = addslashes($_POST['cep']);
            $rua = addslashes($_POST['rua']);
            $numero = addslashes($_POST['numero']);
            $complemento = addslashes($_POST['complemento']);
            $bairro = addslashes($_POST['bairro']);
            $cidade = addslashes($_POST['cidade']);
            $estado = addslashes($_POST['estado']);
            $nome_titutlar = addslashes($_POST['nome_titular']);
            $doc_titular = addslashes($_POST['doc_titular']);
            $numero_cartao = addslashes($_POST['numero_cartao']);
            $cvv = addslashes($_POST['cvv']);
            $v_mes = addslashes($_POST['v_mes']);
            $v_ano = addslashes($_POST['v_ano']);
            $cartao_token = addslashes($_POST['cartao_token']);
            $totalCompra = addslashes($_POST['totalCompra']);
            $totalCompra2 = str_replace(',', '.', $totalCompra);
            $totalFrete = addslashes($_SESSION['totalFrete']);
            $totalFrete2 = str_replace(',', '.', $totalFrete);
            $parcelas = explode(';', $_POST['parcelas']);
            $id_cartao = addslashes($_POST['id_cartao']);
            $id_endereco = addslashes($_POST['id_endereco']);
            $id_cupom = '';
         
            $tipo = 'Cartão';
            $id_venda = $v->novaVenda($id_cliente, $totalCompra2, $tipo, $id_endereco, $id_cartao, $id_cupom, $totalFrete2);
    if ($protocolo = $c->emailPedido($id_venda)) {    
                    //configuração do envio do email
                    $name = 'MercadoLeo';
    //                $email = $_REQUEST[ 'contact-email' ];
                    $subject = 'Mercado LeoDetalhes da Compra - Protocolo: '.$protocolo;
                    $message = '<h2 style="text-align:center"><strong>Clique <a href="'.BASE_URL.'perfil/pedidos">Aqui</a> para ver detalhes de sua compra:</strong></h2><br/>';
                    $mail_subject = $subject . "contato@mercadoleo.com.br";
                    $message = "Name: ".$nome."<br /><br />  Assunto: ".$subject."<br /> <br /> Menssagem:<br /> ".$message;

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
                }
            //pega as informações dos produtos salvos na Sessão
            $lista = $cart->getList();
            
            foreach ($lista as $item) {
                $v->addItem($id_venda, $item['id'], $item['qt'], $item['preco']);
            }
            
            global $config;

            $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
            $creditCard->setReceiverEmail($config['email_vendedor']);
            $creditCard->setReference($id_venda);
            $creditCard->setCurrency("BRL");
           
            foreach ($lista as $item) {
                $creditCard->addItems()->withParameters(
                    $item['id'],
                    $item['nome'],
                    intval($item['qt']),
                    floatval($item['preco'])
                );
            }
            
            //Informações do Comprador
            $creditCard->setSender()->setName($nome);
            $creditCard->setSender()->setEmail($email);
            $creditCard->setSender()->setDocument()->withParameters('CPF', $doc_titular);
        
            $ddd = substr($cel, 0, 2);
            $telefone = substr($cel, 2);

            $creditCard->setSender()->setPhone()->withParameters(
                $ddd,
                $telefone
            );
            
            //id de transação do PagSeguro vindo pelo JS
            $creditCard->setSender()->setHash($id);
            
            //IP da maquina que fez a requisição da compra
            $ip = $_SERVER['REMOTE_ADDR'];
            if(strlen($ip) < 9) {
                $ip = '127.0.0.1';
            }
            $creditCard->setSender()->setIp($ip);

            //endereço de entrega
            $creditCard->setShipping()->setAddress()->withParameters(
                $rua,
                $numero,
                $bairro,
                $cep,
                $cidade,
                $estado,
                'BRA',
                $complemento
            );
            $fretes = $_SESSION['totalFrete'];
            $frete = floatval(str_replace(',', '.', $fretes));
            $creditCard->setShipping()->setCost()->withParameters($frete);

            //endereço de cobrança
            $creditCard->setBilling()->setAddress()->withParameters(
                $rua,
                $numero,
                $bairro,
                $cep,
                $cidade,
                $estado,
                'BRA',
                $complemento
            );

            //informações do cartão de crédito
            $creditCard->setToken($cartao_token);
            $creditCard->setInstallment()->withParameters($parcelas[0], $parcelas[1]);
            $creditCard->setHolder()->setName($nome_titutlar);
            $creditCard->setHolder()->setDocument()->withParameters('CPF', $doc_titular);

            $creditCard->setMode('DEFAULT');

            $creditCard->setNotificationUrl(BASE_URL."pagseguro/notificacao");
          
            try {
            $array = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
                echo json_encode($array);
                exit();
                
            } catch(Exception $e) {
                echo json_encode(array('error'=>true, 'msg'=>$e->getMessage()));
                exit;
            }

        } else {
            header("Location: ".BASE_URL.'cliente/cadastrar');
        }
    }

    public function obrigado() {
        unset($_SESSION['cart']);
        unset($_SESSION['frete']);
        unset($_SESSION['finalizar']);
        
        $widget = new widget();
        
        $dados = $widget->dadosTemplate();
        
        $this->loadTemplate('obrigado', $dados);
    }
    
    public function notificacao() {
        $v = new vendas();
        
        try {
//            verificação se houve envio das informações
            if(\PagSeguro\Helpers\Xhr::hasPost()) {
                $r = \PagSeguro\Services\Transactions\Notification::check(
                    \PagSeguro\Configuration\Configure::getAccountCredentials()
                );
                
//                referencia - qual compra mudou de status e o numero do status
                $ref = $r->getReference();
                $status = $r->getStatus();
                /*
                1 = Aguardando Pagamento
                2 = Em análise
                3 = Paga
                4 = Disponível
                5 = Em disputa
                6 = Devolvida
                7 = Cancelada
                8 = Debitado
                9 = Retenção Temporária = Chargeback
                */

                if($status == 3) {
                    $v->setPaid($ref);
                }
                elseif($status == 7) {
                    $v->setCancelled($ref);
                }

            }

        } catch(Exception $e) {

        }
    }
    

}