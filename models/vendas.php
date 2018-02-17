<?php
class vendas extends model {

    public function novaVenda($id_cliente, $total, $tipo, $id_endereco, $id_cartao, $id_cupom, $totalFrete2) {
        $date = date("Y-m-d H:i:s");
        $prazo2 = $_SESSION['prazoFrete'] + 1;
        $date2 = date("Y-m-d", strtotime("+".$prazo2." days"));
        
        $prazo = $date2;
        $sql = "INSERT INTO vendas (id_cliente, total_compra, frete, prazo, data_compra, tipo_pagamento, status_pagamento) VALUES (:id_cliente, :total, :frete, :prazo, :data, :tipo, 1)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_cliente", $id_cliente);
        $sql->bindValue(":data", $date);
        $sql->bindValue(":total", $total);
        $sql->bindValue(":frete", $totalFrete2);
        $sql->bindValue(":prazo", $prazo);
        $sql->bindValue(":tipo", $tipo);
        $sql->execute();
        
        $id_venda = $this->db->lastInsertId();
        $n = intval(100000+$id_venda);        
        $data = intval(date("Y").date("m").date("d"));
        $pedido = $data.'345'.$n;
     
        $sql = "INSERT INTO pedidos SET pedido = :pedido, data = :data, id_cliente = :id_cliente, id_venda = :id_venda, id_endereco = :id_endereco, forma_de_pagamento = :formapg, id_cartao = :id_cartao, id_cupom = :id_cupom";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":pedido", $pedido);
        $sql->bindValue(":data", $date);
        $sql->bindValue(":id_cliente", $id_cliente);
        $sql->bindValue(":id_venda", $id_venda);
        $sql->bindValue(":id_endereco", $id_endereco);
        $sql->bindValue(":formapg", $tipo);
        $sql->bindValue(":id_cartao", $id_cartao);
        $sql->bindValue(":id_cupom", $id_cupom);
        $sql->execute();
        
        return  $id_venda;
    }
    
    public function addItem($id_venda, $id_produto, $qt_produto, $valor_produto) {
        
        $sql = "INSERT INTO venda_produto (id_venda, id_produto, valor_produto, quantidade) VALUES (:id_venda, :id_produto, :valor_produto, :quantidade)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_venda", $id_venda);
        $sql->bindValue(":id_produto", $id_produto);
        $sql->bindValue(":valor_produto", $valor_produto);
        $sql->bindValue(":quantidade", $qt_produto);
        $sql->execute();
        
    }
    
    public function setPaid($id) {
        $date = date("Y-m-d H:i:s");
        $sql = "UPDATE vendas SET status_pagamento = :status_pagamento, pagamento_confirmado = :pagamento_confirmado WHERE id =:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":status_pagamento", '3');
        $sql->bindValue(":pagamento_confirmado", $date);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
    
     public function updateBillet($id, $link) {
        
        $sql = "UPDATE vendas SET link_boleto = :link WHERE id =:id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":link", $link);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}


