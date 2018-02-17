
<div class="esqueci">
    <?php if($retorno == 1):?>
    <h3><strong>Dejesa Realmente Cancelar a Conta?</strong></h3><br/><br/>
 
    <form method="POST">
        <input type="hidden" value="<?php echo $email;?>" name="email"/>
        <input type="submit" value="SIM" class="button-logar" />
        <a href="<?php echo BASE_URL.'perfil/meus_dados'?>" class="button-nao">NÃO</a>
        
</form>
    <?php  elseif ($retorno == 2):?>
        <h2>Conta Cancelada!</h2><br/><br/>
        <a href="<?php echo BASE_URL;?>" class="button-logar">Pagina Inicial</a>
    <?php endif; ?>
</div>