<?php

    require_once "component/menu.php";
?>

<div class="col-md-12">
    <div style="padding:2em">
        <center>
            <div class="main-content" id="main-content">
                <div class="messages-return-center" id="messages-return-center">
                    <div>Nome do sistema</div>
                    <div>Informações sobre o funcionamento do sistema:</div>
                </div>
            </div>
        </center>
    </div>
</div>
<?php

    require_once "component/footer.php";
?>
<script>

$('.link_menu').click(function(){
    $("#main-content").load($(this).attr('link'), function( response, status, xhr ) {
        if (status == "error") {
            $(this).html( "ERRO: " + xhr.status + " " + xhr.statusText );
        }
    });
});
</script>