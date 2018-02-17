<?php

class widget extends model{
    
    public function dadosTemplate() {
        $dados = array();
        
        $cart = new carrinho();
        $produtos = new produtos();
        $categorias = new categorias();    
        
        $dados['categorias'] = $categorias->getList();//pega a lista das categorias e subcategorias

        $dados['widget_destaque2'] = $produtos->getListWidget(0, 5, array('destaque' =>'1'), true);
        $dados['widget_destaque1'] = $produtos->getListWidget(0, 3, array('destaque' =>'1'), true);//offset = 0, limit = 3, FIltro destaque = 1 e random = true        
        $dados['widget_promocao'] = $produtos->getListWidget(0, 3, array('promocao' =>'1'), true);//offset = 0, limit = 3, FIltro promocao = 1 e random = true
        $dados['widget_melhores'] = $produtos->getListWidget(0, 3, array('melhores' =>'1'), false);//offset = 0, limit = 3, FIltro promocao = 1  - não tem radom
        
//        Carrinho
        if(isset($_SESSION['cart'])){
            $qt = 0;
            foreach ($_SESSION['cart'] as $qtd){
                $qt += intval($qtd);
            }
            $dados['qt_carrinho'] = $qt;
        } else {
            $dados['carrinho'] = 0;
        }
       
        $dados['valor_carrinho'] = $cart->getSubTotal();
        return $dados;
    }
}

