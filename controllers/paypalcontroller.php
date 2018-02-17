<?php

class paypalcontroller extends controller {


    public function __construct() {
        parent::__construct();
    }

    public function index() {
    
    $widget = new widget();
    $c = new cliente();
    $cart = new carrinho();
    $v = new vendas();

    $dados = $widget->dadosTemplate();
    $dados['error'] = '';

    if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
        $id = $_SESSION['ML_login'];
        $dados['dados'] = $c->consultar($id);
        $dados['lista'] = $cart->getList();
        
        if(!empty($_POST['nome'])) {
        
        $id_cliente = $_SESSION['ML_login'];      
        $nome = addslashes($_POST['nome']);
        $doc = addslashes($_POST['doc']);
        $email = addslashes($_POST['email']);
        $cel = addslashes($_POST['cel']);
        $id_endereco = addslashes($_POST['id_endereco']);
        $cep = addslashes($_POST['cep']);
        $rua = addslashes($_POST['rua']);
        $numero = addslashes($_POST['numero']);
        $complemento = addslashes($_POST['complemento']);
        $bairro = addslashes($_POST['bairro']);
        $cidade = addslashes($_POST['cidade']);
        $estado = addslashes($_POST['estado']);
        $totalCompra = addslashes($_POST['totalCompra']);
        $totalCompra2 = str_replace(',', '.', $totalCompra);
        $totalFrete = addslashes($_SESSION['totalFrete']);
        $totalFrete2 = str_replace(',', '.', $totalFrete);
        $lista = $cart->getList();
        $id_cartao = '';
        $id_cupom = '';
        
        $tipo = 'Paypal';
        $id_venda = $v->novaVenda($id_cliente, $totalCompra2, $tipo, $id_endereco, $id_cartao, $id_cupom, $totalFrete2);
        if ($protocolo = $c->emailPedido($id_venda)) {    
                    //configuração do envio do email
                    $name = 'MercadoLeo';
    //                $email = $_REQUEST[ 'contact-email' ];
                    $subject = 'Mercado Leo Detalhes da Compra - Protocolo: '.$protocolo;
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
//        $fretes = $_SESSION['totalFrete'];
//        $frete = floatval(str_replace(',', '.', $fretes));

        foreach ($lista as $item) {
            $v->addItem($id_venda, $item['id'], $item['qt'], $item['preco']);
        }
            
        global $config;
            // Começar a integração ao Paypal
        $clienteID = $config['paypal_clientid'];
        $secret = $config['paypal_secret'];
       $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                      $clienteID,
                        $secret
                )
        );
        
        // Processo de pagamento
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        //Informações da venda
        $amount = new \PayPal\Api\Amount();
        $amount->setCurrency('BRL')->setTotal($totalCompra2);

        //Iniciando a Transação
        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
        $transaction->setInvoiceNumber($id_venda);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(BASE_URL.'paypal/obrigado');
        $redirectUrls->setCancelUrl(BASE_URL.'paypal/cancelar');

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));
        $payment->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);

            header("Location: ".$payment->getApprovalLink());
            exit;

        } catch(\PayPal\Exception\PayPalConnectionException $e) {
            echo $e->getData();
            exit;
        }
        }
        $this->loadTemplate('paypal_finalizar_compra', $dados);

    } else {
        header("Location: ".BASE_URL."cliente/logar");
    }
    
    }

    public function obrigado() {
//        unset($_SESSION['cart']);
//        unset($_SESSION['frete']);
//        $this->loadTemplate('paypal_obrigado', $dados);
    	$v = new vendas();

    	global $config;

    	$clienteID = $config['paypal_clientid'];
        $secret = $config['paypal_secret'];
       $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                      $clienteID,
                        $secret
                )
        );
       //paymentID -> pego no GET de retorno do paypal
        $paymentId = $_GET['paymentId'];
        $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);

        try {

            $result = $payment->execute($execution, $apiContext);

            try {

                $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);

                $status = $payment->getState();
                $t = current($payment->getTransactions());
                $t = $t->toArray();
                $ref = $t['invoice_number'];

                if($status == 'approved') {
                    $v->setPaid($ref);

                    unset($_SESSION['cart']);
                    unset($_SESSION['frete']);
                    unset($_SESSION['finalizar']);
                    
                    $widget = new widget();
                    $dados = $widget->dadosTemplate();

                    $this->loadTemplate('obrigado', $dados);
                } else {
                    $v->setCancelled($ref);

                    header("Location: ".BASE_URL."paypal/cancelar");
                    exit;
                }

            } catch(Exception $e) {
                    header("Location: ".BASE_URL."paypal/cancelar");
                    exit;
            }

        } catch(Exception $e) {
        	header("Location: ".BASE_URL."paypal/cancelar");
        	exit;
        }


    }

    public function cancelar() {
    

    	$widget = new widget();
    	$dados = $widget->dadosTemplate();

    	$this->loadTemplate('paypal_cancelar', $dados);

    }
}
  
