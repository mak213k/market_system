<?php
//require "autoload.php";

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\Repository;
use App\Controller\taxController;
use App\Services\TaxService;
use App\Repositories\TaxRepository;

$database = Repository::getInstance();
$taxRepository = new TaxRepository($database);
$taxService = new TaxService($taxRepository);
$taxController = new taxController($taxService);

$dadosTax = $taxController->index();

?>

<style>
    /*
    button.button_screen 
    {
        border-radius: 1.5em;
        border: solid 0em;
        height: 2em;
        width: 12em;
        text-align: center;
        font-weight: 590;
    }
    */
</style>

<div class="container text-center" id='search_tax'>
    
    <div id="mensagem"></div>

    <div class="row">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Taxa percentual</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Deletar</th>
                </tr>
            
            </thead>
            <tbody>

                <?php foreach( $dadosTax as $value){ ?>

                            <tr>
                                <td><?php echo $value['description'] ?></td>
                                <td><?php echo $value['tax_percentage'] ?></td>
                                <td><a href="javascript:;" class="edit"><i class="fa fa-pencil" id="<?php echo $value['id_tax'] ?>" onclick="edit(<?php echo $value['id_tax'] ?>)"></i></a></td>
                                <td><a href="javascript:;" class="exclude"><i class="fa fa-trash" id="<?php echo $value['id_tax'] ?>" onclick="exclude(<?php echo $value['id_tax'] ?>)"></i></a></td>
                            </tr>

                <?php } ?>

            </tbody>
        </table>

        <div style="padding:2em"></div>
        <div class="row">
            <div class="col-md-4">
            <div class="row">
                <button id="formulario_tax" class="btn btn-outline-primary" style="width: 10em;" onclick="">
                    Novo
                </button>
                <script>
                    $('#formulario_tax').click(function(){
                        $.post("/Controller/taxController.php?method=formulario",function(callback){
                            $('#search_tax').html(callback);
                        },'html');
                    });
                </script>
            </div>
            </div>
            <div class="col-md-4">
                <button id="cancelar" class="btn btn-outline-primary" style="width: 10em;" onclick="">
                    Cancelar
                </button>
                <script>
                    $('#cancelar').click(function(){

                        window.location.reload()
                    });
                    
                </script>
            </div>
            <div class="col-md-4"></div>
        </div>

    </div>
        <script>

            function exclude(id){

                if( confirm("Quer realmente deletar este item?") == false )
                {
                    return;
                }

                $.post("/Controller/taxController.php?method=delete",{ id:id }, function(callback){

                    let classMessage = '';
                    if( callback.status == 1 )
                    {
                        classMessage = "success";
                    }else
                    {
                        classMessage = "danger";
                    }
                    window.scrollTo(0,0);
                    $('#mensagem').html('<div class="alert alert-'+classMessage+'" role="alert">'+callback.message+'</div>').fadeIn(50000).fadeOut(50000);
                },'json');
                
            }

            function edit(id){

                
                $.post("/Controller/taxController.php?method=edit",{ id:id }, function(callback){
                    $('#search_tax').html(callback);
                },'html');
            }

            $('#edit').click(function(){
                let id = $(this).attr('id');
                edit(id);
            });

            $('#exclude').click(function(){
                let id = $(this).attr('id');
                exclude($id);
            });
            
            
            
        </script>
</div>