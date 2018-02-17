<?php
class cliente extends model {
    
    public function consultar($id){
        $array = array();
        
        $sql = $this->db->prepare ("SELECT * FROM clientes WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
            
            $sql = $this->db->prepare ("SELECT * FROM enderecos_cliente WHERE id_cliente = :id AND entrega = 1 AND excluir = 0");
            $sql->bindValue(":id", $id);
            $sql->execute();
            
            if ($sql->rowCount() > 0) {
                $array['endereco'] = $sql->fetch();
            }
            
            $sql = $this->db->prepare ("SELECT * FROM cartoes_cliente WHERE id_cliente = :id AND principal = 1");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $array['cartao'] = $sql->fetch();
            }
            
            
        }
        
        return $array;
    }
    
    public function cancelar($id) {
        
        $sql = "UPDATE clientes SET excluir = 1 WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function addPF ($nome, $data_nasc, $sexo, $cep, $rua, $numero, $bairro, $complemento, $cidade, $estado, $telefone, $celular, $email, $senha, $newsletter, $cpf, $cnpj) {
        
        $sql = $this->db->prepare("INSERT INTO clientes SET nome = :nome, dt_nascimento = :dt_nascimento, sexo = :sexo, cpf = :cpf, cnpj = :cnpj, tel = :telefone, cel = :celular, email = :email, senha = :senha, newsletter = :newsletter, excluir = 0, foto = user.png");
        $sql->bindValue(":nome", $nome);  
        $sql->bindValue(":dt_nascimento", $data_nasc);
        $sql->bindValue(":sexo", $sexo);
        $sql->bindValue(":cpf", $cpf);
        $sql->bindValue(":cnpj", $cnpj);   
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":celular", $celular);        
        $sql->bindValue(":email", $email);  
        $sql->bindValue(":senha", MD5($senha));
        $sql->bindValue(":newsletter", $newsletter);
        $sql->execute();
        
        $lastID = $this->db->lastInsertId();
        
        $sql = $this->db->prepare("INSERT INTO enderecos_cliente SET id_cliente = :id_cliente, cep = :cep, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, estado = :estado, cidade = :cidade, entrega = 1, excluir = 0");
        $sql->bindValue(":id_cliente", $lastID);
        $sql->bindValue(":cep", $cep);
        $sql->bindValue(":rua", $rua);
        $sql->bindValue(":numero", $numero);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":bairro", $bairro);
        $sql->bindValue(":estado", $estado);
        $sql->bindValue(":cidade", $cidade);        
        $sql->execute();
    }
    
        public function addPJ ($razao, $responsavel, $cep, $rua, $numero, $bairro, $complemento, $cidade, $estado, $telefone, $celular, $email, $senha, $newsletter, $cpf, $cnpj) {
        
        $sql = $this->db->prepare("INSERT INTO clientes SET nome = :nome, responsavel = :responsavel, cpf = :cpf, cnpj = :cnpj, tel = :telefone, cel = :celular, email = :email, senha = :senha, newsletter = :newsletter, excluir = 0, fotos = user.png");
        $sql->bindValue(":nome", $razao); 
        $sql->bindValue(":responsavel", $responsavel);
        $sql->bindValue(":cpf", $cpf);
        $sql->bindValue(":cnpj", $cnpj);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":celular", $celular);        
        $sql->bindValue(":email", $email);  
        $sql->bindValue(":senha", MD5($senha));
        $sql->bindValue(":newsletter", $newsletter);
        $sql->execute();
        
        $lastID = $this->db->lastInsertId();
        
        $sql = $this->db->prepare("INSERT INTO enderecos_cliente SET id_cliente = :id_cliente, cep = :cep, rua = :rua, numero = :numero, complemento = :complemento, bairro = :bairro, estado = :estado, cidade = :cidade, entrega = 1, excluir = 0");
        $sql->bindValue(":id_cliente", $lastID);
        $sql->bindValue(":cep", $cep);
        $sql->bindValue(":rua", $rua);
        $sql->bindValue(":numero", $numero);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":bairro", $bairro);
        $sql->bindValue(":estado", $estado);
        $sql->bindValue(":cidade", $cidade);        
        $sql->execute();
    }

    public function pesquisarCPF($cpf) {
        $sql = $this->db->prepare("SELECT id FROM clientes WHERE cpf = :cpf");
        $sql->bindValue(":cpf", $cpf);        
        $sql->execute();

        if($sql->rowCount() > 0) {                
                return true;
        } else {
                return false;

        }
    }
    
    public function pesquisarCNPJ($cnpj) {
        $sql = $this->db->prepare("SELECT id FROM clientes WHERE cnpj = :cnpj");
        $sql->bindValue(":cnpj", $cnpj);        
        $sql->execute();

        if($sql->rowCount() > 0) {                
                return true;
        } else {
                return false;

        }
    }
    public function pesquisarEmail($email) {
        $sql = $this->db->prepare("SELECT id FROM clientes WHERE email = :email AND excluir = 0");
        $sql->bindValue(":email", $email);        
        $sql->execute();

        if($sql->rowCount() > 0) {                
                return true;
        } else {
                return false;

        }
    }
    
    public function pesquisarEmailCliente($id, $email) {
        $sql = $this->db->prepare("SELECT * FROM clientes WHERE id = :id AND email = :email");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":email", $email);                        
        $sql->execute();

        if($sql->rowCount() > 0) {                
                return true;
        } else {
                return false;

        }
    }
    
    public function editar($id, $nome, $email, $data_nasc, $sexo, $responsavel, $tel, $cel) {
        $sql = $this->db->prepare("UPDATE clientes SET nome = :nome, dt_nascimento = :dt_nascimento, sexo = :sexo, responsavel = :responsavel, tel = :tel, cel = :cel, email = :email WHERE id = :id");
        $sql->bindValue(":nome", $nome);  
        $sql->bindValue(":dt_nascimento", $data_nasc);
        $sql->bindValue(":sexo", $sexo);  
        $sql->bindValue(":responsavel", $responsavel);
        $sql->bindValue(":tel", $tel);
        $sql->bindValue(":cel", $cel);        
        $sql->bindValue(":email", $email);
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        return true;
    }
    
    public function cadastrarCartao($id_cliente, $cartao, $bandeira, $titular, $cpf, $cvv, $mes_venc, $ano_venc, $principal) {
        if($principal == 1){
            $princ = 0;
            $sql = $this->db->prepare("UPDATE cartoes_cliente SET principal = :principal WHERE id_cliente = :id_cliente");
            $sql->bindValue(":principal", $princ);  
            $sql->bindValue(":id_cliente", $id_cliente);
            $sql->execute();
            
            $sql = $this->db->prepare("INSERT INTO cartoes_cliente SET id_cliente = :id_cliente, titular = :titular, cpf = :cpf, numero = :cartao, cvv = :cvv, validade_mes = :mes_venc, validade_ano = :ano_venc, bandeira = :bandeira, principal = :principal, excluir = 0");
            $sql->bindValue(":id_cliente", $id_cliente); 
            $sql->bindValue(":titular", $titular);
            $sql->bindValue(":cpf", $cpf);
            $sql->bindValue(":cvv", $cvv);
            $sql->bindValue(":cartao", $cartao);
            $sql->bindValue(":mes_venc", $mes_venc);        
            $sql->bindValue(":ano_venc", $ano_venc);  
            $sql->bindValue(":bandeira", $bandeira);
            $sql->bindValue(":principal", $principal);
            $sql->execute();

            return true;
            } else {
            
            $sql = $this->db->prepare("INSERT INTO cartoes_cliente SET id_cliente = :id_cliente, titular = :titular, cpf = :cpf, numero = :cartao, cvv = :cvv, validade_mes = :mes_venc, validade_ano = :ano_venc, bandeira = :bandeira, principal = :principal, excluir = 0");
            $sql->bindValue(":id_cliente", $id_cliente); 
            $sql->bindValue(":titular", $titular);
            $sql->bindValue(":cpf", $cpf);
            $sql->bindValue(":cvv", $cvv);
            $sql->bindValue(":cartao", $cartao);
            $sql->bindValue(":mes_venc", $mes_venc);        
            $sql->bindValue(":ano_venc", $ano_venc);  
            $sql->bindValue(":bandeira", $bandeira);
            $sql->bindValue(":principal", $principal);
            $sql->execute();
            return true;
            }
    }
    
    public function excluirCartao ($id) {
        
        $sql = $this->db->prepare("UPDATE cartoes_cliente SET excluir = 1 WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function editarCartao($id_cliente, $id, $cartao, $bandeira, $titular, $cpf, $cvv, $mes_venc, $ano_venc, $principal){
            
            if($principal == 1){
            $princ = 0;
            $sql = $this->db->prepare("UPDATE cartoes_cliente SET principal = :principal WHERE id_cliente = :id_cliente");
            $sql->bindValue(":principal", $princ);  
            $sql->bindValue(":id_cliente", $id_cliente);
            $sql->execute();
        
            $sql = $this->db->prepare("UPDATE cartoes_cliente SET titular = :titular, cpf = :cpf, numero = :cartao, cvv = :cvv, validade_mes = :mes_venc, validade_ano = :ano_venc, bandeira = :bandeira, principal = :principal WHERE id = :id");
            $sql->bindValue(":id", $id); 
            $sql->bindValue(":titular", $titular);
            $sql->bindValue(":cpf", $cpf);
            $sql->bindValue(":cvv", $cvv);
            $sql->bindValue(":cartao", $cartao);
            $sql->bindValue(":mes_venc", $mes_venc);        
            $sql->bindValue(":ano_venc", $ano_venc);  
            $sql->bindValue(":bandeira", $bandeira);
            $sql->bindValue(":principal", $principal);
            $sql->execute();

            return true;
            } else {
                $sql = $this->db->prepare("UPDATE cartoes_cliente SET titular = :titular, cpf = :cpf, numero = :cartao, cvv = :cvv, validade_mes = :mes_venc, validade_ano = :ano_venc, bandeira = :bandeira, principal = :principal WHERE id = :id");
            $sql->bindValue(":id", $id); 
            $sql->bindValue(":titular", $titular);
            $sql->bindValue(":cpf", $cpf);
            $sql->bindValue(":cvv", $cvv);
            $sql->bindValue(":cartao", $cartao);
            $sql->bindValue(":mes_venc", $mes_venc);        
            $sql->bindValue(":ano_venc", $ano_venc);  
            $sql->bindValue(":bandeira", $bandeira);
            $sql->bindValue(":principal", $principal);
            $sql->execute();
            return true;
            }            
    }

    public function cadastrarEndereco($id_cliente, $cep, $rua, $numero, $complemento, $bairro, $cidade, $estado, $endereco_principal) {
        
        if($endereco_principal == 1){
            $entrega = 0;
            $sql = $this->db->prepare("UPDATE enderecos_cliente SET entrega = :entrega WHERE id_cliente = :id_cliente");
            $sql->bindValue(":entrega", $entrega);  
            $sql->bindValue(":id_cliente", $id_cliente);
            $sql->execute();

            $sql = $this->db->prepare("INSERT INTO enderecos_cliente SET id_cliente = :id_cliente, cep = :cep, rua = :rua, numero = :numero, bairro = :bairro, complemento = :complemento, cidade = :cidade, estado = :estado, entrega = :entrega, excluir = 0");
            $sql->bindValue(":id_cliente", $id_cliente); 
            $sql->bindValue(":cep", $cep);
            $sql->bindValue(":rua", $rua);
            $sql->bindValue(":numero", $numero);
            $sql->bindValue(":bairro", $bairro);
            $sql->bindValue(":complemento", $complemento);        
            $sql->bindValue(":cidade", $cidade);  
            $sql->bindValue(":estado", $estado);
            $sql->bindValue(":entrega", $endereco_principal);
            $sql->execute();

            return true;
          } else {
              $sql = $this->db->prepare("INSERT INTO enderecos_cliente SET id_cliente = :id_cliente, cep = :cep, rua = :rua, numero = :numero, bairro = :bairro, complemento = :complemento, cidade = :cidade, estado = :estado, entrega = :entrega, excluir = 0");
            $sql->bindValue(":id_cliente", $id_cliente); 
            $sql->bindValue(":cep", $cep);
            $sql->bindValue(":rua", $rua);
            $sql->bindValue(":numero", $numero);
            $sql->bindValue(":bairro", $bairro);
            $sql->bindValue(":complemento", $complemento);        
            $sql->bindValue(":cidade", $cidade);  
            $sql->bindValue(":estado", $estado);
            $sql->bindValue(":entrega", $endereco_principal);
            $sql->execute();
            
            return true;
          }
    }
    
    public function editarEndereco($id_cliente, $id, $cep, $rua, $numero, $complemento, $bairro, $cidade, $estado, $endereco_principal){
        if($endereco_principal == 1){
            $entrega = 0;
            $sql = $this->db->prepare("UPDATE enderecos_cliente SET entrega = :entrega WHERE id_cliente = :id_cliente");
            $sql->bindValue(":entrega", $entrega); 
            $sql->bindValue(":id_cliente", $id_cliente);
            $sql->execute();
            
            $sql = $this->db->prepare("UPDATE enderecos_cliente SET cep = :cep, rua = :rua, numero = :numero, bairro = :bairro, complemento = :complemento, cidade = :cidade, estado = :estado, entrega = :entrega WHERE id = :id");
            $sql->bindValue(":id", $id); 
            $sql->bindValue(":cep", $cep);
            $sql->bindValue(":rua", $rua);
            $sql->bindValue(":numero", $numero);
            $sql->bindValue(":bairro", $bairro);
            $sql->bindValue(":complemento", $complemento);        
            $sql->bindValue(":cidade", $cidade);  
            $sql->bindValue(":estado", $estado);
            $sql->bindValue(":entrega", $endereco_principal);
            $sql->execute();

            return true;
        } else {
            $sql = $this->db->prepare("UPDATE enderecos_cliente SET cep = :cep, rua = :rua, numero = :numero, bairro = :bairro, complemento = :complemento, cidade = :cidade, estado = :estado, entrega = :entrega WHERE id = :id");
            $sql->bindValue(":id", $id); 
            $sql->bindValue(":cep", $cep);
            $sql->bindValue(":rua", $rua);
            $sql->bindValue(":numero", $numero);
            $sql->bindValue(":bairro", $bairro);
            $sql->bindValue(":complemento", $complemento);        
            $sql->bindValue(":cidade", $cidade);  
            $sql->bindValue(":estado", $estado);
            $sql->bindValue(":entrega", $endereco_principal);
            $sql->execute();

            return true;
        }
    }
    
    public function excluirEndereco ($id) {
        
        $sql = $this->db->prepare("UPDATE enderecos_cliente SET excluir = 1 WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        return true;
    }
    
    public function login($login, $senha) {
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM clientes WHERE email = :login AND senha = :senha OR cpf = :login AND senha = :senha OR cnpj = :login AND senha = :senha");
        $sql->bindValue(":login", $login);
        $sql->bindValue(":senha",MD5($senha));
        $sql->execute();

        if($sql->rowCount() > 0) {
                $dado = $sql->fetch();
                
                if($dado['excluir'] == 0){
                    $_SESSION['ML_login'] = $dado['id'];
                    $_SESSION['nome'] = $dado['nome'];
                    $array = $dado;
                    $array['excluir'] = 0;
                } elseif($dado['excluir'] == 1){
                    $array['excluir'] = 1;
                }
                
        } else {
                $array['excluir'] = 2;
        }
        return $array;
    } 
    
    public function getDadosCliente($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM clientes WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }
        
        return $array;
        
    }
    
     public function getEnderecoCliente($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM enderecos_cliente WHERE id_cliente = :id AND excluir = 0 ORDER BY entrega DESC");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
       
        return $array;
        
    }
    
    public function getCartao($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM cartoes_cliente WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
       
        return $array;
        
    }
    public function getEnderecos($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM enderecos_cliente WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
       
        return $array;
        
    }
    
    public function getCartoesCliente($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM cartoes_cliente WHERE id_cliente = :id AND excluir = 0 ORDER BY principal DESC");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
              
        return $array;
        
    }
    
    public function getEmail($email) {
        
        $sql = $this->db->prepare("SELECT * FROM clientes WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
    
    public function esqueciSenha($email){
        
        $sql = $this->db->prepare("SELECT * FROM clientes WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $id = $sql['id'];
            
            $token = md5(time().rand(0, 999).rand(0, 999));
            
            $sql = "INSERT INTO cliente_token SET id_usuario = :id, codigo = :token, expirado_em = :expirado_em";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->bindValue(":token", $token);
            $sql->bindValue(":expirado_em", date('Y-m-d H:i', strtotime('+2 Hours')));
            $sql->execute();
            
            return $token;
        }
    }
    
    public function verificarToken($token) {
        
        $sql = "SELECT * FROM cliente_token WHERE codigo = :codigo AND usado = 0 AND expirado_em > NOW()";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":codigo", $token);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $id = $sql['id_usuario'];
        } else {
            $id = 0;
        }
        return $id;
    }
    
    public function atualizarSenha($id, $senha, $token) {
        
        $sql = "UPDATE clientes SET senha = :senha WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":senha", MD5($senha));
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        $sql = "UPDATE cliente_token SET usado = 1 WHERE codigo = :codigo";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":codigo", $token);        
        $sql->execute();
        
    }
    
    public function getPedidos($id){
        $array = array();
        
        $sql = $this->db->prepare("SELECT *, (select vendas.total_compra from vendas where pedidos.id_venda = vendas.id) as valor, (select vendas.status_pagamento from vendas where pedidos.id_venda = vendas.id) as status FROM pedidos WHERE id_cliente = :id ORDER BY data DESC");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
              
        return $array;
    }
    
    public function pedido($id){
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM pedidos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
              
        return $array;
    }
    
    public function endereco($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM enderecos_cliente WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
       
        return $array;
        
    }
    public function dadosVendas($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT id_venda FROM pedidos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $id_venda = $sql->fetch();
            
            $sql = $this->db->prepare("SELECT * FROM vendas WHERE id = :id");
            $sql->bindValue(":id", $id_venda[0]);
            $sql->execute();
            
            if($sql->rowCount() > 0) {
                $array = $sql->fetchAll();
            }
        }
        
        return $array;
    }
    public function dadosCartoes($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT id_cartao FROM pedidos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $id_venda = $sql->fetch();
            
            $sql = $this->db->prepare("SELECT * FROM cartoes_cliente WHERE id = :id");
            $sql->bindValue(":id", $id_venda[0]);
            $sql->execute();
            
            if($sql->rowCount() > 0) {
                $array = $sql->fetchAll();
            }
        }
        
        return $array;
    }
    
    public function dadosProdutos($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT id_venda FROM pedidos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $id_venda = $sql->fetch();
            
            $sql = $this->db->prepare("SELECT *, (select produtos.nome from produtos where venda_produto.Id_produto = produtos.id) as nome, (select produtos_imagens.url from produtos_imagens where venda_produto.Id_produto = produtos_imagens.id_produto limit 1) as imagem FROM venda_produto WHERE id_venda = :id");
            $sql->bindValue(":id", $id_venda[0]);
            $sql->execute();
            
            if($sql->rowCount() > 0) {
                $array = $sql->fetchAll();
            }
        }
        
        return $array;
    }
    
    public function emailPedido($id_venda){
        $sql = $this->db->prepare("SELECT pedido FROM pedidos WHERE id_venda = :id");
        $sql->bindValue(":id", $id_venda);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $protocolo =  $sql->fetch();
            return $protocolo[0];
        }
    }
    
//    public function dadosProdutos2($id) {
//        $array = array();
//        
//        $sql = $this->db->prepare("SELECT id_venda FROM pedidos WHERE id = :id");
//        $sql->bindValue(":id", $id);
//        $sql->execute();
//        
//        if($sql->rowCount() > 0) {
//            $id_venda = $sql->fetch();
//            
//            $sql = $this->db->prepare("SELECT * FROM venda_produto WHERE id_venda = :id");
//            $sql->bindValue(":id", $id_venda[0]);
//            $sql->execute();
//            
//            if($sql->rowCount() > 0) {
//                $produto = $sql->fetch();
//                $id_produto = $produto['Id_produto'];
//                
//                $sql = $this->db->prepare("SELECT url FROM produtos_imagens WHERE id_produto = :id");
//                $sql->bindValue(":id", $id_produto[0]);
//                $sql->execute();
//                
//                if($sql->rowCount() > 0) {
//                    $array = $sql->fetchAll();
//                }
//            }
//        }
//        
//        return $array;
//    }
}


