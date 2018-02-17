<div class="container">
    <h1>Identificação</h1><hr>
    <div class="col-md-6 identify">
        <h3><strong>Não sou cliente</strong></h3><br>
        <h5>Faça o seu cadastro no site MercadoLeo e aproveite as vantagens em ser o nosso cliente.</h5><br>

        <h5><strong>Segurança:</strong> Site 100% seguro</h5><br>
        <div class="input">
            <input type="submit" onclick="cadastrar()" value="Cadastrar" class="button-logar2"/>
        </div>
        <hr style="margin-bottom: 0"/>
        <h5> <strong>Cadastre-se com o Facebook</strong></h5>
        <a href="<?php echo htmlspecialchars($loginurl);?>">
            <img src="<?php echo BASE_URL; ?>assets/images/facebook.png" alt=""/>       
        </a>
    </div>
    <div class="col-md-6 identify2">
        <form method="POST" action="<?php echo BASE_URL; ?>cliente/login">
            <h3> <strong>Já sou Cadastrado</strong></h3><br/>
            <strong>E-mail ou CPF (somente números):</strong><br/>
            <input type="text" name="login"/><br/><br/>
            <strong>Senha:</strong><br/>
            <input type="password" name="senha" />
            <h6><a href="<?php echo BASE_URL.'cliente/esqueci'; ?>">Esqueci minha senha</a></h6><br/>
            <input type="submit" value="Logar" class="button-logar2"/>
        </form>
        <hr style="margin-bottom: 0"/>
        <h5> <strong>Logar com o Facebook</strong></h5>
        <a href="<?php echo htmlspecialchars($loginurl);?>">
            <img src="<?php echo BASE_URL; ?>assets/images/facebook.png" alt=""/>       
        </a>
    </div>
    
</div>