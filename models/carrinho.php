<?php
class carrinho extends model {

    public function getList(){
        $array = array();
        $car = array();
        $produto = new produtos();
        
        if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];
        
            foreach ($cart as $id => $qt){
                $info = $produto->getInfo($id);

                $array[] = array(
                    'id' => $id,
                    'qt' => $qt,
                    'preco' => $info['preco'],
                    'nome' => $info['nome'],
                    'imagem' => $info['imagem'],
                    'peso' => $info['peso'],
                    'altura' => $info['altura'],
                    'largura' => $info['largura'],
                    'comprimento' => $info['comprimento'],
                    'diametro' => $info['diametro'],
                    'slug' => $info['slug']
                );
            }
        }
        return $array;
    }
    
    public function getSubTotal() {
        $list = $this->getList();
        
        $sub = 0;
        
        foreach ($list as $item) {
            $sub += (floatval($item['preco']) * intval($item['qt']));
        }
        
        return $sub;
    }
    
    public function calculoFrete($cepDestino) {
        $array = array(        
        );
         
//        Integração com o Webservice do Correios
        global $config;
        
        $lista = $this->getList();
    
        $nVlPeso = 0;            
        $nVlComprimento = 0;
        $nVlAltura = 0;
        $nVlLargura = 0;
        $nVlDiametro = 0;
        $nVlValorDeclarado = 0;
        
        foreach ($lista as $item) {
            $nVlPeso += floatval($item['peso']);
            $nVlComprimento += floatval($item['comprimento']);
            $nVlAltura += floatval($item['altura']);
            $nVlLargura += floatval($item['largura']);
            $nVlDiametro += floatval($item['diametro']);
            $nVlValorDeclarado += floatval($item['preco'] * $item['qt']);
        }
        
        $soma = $nVlComprimento + $nVlAltura + $nVlLargura;
        if($soma > 200) {
            $nVlComprimento = 66;
            $nVlAltura = 66;
            $nVlLargura = 66;
        }
        
        if($nVlDiametro > 90){
            $nVlDiametro = 90;
        }
        
        if($nVlPeso > 40){
            $nVlPeso = 40;
        }
       
        $sedex = array(
            'nCdServico' => '40010', //Sedex
            'sCepOrigem' => $config['cepOrigem'],
            'sCepDestino' => $cepDestino,
            'nVlPeso' => $nVlPeso,
            'nCDFormato' => '1', //1 - para caixa, 3 - para envelope
            'nVlComprimento' => $nVlComprimento,
            'nVlAltura' => $nVlAltura,
            'nVlLargura' => $nVlLargura,
            'nVlDiametro' => $nVlDiametro,
            'sCdMaoPropria' => 'N',
            'nVlValorDeclarado' => $nVlValorDeclarado,
            'sCdAvisoRecebimento' => 'N',
            'StrRetorno' => 'xml'
        );
        $sedex10 = array(
            'nCdServico' => '40215', //Sedex10
            'sCepOrigem' => $config['cepOrigem'],
            'sCepDestino' => $cepDestino,
            'nVlPeso' => $nVlPeso,
            'nCDFormato' => '1', //1 - para caixa, 3 - para envelope
            'nVlComprimento' => $nVlComprimento,
            'nVlAltura' => $nVlAltura,
            'nVlLargura' => $nVlLargura,
            'nVlDiametro' => $nVlDiametro,
            'sCdMaoPropria' => 'N',
            'nVlValorDeclarado' => $nVlValorDeclarado,
            'sCdAvisoRecebimento' => 'N',
            'StrRetorno' => 'xml'
        );
        $pac = array(
            'nCdServico' => '41106', //PAC
            'sCepOrigem' => $config['cepOrigem'],
            'sCepDestino' => $cepDestino,
            'nVlPeso' => $nVlPeso,
            'nCDFormato' => '1', //1 - para caixa, 3 - para envelope
            'nVlComprimento' => $nVlComprimento,
            'nVlAltura' => $nVlAltura,
            'nVlLargura' => $nVlLargura,
            'nVlDiametro' => $nVlDiametro,
            'sCdMaoPropria' => 'N',
            'nVlValorDeclarado' => $nVlValorDeclarado,
            'sCdAvisoRecebimento' => 'N',
            'StrRetorno' => 'xml'
        );
//        URL dos Correios
        $url = 'http://ws.correios.com.br/calculador/CalcPrecoprazo.aspx';
        
//        transformando o array em queryString (Ex.: preco=10&prazo=100...
        $sedex = http_build_query($sedex);//Sedex
        $sedex10 = http_build_query($sedex10);//Sedex10
        $pac = http_build_query($pac);//Pac
        
//        Inciando a biblioteca CURL que faz requisição Webservice
        $ch = curl_init($url.'?'.$sedex);
        $ch1 = curl_init($url.'?'.$sedex10);
        $ch2 = curl_init($url.'?'.$pac);
        
//        Para receber a resposta
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = curl_exec($ch);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        $r1 = curl_exec($ch1);        
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        $r2 = curl_exec($ch2);
        
//        transforma o xml em objeto
        $r = simplexml_load_string($r);
        $r1 = simplexml_load_string($r1);
        $r2 = simplexml_load_string($r2);
        
        $array['sedex']['preco'] = current($r->cServico->Valor);
        $array['sedex']['prazo'] = current($r->cServico->PrazoEntrega);
        $array['sedex']['codigo'] = current($r->cServico->Codigo);
        $array['sedex']['erro'] = current($r->cServico->Erro);
        
        $array['sedex10']['preco'] = current($r1->cServico->Valor);
        $array['sedex10']['prazo'] = current($r1->cServico->PrazoEntrega);
        $array['sedex10']['erro'] = current($r1->cServico->Erro);
        $array['sedex10']['codigo'] = current($r1->cServico->Codigo);
        
        $array['pac']['preco'] = current($r2->cServico->Valor);
        $array['pac']['prazo'] = current($r2->cServico->PrazoEntrega);
        $array['pac']['codigo'] = current($r2->cServico->Codigo);
        $array['pac']['erro'] = current($r2->cServico->Erro);
       
        return $array;
    }
}


