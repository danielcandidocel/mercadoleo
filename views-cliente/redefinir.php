
<div class="esqueci">
    <?php if($retorno == 1):?>
    <h3><strong>Redefinir Senha</strong></h3><br/><br/>
    <form method="POST">
        <label>Digite a Nova Senha:</label>
        <input type="password" name="senha" id="name"/><br/><br/>
        <label>Repita a Nova Senha:</label>
        <input type="password" name="senha1" id="name"/><br/><br/>
        
        <input type="submit" value="Salvar" id="button" class="button-logar"/>
    </form>
    <?php elseif($retorno == 3): ?>
        <h2>Favor digitar senhas iguais!</h2><br>
        <input type="button" value="Voltar" class="button-logar" onClick="history.go(-1)">
    
    <?php  elseif ($retorno == 2):?>
        <h2>Senha Atualizada!</h2><br/><br/>
        <a href="<?php echo BASE_URL.'cliente/logar';?>" class="button-logar2">Logar</a>
    
    <?php elseif($retorno == 4):?>
        <h2>Token Inválido ou Expirado!</h2><br/><br/>
        <a href="<?php echo BASE_URL.'cliente/esqueci';?>" class="button-logar2">Reenviar Token</a>
    <?php endif; ?>
</div>