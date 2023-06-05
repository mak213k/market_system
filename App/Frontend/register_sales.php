
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

<?php 

if( file_exists('..\autoload.php') ){
    
  require_once '..\autoload.php';
}

/*
use App\Repositories\Repository;
use App\Controller\productController;
use App\Services\ProductService;
use App\Repositories\ProductRepository;

$database = Repository::getInstance();
$productRepository = new ProductRepository($database);
$productService = new ProductService($productService);
$productController = new ProductController($productService);

$dadosProduct = $productController->index();
*/
?>
<style>
  
  select#produt 
  {
    height: 2.5em;
  }
  input#quantity {
    height: 2.5em;
  }
  button#addItem {
    height: 2.5em;
  }
  button#btn_submit_form{
    height: 2.5em;
  }
  #price
  {
    height: 2.5em;
  }
  #unity_price
  {
    height: 2.5em;
  }

</style>
    <div class="container">
        <div class="py-5 text-center">
            <h2>Vendas</h2>
        </div>
        <div class="col-md-12" id="mensagem" style="display:block">      
        </div>
    </div>
    <form class="needs-validation" id="sale" name="sale" acao="insert" method="POST" >
          <div class="row g-3">
            <div class="row">
                <div class="col-md-3">
                  <label for="produt" class="form-label">Produto:</label>
                  <select name="produt" id="produt" style="width:100%;"></select>
                </div>
                
                <div class="col-md-3">
                  <label for="quantity" class="form-label">Quantidade:</label>
                  <input type="number" name="quantity" id="quantity" min=0 style="width:100%;" >
                  <script>

                    $('#quantity').focusout(function(){

                      fillProducts();
                    });

                    $(document).ready(function(){

                      $('#quantity').val('1');
                      fillProducts();
                    });
                  </script>
                </div>
                
                <div class="col-md-3">
                  <label for="unity_price" class="form-label">Preço Unitário:</label>
                  <input type="number" name="unity_price" id="unity_price" class="" min="0" style="width:100%;" disabled>
                </div>
                <div class="col-md-3">
                  <label for="price" class="form-label">Preço:</label>
                  <input type="number" name="price" id="price" class="" min=0 style="width:100%;" disabled>
                </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label for="addItem1" class="form-label"></label>
                <button type="button" id="addItem1" class="w-100 btn btn-primary btn-lg" style="width:100%;">
                  Adicionar item
                </button>
                <script>

                  $('#addItem1').click(function(){
                    addLine();
                  });
                </script>
              </div>
            </div>
            <input id="id_sale" type="hidden" value=<?php echo isset($dadosSale)? $dadosSale->getId() : "" ?>; >
            
            <div class="row g-3">
              <table>
                <thead>
                  <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Qtde</th>
                    <th scope="col">Imposto</th>
                    <th scope="col">Preço unitário</th>
                    <th scope="col">Remover item</th>
                  </tr>
                </thead>
                <tbody id="tb_product">
                </tbody>
              </table>
            </div>
              
            
            <hr class="my-4" />
            <div class="col-md-4">
              <label for="btn_submit_form" class="form-label"></label>
              <button class="w-100 btn btn-primary btn-lg" id="btn_submit_form" acao=<?php echo isset($dadosTax)? "update" : "insert" ?> action="insert" type="submit">Lançar vendas</button>
            </div>
        </div>
         
    </form>


    <script>
                
                function fillProducts()
                {
                  
                  let id = $('#produt').val();
                   
                  $.post("/Controller/productController.php?method=query_up_to_date_product",{id},function(callback){
                   
                    for( i = 0; i < callback.id.length; i++ )
                    {
                      if( id != null ){
                       
                        let soma = $('#quantity').val() * callback.price;

                        $('#unity_price').val( callback.price );
                        $('#price').val( ( soma.toFixed(2) ) );

                      }else{
                        
                        $('#produt').append('<option value="'+callback.id[i]+'">'+callback.name[i]+'</option>');
                      }
                      
                    }

                  },'json');
                }
                
                function addLine()
                {
                  
                  
                  let id = $('#produt').val();
                  let quantity = $('#quantity').val();
                  let unity_price = $('#unity_price').val();
                  let price = $('#price').val();
                  
                  $('#tb_product').append("<tr><td>"+id+"</td><td>"+quantity+"</td><td>"+unity_price+"</td><td>"+price+"</td><td><a href='javascript:;' class='exclude'><i class='fa fa-trash' id='' onclick='exclude(id)'></i></a></td></tr>");
                  
                }
                
    </script>


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

                    let address = 'App/Controller/taxController.php?method='+acao;
                                        
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
                          $.post('App/Frontend/search_tax.php', function(data){
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