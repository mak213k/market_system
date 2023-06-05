
<!--

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
-->
    <div class="container">
        <div class="py-5 text-center">
            <h2>Cadastro de Imposto sobre Tipo de produto</h2>
        </div>
        <div class="col-md-12" id="mensagem" style="display:block">      
        </div>
    </div>
    <form class="needs-validation" id="new_product_type" name="new_product_type" acao="insert" acao=<?php echo isset($dadosTax)? "insert" : "update" ?> method="POST" >
          <div class="row g-3">
            <input id="id_tax" type="hidden" value='<?php echo isset($dadosTax)? $dadosTax->getId() : "" ?>' />
            <div class="col-md-12">
              <label for="name" class="form-label">Imposto:</label>
              <input type="text" name="description" class="form-control" id="description" placeholder="Nome" value='<?php echo isset($dadosTax) ? $dadosTax->getDescription() : ""; ?>' required>
              <div class="invalid-feedback">
                    Nome é obrigatório.
              </div>
            </div>
            <div class="col-md-12">
              <label for="a" class="form-label">Alíquota:</label>
              <input type="text" name="tax_percentage" class="form-control" id="tax_percentage" placeholder="Alíquota percentual ( % )" min="0" max="100" step=".01" value='<?php echo isset($dadosTax) ? $dadosTax->getTaxPercentage() : ""; ?>' maxlength="6" required>
              <div class="invalid-feedback">
                  Alíquota é obrigatório.
              </div>
              <script>
                /*
                $('#tax_percentage').keyup( function(){
                    //$(this).length
                    alert($(this).length);
                });
                */
              </script>
            </div>
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" id="btn_submit_form" acao=<?php echo isset($dadosTax)? "update" : "insert" ?> type="submit">Cadastrar Tipos de Produto</button>
          </div>
         
    </form>
    <script>
          
          
          $(document).ready(function(){
            
            let submit = document.getElementById('btn_submit_form');
            submit.addEventListener("click", validateForm);
          });
          

          
          function validateForm(e){

                    e.preventDefault();

                    if( $('#name').val() == '' )
                    {
                      $('#mensagem').html('<div class="alert alert-danger" role="alert">'+'Campo obrigatório não preenchido'+'</div>').fadeIn(3000).fadeOut(3000);
                      return;
                    }

                    let id_tax = $('#id_tax').val();
                    let acao = $('#btn_submit_form').attr('acao');
                    let dadosForm = $('#new_product_type').serialize();

                    if( id_tax != '' ){

                      dadosForm += '&id_tax=' + id_tax;
                    }

                    let address = 'Controller/taxController.php?method='+acao;
                                        
                    $.post(address, dadosForm, function(callback){
                        
                        let classMessage = '';
                        if( callback.status == true )
                        {
                          classMessage = "success";
                        }else
                        {
                          classMessage = "danger";
                        }
                        
                        window.scrollTo(0,0);
                        $('#mensagem').html('<div class="alert alert-'+classMessage+'" role="alert">'+callback.message+'</div>').fadeIn(3000).fadeOut(3000);
                        
                        setTimeout(function(){
                          $.post('Frontend/search_tax.php', function(data){
                            $('#main-content').html(data);
                          });
                        },6000);

                    },'json');
  
          }
          
    </script>
    <!--
</body>
</html>
    -->