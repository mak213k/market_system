
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
  
  select#product 
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
                  <label for="product" class="form-label">Produto:</label>
                  <select name="product" id="product" style="width:100%;"></select>
                </div>
                
                <div class="col-md-3">
                  <label for="quantity" class="form-label">Quantidade:</label>
                  <input type="number" name="quantity" id="quantity" min=0 style="width:100%;" >
                  <script>

                    $('#quantity').focusout(function(){

                      fillProductParameter();
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
                  <label for="tax" class="form-label">Imposto:</label>
                  <input type="number" name="tax" id="tax" class="" min="0" style="width:100%;" disabled>
                </div>
                <div class="col-md-3">
                  <label for="price" class="form-label">Preço:</label>
                  <input type="number" name="price" id="price" class="" min=0 style="width:100%;" disabled>
                </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <label for="addItem1" class="form-label"></label>
                <button type="button" id="addItem1" class="btn btn-outline-primary" style="margin-top: 2em;">
                  <center>Adicionar item</center>
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
                    <th scope="col">ID</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Qtde</th>
                    <th scope="col">Preço unitário</th>
                    <th scope="col">Imposto</th>
                    <th scope="col">Preço Total</th>
                    <th scope="col">Remover item</th>
                  </tr>
                </thead>
                <tbody id="tb_product">
                </tbody>
              </table>
            </div>
              
            
            <hr class="my-4" />
            <div class="col-md-3">
              <label for="btn_submit_form" class="form-label"></label>
              <button class="btn btn-outline-primary" id="btn_submit_form" acao="insert" action="insert" type="submit">
                <center>Lançar vendas</center>
              </button>
            </div>
        </div>
         
    </form>


    <script>
                
                var linha = 0;

                function fillProducts()
                {
                  
                  let id = $('#product').val();
                  let product = $('#product').val(); 

                  $.post("/Controller/productController.php?method=query_up_to_date_product",{id},function(callback){
                   
                    for( i = 0; i < callback.id.length; i++ )
                    {
                      
                      $('#product').append('<option value="'+callback.id[i]+'">'+callback.name[i]+'</option>');
                    }

                  },'json');
                }



                function fillProductParameter()
                {
                  let id = $('#product').val();
                  let product = $('#product').val(); 

                  takeTax();

                  $.post("/Controller/productController.php?method=query_up_to_date_product",{id},function(callback){
                   
                    for( i = 0; i < callback.id.length; i++ )
                    {
                     
                        let soma = ( ( $('#quantity').val() * callback.price ) + ( $('#quantity').val() * $('#tax').val() ) );

                        $('#unity_price').val( callback.price );
                        $('#price').val( ( soma.toFixed(2) ) );
 
                    }

                  },'json');
                }



                function takeTax()
                {
                  let id = $('#product').val();
                  $.post("/Controller/productController.php?method=query_tax",{id}, function(callback)
                  {
                    let tax = callback.tax_percentage;
                    $('#tax').val(tax.toFixed(2));
                  },'json');
                }


                
                function addLine()
                {
                  
                  var id_product = '';
                  let id = $('#product').val();
                  let product = $('#product option:selected').text();
                  let quantity = $('#quantity').val();
                  let unity_price = $('#unity_price').val();
                  let tax = $('#tax').val();
                  let price = $('#price').val();
                  

                  $('#tb_product').append("<tr id=linha_"+linha+"><td>"+id+"</td><td>"+product+"</td><td>"+quantity+"</td><td>"+unity_price+"</td><td>"+tax+"</td><td>"+price+"</td><td><a href='javascript:;' class='exclude'><i class='fa fa-trash' id='' onclick='exclude("+linha+")'></i></a></td></tr>");
                  
                  var obj = {"linha":"linha_"+linha, "id_product":id, "quantity":quantity};

                  
                  localStorage.setItem("linha_"+linha, JSON.stringify(obj));
                  
                  linha++;
                }


                
                function exclude(linha)
                {
                  $('#linha_'+linha).detach();
                }        
          


          $(document).ready(function(){
            
            let submit = document.getElementById('btn_submit_form');
            submit.addEventListener("click", validateForm);
          });
          

          

          function validateForm(e){

                    e.preventDefault();
                  
                    dadosForm ={};
                    for (let i = 0; i < localStorage.length; i++){
                      let key = localStorage.key(i);
                      let value = localStorage.getItem(key);
                      dadosForm = {key:value};
                    }

                    alert('fim');

                    acao = $('#btn_submit_form').attr('acao');

                    let address = 'Controller/sallesController.php?method='+acao;
                                        
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
                          window.location.reload();
                        },6000);

                    },'json');
  
          }
          
    </script>
    <!--
</body>
</html>
    -->