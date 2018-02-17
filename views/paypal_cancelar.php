<script>
    $(document).ready(function() { 
        $('#modalcadastrosucesso').modal('show');
        window.setTimeout("location.href='"+BASE_URL+"'",4000);
    });
 
</script>
                        
<!--Modal Cadastro Realizado com Sucesso-->

<div class="modal fade" role='dialog' id='modalcadastrosucesso' >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notificação</h4>
      </div>
      <div class="modal-body">
        <p>Pagamento Não Aprovado. Houve Algum Erro Durante o Processo. Tente Novamente Mais Tarde.</p>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

  </div>
</div>
<!--FIM-->