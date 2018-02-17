<?php
class produtos extends model {
    
    public function getInfo($id) {
        $array = array();
        
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
            $imagens = current($this->getImage($id));
            $array['imagem'] = $imagens['url'];
        }
        
        return $array;
    }

    public function abrirProduto($slug) {
        $array = array();
        
        $sql = "SELECT id FROM produtos WHERE slug = :slug";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":slug", $slug);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
            $id = $array['id'];
                
            $sql = "SELECT *, (select marcas.nome from marcas where produtos.id_marca = marcas.id) as marca FROM produtos WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
            $array = $sql->fetch();

                foreach($array as $item) {//para cada item pegar todas as imagens do produtos
                    $array['imagens'] = $this->getImage($id);//pega as imagens pelo metodo getImage
                }            
            }
        }
        return $array;
    }

    public function getOpcoesProduto($slug) {
        $options = array();
        
        $sql = "SELECT id FROM produtos WHERE slug = :slug";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":slug", $slug);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
            $id = intval($array['id']); 
       
            $sql = "SELECT opcoes FROM produtos WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();
            
            if($sql->rowCount() > 0) {
                $options = $sql->fetch();
                $options = $options['opcoes'];
                 

                if(!empty($options)) {
                    $sql = "SELECT * FROM opcoes WHERE id IN (".$options.")";
                    $sql = $this->db->query($sql);
                    $options = $sql->fetchAll();
                 
                }
                
                $sql = "SELECT * FROM produtos_opcoes WHERE id_produto = :id";
                $sql = $this->db->prepare($sql);
                $sql->bindValue(":id", $id);
                $sql->execute();
                $optionsValor = array();
                if($sql->rowCount() > 0) {                    
                    foreach ($sql->fetchAll() as $op){             
                        $optionsValor[$op['id_opcoes']][] = $op['opcao'];                        
                    }
                

                foreach ($options as $ok => $op) {
                    if(isset($optionsValor[$op['id']])) {
                        $options[$ok]['opcao'] = $optionsValor[$op['id']];
                    } else {
                        $options[$ok]['opcao'] = '';
                    }           
                }   
                }
            }
        }
        return $options;
    }
    
    public function getReviews($slug, $qt) {
        $array = array();
        
        $sql = "SELECT id FROM produtos WHERE slug = :slug";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":slug", $slug);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
            $id = intval($array['id']);
            
            $sql = "SELECT *, (select usuarios.nome from usuarios where estrelas.id_user = usuarios.id) as cliente FROM estrelas WHERE id_produto = :id ORDER BY data DESC LIMIT ".$qt;
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id", $id);        
            $sql->execute();

            if($sql->rowCount() > 0) {
                $array = $sql->fetchAll();
            }
        }
        
        return $array;
    }

    public function getList($offset = 0, $limit = 3, $filtros = array()) { //Pegar a lista de produtos - todos os produtos
        //$offset = Inicio do resultado da lista dos produtos
        //$limit = quantidade a ser mostrada por pagina.
        
        $array = array();        
        if (!empty($filtros['categoria'])) {
            $sql = "SELECT id FROM categorias WHERE sub = :sub";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":sub", $filtros['categoria']);
            $sql->execute();
            if($sql->rowCount() > 0) {
                $array = $sql->fetchAll();        
                    foreach($array as $key => $id) {
                        $array[$key]['produto'] = $this->getProdutosCat($id['id'], $offset, $limit, $filtros);   
                    }
                   
                    
            } else {
                $sql = "SELECT * FROM categorias WHERE id = :sub";
                $sql = $this->db->prepare($sql);
                $sql->bindValue(":sub", $filtros['categoria']);
                $sql->execute();
                if($sql->rowCount() > 0) {
                $array = $sql->fetchAll();        
                    foreach($array as $key => $item) {
                        $array[$key]['produto'] = $this->getProdutosCat($item['id'], $offset, $limit, $filtros);     
                    }
                   
                }
            }
            
            } else {
                
                $array = $this->getProdutos($offset, $limit, $filtros);
              
            }
            
        return $array;
    }
    
    public function getTodosProdutos($offset, $limit, $filtros) {
        $array = array();
        $where = $this->buildWhere($filtros);
        $sql = "SELECT *, (select marcas.nome from marcas where produtos.id_marca = marcas.id) as marca FROM produtos WHERE ".implode(' AND ', $where)." LIMIT $offset, $limit";
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
        $array = $sql->fetchAll();
        
            foreach($array as $key => $item) {//para cada item pegar todas as imagens do produtos
                $array[$key]['imagens'] = $this->getImage($item['id']);//pega as imagens pelo metodo getImage
            }
        }
        return $array;
    }
    
    public function getProdutosCat($id, $offset, $limit, $filtros) {
        $array = array();
        $where = $this->buildWhereCat($filtros);
        $sql = "SELECT *, (select marcas.nome from marcas where produtos.id_marca = marcas.id) as marca FROM produtos WHERE ".implode(' AND ', $where)." LIMIT $offset, $limit";
        $sql = $this->db->prepare($sql);        
         $this->bindValueCat($filtros, $sql);
        $sql->execute();
         
        if($sql->rowCount() > 0) {
        $array = $sql->fetchAll();
        
            foreach($array as $ckey => $citem) {//para cada item pegar todas as imagens do produtos
                $array[$ckey]['imagens'] = $this->getImage($citem['id']);//pega as imagens pelo metodo getImage
            }
        }
        
        return $array;
    }
        public function getListWidget($offset, $limit, $filtros, $random) {
        $array = array();
        $orderBySQL = '';
        if($random == true) {
            $orderBySQL = "ORDER BY RAND()";
        }
        
        if(!empty($filtros['melhores'])) {
            $orderBySQL = "ORDER BY estrelas DESC";
        }
        
        $where = $this->buildWhere($filtros);
        $sql = "SELECT *, (select marcas.nome from marcas where produtos.id_marca = marcas.id) as marca FROM produtos WHERE ".implode(' AND ', $where)." ".$orderBySQL." LIMIT $offset, $limit";
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
        $array = $sql->fetchAll();
        
            foreach($array as $key => $item) {//para cada item pegar todas as imagens do produtos
                $array[$key]['imagens'] = $this->getImage($item['id']);//pega as imagens pelo metodo getImage
            }
        }
        return $array;
    }

    public function getProdutos($offset, $limit, $filtros) {
        $array = array();
              
        $where = $this->buildWhere($filtros);
        $sql = "SELECT *, (select marcas.nome from marcas where produtos.id_marca = marcas.id) as marca FROM produtos WHERE ".implode(' AND ', $where)." LIMIT $offset, $limit";
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        
        if($sql->rowCount() > 0) {
        $array = $sql->fetchAll();
        
            foreach($array as $key => $item) {//para cada item pegar todas as imagens do produtos
                $array[$key]['imagens'] = $this->getImage($item['id']);//pega as imagens pelo metodo getImage
            }
        }
        
        return $array;
    }

    public function getImage($id) {
        $array = array();
        
        $sql = "SELECT url FROM produtos_imagens WHERE id_produto = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }
        public function getTotalProdutosCat($filtros = array()) {
        $where = $this->buildWhereCat($filtros);
        
        $sql = "SELECT COUNT(*) as total_produtos FROM produtos WHERE ".implode(' AND ', $where);
        $sql = $this->db->prepare($sql);
        $this->bindValueCat($filtros, $sql);
        $sql->execute();
        
        $sql = $sql->fetch();
        
        return $sql['total_produtos'];
    }
    
    public function getTotalProdutos($filtros = array()) {
        $where = $this->buildWhere($filtros);
        
        $sql = "SELECT COUNT(*) as total_produtos FROM produtos WHERE ".implode(' AND ', $where);
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        $sql = $sql->fetch();
        
        return $sql['total_produtos'];
    }
    
    public function getListaMarcas($filtros = array()) {
        $array = array();
        
        $where = $this->buildWhere($filtros);
        $sql = "SELECT id_marca, COUNT(id) as qtde FROM produtos WHERE ".implode(' AND ', $where)." GROUP BY id_marca";
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        
        return $array;
    }
    
    public function getListaEstrelas($filtros = array()) {
        $array = array();
        
        $where = $this->buildWhere($filtros);
        $sql = "SELECT estrelas, COUNT(id) as qtde FROM produtos WHERE ".implode(' AND ', $where)." GROUP BY estrelas";
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        
        return $array;
    }
    
    public function getListaEstrelasCat($filtros = array()) {
        $array = array();
        
        $where = $this->buildWhere($filtros);
        $sql = "SELECT estrelas, COUNT(id) as qtde FROM produtos WHERE ".implode(' AND ', $where)." GROUP BY estrelas";
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        
        return $array;
    }
    
    public function getMaxPrice($filtros = array()) {
        $where = $this->buildWhere($filtros);
        $sql = "SELECT preco FROM produtos ORDER BY preco DESC LIMIT 1";
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            
            return $sql['preco'];
        } else {
            return '0';
        }
    }

    public function getMaxPriceCat($filtros = array()) {
    $where = $this->buildWhereCat($filtros);
    $sql = "SELECT preco FROM produtos ORDER BY preco DESC LIMIT 1";
    $sql = $this->db->prepare($sql);
    $this->bindValueCat($filtros, $sql);
    $sql->execute();
    
    if($sql->rowCount() > 0) {
        $sql = $sql->fetch();
        
        return $sql['preco'];
    } else {
        return '0';
    }
}
    
     public function getProdutosSale($filtros = array()) {
       $array = array();
        
        $where = $this->buildWhere($filtros);
        $sql = "SELECT COUNT(*) as qtde FROM produtos WHERE ".implode(' AND ', $where)." AND promocao = 1";
        $sql = $this->db->prepare($sql);
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }
        
        return $array;
    }
    
    public function getProdutosSaleCat($filtros = array()) {
       $array = array();
        
        $where = $this->buildWhereCat($filtros);
        $sql = "SELECT COUNT(*) as qtde FROM produtos WHERE ".implode(' AND ', $where)." AND promocao = '1'";
        $sql = $this->db->prepare($sql);
        $this->bindValueCat($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }
        
        return $array;
    }
    public function getOpcoes($filtros = array()) {        
        $opcoes = array();
        $ids = array();
        
        $where = $this->buildWhere($filtros);
        
        $sql = "SELECT id, opcoes FROM produtos WHERE ".implode(' AND ', $where);
        $sql = $this->db->prepare($sql);
        
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $produtos) {
                //cada produto pega o valor do campo opçoes e separa pela (,) virgula com explode
                $ops = explode(",", $produtos['opcoes']);
                $ids[] = $produtos['id'];
                //com as opçoes em $ops, armazenar em $opcoes o valor das opções sem repetir
                foreach ($ops as $op) {
                    if(!in_array($op, $opcoes)) {
                        $opcoes[] = $op;
                    }
                }
            }
        }
        
       $valores = $this->getValorOpcoes($opcoes, $ids);
       
       return $valores;
    }

     public function getOpcoesCat($filtros = array()) {        
        $opcoes = array();
        $ids = array();
        
        $where = $this->buildWhere($filtros);
        
        $sql = "SELECT id, opcoes FROM produtos WHERE ".implode(' AND ', $where);
        $sql = $this->db->prepare($sql);
        
        $this->bindValue($filtros, $sql);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $produtos) {
                //cada produto pega o valor do campo opçoes e separa pela (,) virgula com explode
                $ops = explode(",", $produtos['opcoes']);
                $ids[] = $produtos['id'];
                //com as opçoes em $ops, armazenar em $opcoes o valor das opções sem repetir
                foreach ($ops as $op) {
                    if(!in_array($op, $opcoes)) {
                        $opcoes[] = $op;
                    }
                }
            }
        }
        
       $valores = $this->getValorOpcoes($opcoes, $ids);
       
       return $valores;
    }
    
    private function getValorOpcoes($opcoes, $ids) {
        $array = array();
        
        foreach ($opcoes as $op) {
            $array[$op] = array(
                'nome' => $this->getNameOpcoes($op),
                'opcao' => array()
            );
        }
        
        $sql = "SELECT opcao, id_opcoes, COUNT(id) as qtde FROM produtos_opcoes WHERE id_opcoes IN ('".implode("','", $opcoes)."') AND id_produto IN ('".implode("','", $ids)."') GROUP BY opcao ORDER BY id_opcoes";
        $sql = $this->db->query($sql);
    
        
        if($sql->rowCount() > 0) {
        foreach ($sql->fetchAll() as $ops) {
            $array[$ops['id_opcoes']]['opcao'][] = array('valor'=>$ops['opcao'], 'qtde' =>$ops['qtde'], 'id' => $ops['id_opcoes']);
        }
        }
        
        return $array;
    }
    
    //função para pegar os nomes das opções do produto
    public function getNameOpcoes($id) {
        $sql = "SELECT nome FROM opcoes WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['nome'];
        }
    }

    private function buildWhere($filtros) {
         $where = array('1=1');
        
        if(!empty($filtros['categoria'])) {
            $where[] = "id_categoria = :id_categoria";
        }
        
        if(!empty($filtros['marca'])) {
            $where[] = "id_marca IN ('".implode("','", $filtros['marca'])."')";
        }
        
        if(!empty($filtros['star'])) {
            $where[] = "estrelas IN ('".implode("','", $filtros['star'])."')";
        }
        
        if(!empty($filtros['destaque'])) {
            $where[] = "destaque = '1'";
        }
        
        if(!empty($filtros['promocao'])) {
            $where[] = "promocao = '1'";
        }
        
        if(!empty($filtros['opcoes'])) {
            $where[] = "id IN(select id_produto from produtos_opcoes where produtos_opcoes.opcao IN('".implode("','", $filtros['opcoes'])."'))";
        }
        
        if(!empty($filtros['valor0'])) {
            $where[] = "preco >= :valor0";
        }
        
        if(!empty($filtros['valor1'])) {
            $where[] = "preco <= :valor1";
        }
        
                
        if(!empty($filtros['busca'])) {
            $where[] = "descricao LIKE :busca";
        }
        
        return $where;
    }
    private function bindValue($filtros, &$sql) {     
        if(!empty($filtros['categoria'])) {
            $sql->bindValue(":id_categoria", $filtros['categoria']);
        }
        
        if(!empty($filtros['valor0'])) {
            $sql->bindValue(":valor0", $filtros['valor0']);
        }
        
        if(!empty($filtros['valor1'])) {
            $sql->bindValue(":valor1", $filtros['valor1']);
        }
        
        if(!empty($filtros['busca'])) {
            $sql->bindValue(":busca", '%'.$filtros['busca'].'%');
        }
    }
    
        private function buildWhereCat($filtros) {
         $where = array('1=1');
        
        if(!empty($filtros['categoria'])) {
            $where[] = "id_categoria = :id_categoria";
        }
        
        if(!empty($filtros['marca'])) {
            $where[] = "id_marca IN ('".implode("','", $filtros['marca'])."')";
        }
        
        if(!empty($filtros['filtros']['star'])) {
            $where[] = "estrelas IN ('".implode("','", $filtros['filtros']['star'])."')";
        }
        
        if(!empty($filtros['destaque'])) {
            $where[] = "destaque = '1'";
        }
        
        if(!empty($filtros['filtros']['promocao'])) {
            $where[] = "promocao = '1'";
        }
        
        if(!empty($filtros['filtros']['opcoes'])) {
            $where[] = "id IN(select id_produto from produtos_opcoes where produtos_opcoes.opcao IN('".implode("','", $filtros['filtros']['opcoes'])."'))";
        }
        
        if(!empty($filtros['filtros']['valor0'])) {
            $where[] = "preco >= :valor0";
        }
        
        if(!empty($filtros['filtros']['valor1'])) {
            $where[] = "preco <= :valor1";
        }
        
                
        if(!empty($filtros['busca'])) {
            $where[] = "descricao LIKE :busca OR nome LIKE :busca";
        }
        
        return $where;
    }
    private function bindValueCat($filtros, &$sql) {     
        if(!empty($filtros['categoria'])) {
            $sql->bindValue(":id_categoria", $filtros['categoria']);
        }
        
        if(!empty($filtros['filtros']['valor0'])) {
            $sql->bindValue(":valor0", $filtros['filtros']['valor0']);
        }
        
        if(!empty($filtros['filtros']['valor1'])) {
            $sql->bindValue(":valor1", $filtros['filtros']['valor1']);
        }
        
        if(!empty($filtros['busca'])) {
            $sql->bindValue(":busca", '%'.$filtros['busca'].'%');
        }
    }
}
