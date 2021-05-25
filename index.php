<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Jogo Gourmet</title>
</head>
<body class="text-center">
<?
session_start();

include "pratos.php";
$pratos = new pratos();
$pratos->incioJogo();

?>
<div class="container">
    <h1 class="float-md-start mb-0">Jogo Gourmet</h1>
    <h3>Pense em um prato que gosta</h3>
    <button type="button" class="btn btn-primary" onclick="errou()">OK</button>
</div>


<!-- O prato que voce pensou é Categoria -->
<div class="modal fade" id="categoriaModal" tabindex="-1" role="dialog" aria-labelledby="categoriaModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Confirme</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>O prato que voce pensou é <span id="categoria">massa</span>?</p>
                <input type="hidden" id="pratocat" value="lasanha">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="pratoSim($('#pratocat').val())" data-dismiss="modal">Sim</button>
                <button type="button" class="btn btn-secondary" onclick="errou()">Não</button>
            </div>
        </div>
    </div>
</div>


<!--O prato que voce pensou é prato-->
<div class="modal fade" id="pratoModal" tabindex="-1" role="dialog" aria-labelledby="pratoModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Confirme</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>O prato que voce pensou é <span id="prato">lasanha</span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="alerta('Acertei!')" data-dismiss="modal">Sim</button>
                <button type="button" class="btn btn-secondary" onclick="errou()" data-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>

<!--Pergunta o prato -->
<div class="modal fade" id="desistoPratoModal" tabindex="-1" role="dialog" aria-labelledby="desistoPratoModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Desisto</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Qual prato você pensou? </p>
                <input type="text" name="nomePrato" id="nomePrato">
                <input type="hidden" id="errouPratoCat" value="Massa">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="perguntaCat()" >OK</button>
                <button type="button" class="btn btn-secondary" onclick="location.reload()">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--Pergunta a categoria -->
<div class="modal fade" id="desistoCatModal" tabindex="-1" role="dialog" aria-labelledby="desistoCatModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Desisto</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="perguntaCat"></p>
                <input type="text" name="CatPrato" id="CatPrato">
                <input type="hidden" id="nomePratoCat" value="Lasanha">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="inserePrato()">OK</button>
                <button type="button" class="btn btn-secondary" onclick="location.reload()">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--Alerta-->
<div class="modal fade" id="alertaModal" tabindex="-1" role="dialog" aria-labelledby="alertaModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Atenção</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="alerta"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="location.reload();">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>

    function errou(){
        $("#categoriaModal").modal("show");
        $.ajax({
            url:'novoprato.php',
            complete: function(e, xhr, settings){
                if(e.status === 200){
                    data = JSON.parse(e.responseText);
                    $('#categoria').html(data['categoria']);
                    $('#pratocat').val(data['prato']);
                }else if(e.status === 204){
                    $("#categoriaModal").modal("hide");
                    perguntaPrato();
                }else{
                    location.reload();
                }
            }
        });
    }
    function inserePrato(){
        if($('#CatPrato').val()==''){
            alert('Informe a categoria do prato!');
        }else {
            $("#desistoPratoModal").modal("hide");
            $.ajax({
                url: 'insereprato.php',
                type: "POST",
                data: {
                    prato: $('#nomePratoCat').val(),
                    categoria: $('#CatPrato').val()
                },
                complete: function (e, xhr, settings) {
                    location.reload();
                }
            });
        }
    }

    function perguntaPrato(){
        $('#errouPratoCat').val($('#categoria').html());
        $("#desistoPratoModal").modal("show");
    }

    function perguntaCat(){
        if($('#nomePrato').val()==''){
            alert('Informe o nome do prato!');
        }else {
            $("#desistoPratoModal").modal("hide");
            $('#nomePratoCat').val($('#nomePrato').val());
            $('#perguntaCat').html($('#nomePrato').val() + ' é ___________ mas ' + $('#errouPratoCat').val() + ' não.');
            $("#desistoCatModal").modal("show");
        }
    }

    function alerta(texto){
        $("#alerta").html(texto);
        $("#alertaModal").modal();
    }
    function pratoSim(prato){
        $("#prato").html(prato);
        $("#pratoModal").modal();
    }
</script>
</body>
</html>
