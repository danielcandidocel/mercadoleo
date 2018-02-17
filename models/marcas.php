<?php

class marcas extends model{
    
    public function getList(){
        $array = array();

        $sql = "SELECT * FROM marcas ORDER BY nome ASC";
        $sql = $this->db->query($sql);

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;
    }
}

