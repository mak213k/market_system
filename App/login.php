
<div class="card border-dark mb-3" style="max-width: 25em; width: 25em; heigth: 20em;heigth: 20em;margin: 6em;">
    <div class="card-header">
        Autenticação
    </div>
    <div class="card-body">
        <form name="login" id="login" method="post" >
            
            <div class="mb-3 col-md-12">
                <label for="user" class="form-label"></label>
                <input class="" name="user" id="user" placeholder="Usuário" />
            </div>
            <div class="mb-3 col-md-12">
                <label for="pass" class="form-label"></label>
                <input class="" name="pass" id="pass" placeholder="Senha" />
            </div>
            
            <div class="mb-3">
                <button class="btn btn-outline-dark" id="send" onClick="envio()">Enviar</button>
            </div>
            <script>
                function envio()
                {
                    
                    
                    //let user = $('#user').val();
                    //let pass = $('#pass').val();
                    
                    let dados = $('#login').serialize();
                    $.post("Controller/loginController.php",dados,function(data){

                        alert(data);
                    },'html')
                }
                
            </script>
            
        </form>
    </div>
</div>