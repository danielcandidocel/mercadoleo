<?php
class categorias extends model {
    public function getList() {
        $array = array();
        
        $sql = "SELECT * FROM categorias ORDER BY sub DESC";
        $sql = $this->db->query($sql);
        
        if($sql->rowCount() > 0) {
            foreach($sql->fetchAll() as $item) {//para criar um campo no array de nome subs e inclir os valores
                $item['subs'] = array();
                $array[$item['id']] = $item;
            }
            while($this->aindaPrecisa($array)) {//enquanto retorna true 
                $this->organizarCategoria($array);
            }
        }
   
        return $array;
    }
    
    public function getNome($id) {
        $sql = "SELECT nome FROM categorias WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            return $sql['nome'];
        }
    }


    public function getCategoriasArvore($id) {
        $array = array();
        
        $filho = true;
        //enquanto $filho for true ($filho = se existe subcategoria)
        while($filho) {
            $sql = "SELECT * FROM categorias WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->execute();
            //se houve resultado, adiciona o resultado no array
            if($sql->rowCount() > 0) {
                $sql = $sql->fetch();
                $array[] = $sql;
                //verificar se ainda existe subcategorias
                if(!empty($sql['sub'])) {
                    //se existe pega o valor da sub e coloca no id para a nova verificaçã do while
                    $id = $sql['sub'];
                }else {
                    $filho = false;
                }
            }
        }
        $array = array_reverse($array);
        return $array;
    }


    private function organizarCategoria(&$array){ //simbolo &= se a variavel for alterada, altera também a variavel de origem
        foreach ($array as $id => $item){
            if(isset($array[$item['sub']])) {//se existe sub
                $array[$item['sub']]['subs'][$item['id']] = $item;//pega o item e coloca dentro do array sub
                unset($array[$id]);//deleta o item para ficar somente dentro do sub
                break;// para e volta na verificação se aindaPrecisa
            }
        }
    }


    private function aindaPrecisa($array) { //metodo para verificar se há algum sub em branco, retorno true ou false
     foreach($array as $item) {
         if(!empty($item['sub'])) {
             return true;
         }
     }
     return false;
    }
}
