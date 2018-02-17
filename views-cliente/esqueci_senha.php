
<div class="esqueci">
    <?php if($retorno == 1):?>
    <h3><strong>Redefinir Senha</strong></h3><br/><br/>
    <form method="POST">
        <label>Digite seu E-mail:</label>
        <input type="email" name="email" id="name"/><br/><br/><br/>
        
        <input type="submit" value="Enviar" id="button" class="button-logar"/>
    </form>
    <?php elseif($retorno == 3): ?>
    <h2>E-mail não cadastrado</h2><br/>
    <a href="<?PHP echo BASE_URL.'cliente\esqueci';?>"><input type="button" class="button-logar" value="Voltar" /></a>
    <?php  elseif ($retorno == 2):?>
    <h2>Verifique seu email</h2> <br/>
<a href="<?PHP echo BASE_URL;?>"><input type="button" class="button-logar" value="Home" /></a>
    <?php endif; ?>
</div>
