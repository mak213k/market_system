
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
            <h2>Cadastro de Tipos de Produto</h2>
        </div>
        <div class="col-md-12" id="mensagem" style="display:block">      
        </div>
    </div>
    <form class="needs-validation" id="new_product_type" name="new_product_type" acao="insert" acao=<?php echo isset($dadosProduct)? "insert" : "update" ?> method="POST" >
          <div class="row g-3">
            <input id="id_product_type" type="hidden" value='<?php echo isset($dadosProduct)? $dadosProduct->getId() : "" ?>' />
            <div class="col-md-12">
              <label for="name" class="form-label">Nome:</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Nome" value='<?php echo isset($dadosProduct) ? $dadosProduct->getName() : ""; ?>' required>
              <div class="invalid-feedback">
                    Nome é obrigatório.
              </div>
            </div>
          <div style="padding:1em"></div>

          <div class="cold-md-12">
                <label for="label_tax_id" class="form-label">
                    Imposto sobre produto
                </label>
                <select name="tax_id" multiple class="form-select" id="tax_id">
                    <?php 
                      foreach( $dadosTax as $value ){

                        if( isset($dadosProductTypeTax) && ( $dadosProductTypeTax != null ) && ( $value['id_tax'] == $dadosProductTypeTax['id_tax'] ) ){
                            
                            echo "<option value=".$value['id_tax']." selected>".$value['description']."</option>";

                        }else{

                            echo "<option value=".$value['id_tax'].">".$value['description']."</option>";
                        }
                      }
                    ?>
                </select>
            </div>

          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" id="btn_submit_form" acao=<?php echo isset($dadosProduct)? "update" : "insert" ?> type="submit">Cadastrar Tipos de Produto</button>
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

                    let id_product_type = $('#id_product_type').val();
                    let acao = $('#btn_submit_form').attr('acao');
                    let dadosForm = $('#new_product_type').serialize();

                    if( id_product_type != '' ){

                      dadosForm += '&id_product_type=' + id_product_type;
                    }

                    let address = '/Controller/productTypeController.php?method='+acao;
                                        
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
                          $.post('/Frontend/search_product_type.php', function(data){
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