<script>
    $(document).ready(function() { 
   
        window.setTimeout("location.href='"+BASE_URL+"'",30000);
    });
 
</script>
<h2 style="text-align: center">Obrigado pela Compra</h2><br>

<h4 style="text-align: center">Clique no Link abaixo para imprimir seu Boleto</h4><br>

<div style="text-align: center; margin-bottom: 50px">
    <a href="<?php echo $link;?>" target="_blank">Imprimir Boleto</a>
</div>