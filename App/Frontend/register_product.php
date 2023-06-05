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
            <h2>Cadastro de Produtos</h2>
        </div>
        <div class="col-md-12" id="mensagem" style="display:block">      
        </div>
    </div>
    <form class="needs-validation" id="new_product" name="new_product" acao="insert" acao=<?php echo isset($dadosProduct)? "insert" : "update" ?> method="POST" >
          <input id="id_product" value='<?php echo isset($dadosProduct)? $dadosProduct->getId(): "" ?>' type="hidden"/>
          <div class="row g-3">
            <div class="col-md-12">
              <label for="name" class="form-label">Nome:</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Nome" value='<?php echo isset($dadosProduct)? $dadosProduct->getName(): "" ?>' required>
              <div class="invalid-feedback">dadosProduct
                    Nome é obrigatório.
              </div>
            </div>

            <div class="col-md-12">
              <label for="description" class="form-label">Descrição:</label>
              <input type="text" name="description" class="form-control" id="description" placeholder="Descrição" value='<?php echo isset($dadosProduct)? $dadosProduct->getDescription() : "" ?>' required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>

            <div class="col-md-12">
              <label for="price" class="form-label">Preço</label>
              <div class="input-group has-validation">
                <input type="number" name="price" class="form-control" min=0 id="price" placeholder="Preço" value='<?php echo isset($dadosProduct)? $dadosProduct->getPrice() : "" ?>' required>
                  <div class="invalid-feedback">
                  Preço é campo obrigatório
                </div>
              </div>
            </div>
            <div class="cold-md-12">
                <label for="product_type_id" class="form-label">
                    Tipo de Produto
                </label>
                <select name="product_type_id" class="form-select" id="product_type_id">
                    <?php 
                      foreach( $dadosProductType as $value ){

                        if( isset($dadosProduct) && ( $value['id_product_type'] == $dadosProduct->getProductTipe()) ){
                            echo "<option value=".$value['id_product_type']." selected>".$value['name']."</option>";
                        }else{
                          echo "<option value=".$value['id_product_type'].">".$value['name']."</option>";
                        }
                      }
                    ?>
                </select>
            </div>
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" id="btn_submit_form" acao=<?php echo isset($dadosProduct)? "update" : "insert" ?> type="submit">Cadastrar Produto</button>
        
         
    </form>
    <script>
          
          
          $(document).ready(function(){

            let submit = '';
            submit = document.getElementById('btn_submit_form');
            submit.addEventListener("click", validateForm);
          });
          

          
          function validateForm(e){

                    e.preventDefault();

                    if( $('#name').val() == '' || $('#description').val() == '' || $('#price').val() == '' )
                    {
                      $('#mensagem').html('<div class="alert alert-danger" role="alert">'+'Campo obrigatório não preenchido'+'</div>').fadeIn(3000).fadeOut(3000);
                      return;
                    }

                    let acao = $('#btn_submit_form').attr('acao');
                    let dadosForm = $('#new_product').serialize();



                    let id_product = $('#id_product').val();  
                    if( id_product != '' )
                    {

                        dadosForm += '&id_product=' + id_product;
                    }

                    
                    let address = '/Controller/productController.php?method='+acao;
                                        
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
                          $.post('/Frontend/search_product.php', function(data){
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