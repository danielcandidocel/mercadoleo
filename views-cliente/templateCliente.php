﻿<!DOCTYPE html>
<html>
<head><link rel="apple-touch-icon" sizes="57x57" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo BASE_URL; ?>assets/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo BASE_URL; ?>assets/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo BASE_URL; ?>assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo BASE_URL; ?>assets/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL; ?>assets/favicon/favicon-16x16.png">

<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo BASE_URL; ?>assets/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<meta charset="utf8" />
<title>Mercado Leo</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style_account.css" type="text/css" />
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.maskedinput-1.1.4.pack.js"/></script>

</head>
<body>
<nav id="nav" class="navbar topnav">
    <div class="container">
        <ul class="nav navbar-nav">
            <li class="logo">
                <a href="<?php echo BASE_URL; ?>" style="background-color: transparent">
                    <img src="<?php echo BASE_URL; ?>assets/images/mercadoleo-logo-account.png" />
                </a>
            </li>
            
        </ul>
        <ul class="nav navbar-nav navbar-right">
<!--            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php $this->lang->get('LANGUAGE'); ?>
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo BASE_URL; ?>lang/set/en">English</a></li>
                    <li><a href="<?php echo BASE_URL; ?>lang/set/pt-br">Português</a></li>
                </ul>
            </li>-->
           <?php if (isset($_SESSION['ML_login'])) :?>
            <li class="login">
                
                <h5>Olá <strong><?php echo $viewData['nome'];?></strong></h5>
                
            </li>
        <?php endif; ?>
            <li class="cart">
                <a style="background-color: transparent" href="<?php echo BASE_URL; ?>cart">
                        <div class="cartarea2">
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                            <div class="cartqt2">
                                <?PHP echo (isset($viewData['qt_carrinho']))?$viewData['qt_carrinho']:'0';?>
                            </div>
                        </div>
                      
                        
                </a>
            </li>
        </ul>
    </div>
</nav>
<header>
<!-- Cabeçalho -->

</header>	

<div class="container home">
        <div class="row">
<!--chamando os views das paginas-->
          <div class="container-fluid account"><?php $this->loadViewInTemplateCliente($viewName, $viewData); ?></div>
        </div>
</div>

<footer>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="widget">
                <h1><?php $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
                <div class="widget_body">
                    <?php $this->loadView('widget_item', array('list'=>$viewData['widget_destaque1'])); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="widget">
                <h1><?php $this->lang->get('ONSALEPRODUCTS'); ?></h1>
                <div class="widget_body">
                     <?php $this->loadView('widget_item', array('list'=>$viewData['widget_promocao'])); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="widget">
                <h1><?php $this->lang->get('TOPRATEDPRODUCTS'); ?></h1>
                <div class="widget_body">
                    <?php $this->loadView('widget_item', array('list'=>$viewData['widget_melhores'])); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Newsletter -->	    	
<div class="subarea">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
                <form method="POST">
                <input class="subemail" name="email" placeholder="<?php $this->lang->get('SUBSCRIBETEXT'); ?>">
                <input type="submit" value="<?php $this->lang->get('SUBSCRIBEBUTTON'); ?>" />
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Rodapé Links -->
<div class="links">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <a href="<?php echo BASE_URL; ?>"><img width="150" src="<?php echo BASE_URL; ?>assets/images/mercadoleo-logo.png" /></a><br/><br/>
                    <div class="col-sm-9" style="padding: 0"><h6>Mercado Leo é uma empresa do grupo Lany Tecnologia IND. e COM. de Art. de Informática Ltda - ME<br/><br/>
                            CNPJ: 19.108.581/0001/08<br/><br/>
                            Rua Donato Caruso Filho, 151 - Jd Regis - São Paulo/SP CEP 04811-180</h6>
                        </div>
                    
                </div>
                
            </div>
            <div class="col-sm-9 linkgroups" style="margin-top: 5%;">
                <div class="row">
                    <div class="col-sm-4">
                        <h3><?php $this->lang->get('INSTITUTIONAL'); ?></h3>
                        <ul>
                            <li><a href="#">Sobre Mercado Leo</a></li>
                            <li><a href="#">Fale Conosco</a></li>
                            <li><a href="#">Mapa do Site</a></li>
                            <li><a href="#">Trabalhe Conosco</a></li>
                            
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <h3><?php $this->lang->get('DOUBTS'); ?></h3>
                        <ul>
                            <li><a href="#">Sobre o Cadastro</a></li>
                            <li><a href="#">Pagamentos</a></li>
                            <li><a href="#">Frete</a></li>
                            <li><a href="#">Nota Fiscal Eletrônica</a></li>
                            <li><a href="#">Política de Privacidade</a></li>
                            
                        </ul>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                        <h3><?php $this->lang->get('PAYMENT METHODS'); ?></h3>
                        <div class="row" style="margin:0 auto"><div class="col-sm-12">
                                <img width="150" src="<?php echo BASE_URL; ?>assets/images/cartoes.png" /></div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-6"><img width="80" src="<?php echo BASE_URL; ?>assets/images/boleto.png" /></div>
                            <div class="col-sm-6"><img width="80" src="<?php echo BASE_URL; ?>assets/images/paypal.png" /></div>
                        </div>
                        </div>
                    </div>
                    </div><br/><br/>
                </div>
            
                
        </div>
        
        <div class="row">
            <div class="col-sm-3"></div>
                    <div class="col-sm-6" style="margin:0 auto; text-align: center">
                        <img width="150" src="<?php echo BASE_URL; ?>assets/images/selo_certisign.png" />
                    </div>
                    <div class="col-sm-3"><h3><?php $this->lang->get('SOCIAL NETWORKS'); ?></h3>
                        <ul class="redessociais">
                        <li><a href="#" target="_blank" title="Facebook - Mercado Leo"><img width="40" src="<?php echo BASE_URL; ?>assets/images/face.png" /></a></li>
                        <li><a href="#" target="_blank" title="Instagram - Mercado Leo"><img width="40" src="<?php echo BASE_URL; ?>assets/images/instagram.png" /></a></li>
                        <li><a href="#" target="_blank" title="Youtube - Mercado Leo"><img width="40" src="<?php echo BASE_URL; ?>assets/images/youtube.png" /></a></li>
                        <li><a href="#" target="_blank" title="Twitter - Mercado Leo"><img width="40" src="<?php echo BASE_URL; ?>assets/images/twitter.png" /></a></li>
                    </ul>
                   
                </div>
            </div>
    </div>
</div>
<!-- Rodapé Direitos -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">© <span>Mercado Leo</span> - <?php $this->lang->get('ALLRIGHTRESERVED'); ?></div>
            <div class="col-sm-4">Uma Empresa do Grupo <a href="http://www.lanytecnologia.com.br">Lany Tecnologia.</a></div>
            <div class="col-sm-4">
                <div class="payments">
                    Desenvolvido por  <a href="http://www.jlcreative.com.br" target="_blanc">JL Creative</a>
                </div>
            </div>
        </div>
    </div>
</div>
</footer>
   <script type="text/javascript">
        var BASE_URL = '<?php echo BASE_URL; ?>';
    </script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.zoom.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.zoom.min.js"></script>
    
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script2.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/mascara.js"></script>
</body>
</html>