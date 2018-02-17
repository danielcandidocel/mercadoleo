<div class="esqueci">
    <?php if($retorno == 1):?>
    <h3><strong>E-mail e/ou Senha Incorretos!</strong></h3><br/><br/>
 
 
        <a href="<?php echo BASE_URL.'cliente/logar'?>" class="button-logar2">Logar</a>
        <a href="<?php echo BASE_URL.'cliente/cadastrar'?>" class="button-logar2">Cadastrar</a>

    <?php  elseif ($retorno == 2):?>
        <h2>E-mail Encontrado na Base de Dados!</h2><br/><br/>
        <a href="<?php echo BASE_URL."cliente/esqueci";?>" class="button-logar">Reativar a Conta</a>
    <?php endif; ?>
</div>
