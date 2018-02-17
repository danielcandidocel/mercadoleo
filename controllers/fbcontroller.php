<?php
class fbcontroller extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {}

    public function calback() {
        $dados = array();
        $widget = new widget();
        $dados = $widget->dadosTemplate();
        
        $fb = new Facebook\Facebook([
            'app_id' => '126206881515613',
            'app_secret' => 'db14533b745e0f9a2495cc21e1f2ed0b',
            'default_graph_version' => 'v2.11'
        ]);
        
        $helper = $fb->getRedirectLoginHelper();
        
        try{     
            $_SESSION['ML_login'] = (string) $helper->getAccessToken();
            
            $res = $fb->get('/me?fields=name,id,picture', $_SESSION['ML_login']);
            
            //json_decode -> pra transformar de json para array
            $r = json_decode($res->getBody());
            $_SESSION['nome'] = $r->name;
            $dados['nome'] = $r->name;
            $dados['email'] = $r->email;
            $dados['id'] = $r->id;
            $dados['picture'] = $r->picture->data->url;
             
        } catch(Facebook\Exceptions\FacebookResponseException $e){
            echo "ERRO: ".$e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e){
            echo "ERRO: ".$e->getMessage();
            exit;
        }
    	$this->loadTemplateCliente('calback', $dados);
    }

}

