<?php

class boletocontroller extends controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $widget = new widget();
        $c = new cliente();
        $cart = new carrinho();
        $v = new vendas();
        
        $dados = $widget->dadosTemplate();
        
        if(isset($_SESSION['ML_login']) && !empty($_SESSION['ML_login'])) {
            $id = $_SESSION['ML_login'];
            $dados['dados'] = $c->consultar($id);
            $dados['lista'] = $cart->getList();
        
            if(!empty($_POST['nome'])) {

                $id_cliente = $_SESSION['ML_login'];                
                $nome = addslashes($_POST['nome']);
                $doc = addslashes($_POST['doc']);
                $email = addslashes($_POST['email']);
                $id_endereco = addslashes($_POST['id_endereco']);
                $cel = addslashes($_POST['cel']);
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
                $id_cartao = '';
                $id_cupom = '';

                $lista = $cart->getList();
                $tipo = 'Boleto';
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
                        //Integração com o Boleto

                        $options = array(
                            'client_id' => $config['gerencianet_clientid'],
                            'client_secret' => $config['gerencianet_secret'],
                            'sandbox' => $config['gerencianet-sandbox']
                        );

                        $itens = array();
                        foreach($lista as $item) {
                            $itens[] = array(
                                'name' => $item['nome'],
                                'amount' => $item['qt'],
                                'value' => ($item['preco']*100)
                            );
                        }
                        //custom_id -> identificador da transação
                        // notificiation_url -> endereço do recebimento da notificação
                        $metadata = array(
                            'custom_id' => $id_venda,
                            'notification_url' => BASE_URL.'boleto/notificacao'

                        );
                        $fretes = $_SESSION['totalFrete'];
                        $frete = floatval(str_replace(',', '.', $fretes));
                        $shipping = array(
                            array(
                                'name' => 'FRETE',
                                'value' => ($frete * 100)
                            )
                        );

                        //Corpo do envio para o Gerencianet
                        $body = array(
                            'metadata' => $metadata,
                            'items' => $itens,
                            'shippings' => $shipping
                        );

                        //registrando a venda
                        try{
                            $api = new \Gerencianet\Gerencianet($options);
                            $transacao = $api->createCharge(array(), $body);

                            if($transacao['code'] == '200') {
                                //pegando o codigo da transação feita
                                $charge_id = $transacao['data']['charge_id'];

                                //registrando o comprador

                                $params = array( 'id' => $charge_id);

                                $customer = array(
                                    'name' => $nome,
                                    'cpf' => $doc,
                                    'phone_number' => $cel
                                );

                                //informações do boleto

                                $bankingBillet = array(
                                    'expire_at' => date('Y-m-d', strtotime('+7 days')),
                                    'customer' => $customer,
                                    'message' => 'Ref. à Compra no Site MercadoLeo.com.br - Uma Empresa do Grupo Lany Tecnologia'
                                );

                                //Informações do Pagamento
                                $payment = array(
                                    'banking_billet' => $bankingBillet                            
                                );
                                $body = array(
                                    'payment' => $payment
                                );

                                //Gerar o Boleto
                                try {
                                    $transacao2 = $api->payCharge($params, $body);
                                    if($transacao2['code'] == '200') {

                                        $link = $transacao2['data']['link'];

                                        $v->updateBillet($id_venda, $link);

                                        unset($_SESSION['cart']);
                                        unset($_SESSION['frete']);
                                        unset($_SESSION['finalizar']);
                                        $dados['link'] = $link;
                                        $this->loadTemplate('obrigado_boleto', $dados);
                                        exit;
                                    }

                                }
                                catch(Excetion $e){
                                    echo "ERRO: ";
                                    print_r($e->getMessage());
                                    exit;
                                }
                            }
                        }
                        catch (Exception $e) {
                            echo "ERRO: ";
                            print_r($e->getMessage());
                            exit;
                        }
                
                    }
        $this->loadTemplate('boleto_finalizar_compra', $dados);
        
        } else {
            header("Location: ".BASE_URL."cliente/logar");
        }
       
    }
    
    public function notificacao() {
        
        global $config;
        
        $options = array(
            'client_id' => $config['gerencianet_clientid'],
            'client_secret' => $config['gerencianet_secret'],
            'sandbox' => $config['gerencianet-sandbox']
        );
        
        $token = $_POST['notification'];
        
        $params = array(
            'token' => $token
        );
        
        try{
            $api = new \Gerencianet\Gerencianet($options);
            $c = $api->getNotificacion($params, array());
            
            $ultimo = end($c['data']);
            $custom_id = $ultimo['custom_id'];
            $status = $ultimo['status']['current'];
            
            if($status == 'paid') {
                $v = new vendas();
                $v->setPaid($custom_id);
            }
            
        }
        catch(Exception $e) {
            echo "ERRO: ";
            print_r($e->getMessage());
            exit;
        }
    }
    
}

