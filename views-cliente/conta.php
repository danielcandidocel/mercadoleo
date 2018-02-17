
    <div class="col-md-3">
        <div class=" col-md-12 menu-account">
            
            <a href="<?php echo BASE_URL?>cliente/sair"><span id="sair">Sair</span></a>
                <div class="perfil">
                    <div class="imagem">
                        <div class="editarFoto">
                            <button onclick="abrir_editar_foto()" class="btn_editarFoto">Editar</button>
                        </div>
                        <img src="<?php echo BASE_URL;?>assets/images/perfil/user.png" />                           
                    </div>
                    <h5>Olá <strong><?php echo $nome;?></strong></h5>                   
                </div>
                <ul>
                <li class="active"><a href="<?php echo BASE_URL?>perfil/meus_dados">Meus Dados</a></li>
                <li><a href="<?php echo BASE_URL?>perfil/enderecos">Meus Endereços</a></li>
                <li><a href="<?php echo BASE_URL?>perfil/cartoes">Meus Cartões</a></li>
                <li><a href="<?php echo BASE_URL?>perfil/pedidos">Meus Pedidos</a></li>
            </ul>
        </div>
    </div>

<!--Modal Editar Foto-->
<div id="editar_foto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center">
                <h3>Editar Foto:</h3><br/><br/>
                <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL?>perfil/addFoto">
                    <input type="hidden" name="id" value="<?php echo $dados['id'];?>" />
                    <input type="file" name="foto-perfil" /><br/><br/>
                    <input type="submit" value="Enviar" class="button-logar" />
               
                    <button class="button-nao" onclick="fecharfoto()">Sair</button>
                </form>
            </div>
        </div>
    </div>
</div>