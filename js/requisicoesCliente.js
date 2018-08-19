
function verificaCliente(){ // função morta, ver possivel reutilização depois
    
    let data_desserializado = JSON.parse(localStorage.getItem("usuario"));
    console.log("akeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee");
    console.log(data_desserializado.emailUsuario);
    $.ajax({
        type: 'post',
        dataType: 'json',
        data:{
          op: 10,
          email: data_desserializado.emailUsuario
        },
        url:"model/puxaFuncionariasCliente.php",
        success:(cliente)=>{
          //console.log(cliente);
        },
        error: (e)=>{
          console.log("erro cliente "+e);
          //window.location = "http://localhost/sla/login.html";

        }
      });
}
function pegaProfissionais(){

    $.ajax({
        type:'post',
        dataType:'json',
        data:{
            op: 1
        },
        url: "model/puxaFuncionariasCliente.php",
        success: (profissionais)=>{
           console.log(profissionais);
           MontaContainerProfissional(profissionais);
           
        },error: (a)=>{
            console.log(a);
        }
      });
}
function pegaPortifolio(isso){
    let emailUsuario = $(isso).attr("value");
    let elementoPai= $(isso).parent();
    if ($(".imagens-do-portifolio").is(":visible")) {
        $(".imagens-do-portifolio").hide('slow');
        $(isso).css('float','initial');
        $(isso).parent().parent().height(260);
        $(elementoPai).height(20);
        $(elementoPai).css('width','46%');
        $(elementoPai).css('margin-left','15%');
        $(elementoPai).css('margin-top','0%');
        $(elementoPai).css('padding-top','2%');
        $(".div-filha-portifolio").empty();
    }else{        
        $(".imagens-do-portifolio").show('slow');
        $(isso).css('float','initial');
        $(elementoPai).height(275);
        $(elementoPai).width(700);
        $(elementoPai).css('margin-left','15%');
        $(elementoPai).css('margin-top','0%');
        $(elementoPai).css('padding-top','2%');
        $(".div-filha-portifolio").empty();
        $.ajax({
            type:'post',
            dataType:'json',
            data:{
                op: 2,
                idProfissionalProtifolio: emailUsuario
            },
            url: "model/puxaFuncionariasCliente.php",
            success: (portifolio)=>{
               //console.log(portifolio);
               if (portifolio.length == 0) {
                $(isso).parent().parent().height(180);
                $(isso).parent().parent().height($(".profissional").height()+60);
                $(elementoPai+" p").hide();
                $(elementoPai).append(`<p class="texto-protifolio">Profissional não possui<br>um portifolio no momento</p>`);
                } else {
                    $(isso).parent().parent().height(180);
                    $(isso).parent().parent().height($(".profissional").height()+300);
                    let filha = $(elementoPai).children(".div-filha-portifolio");
                    //$(isso).remove();
                    $(filha).addClass("imagens-do-portifolio");
                    
                    //$(isso).parent().parent().append(`<div class="imagens-do-portifolio"></div>`);
                   portifolio.forEach(foto => {
                     $(filha).append(`<img src="`+foto.diretorio_foto+``+foto.nome_foto+`" alt="imagem protifolio">`);
                     $(filha).append(`<img src="`+foto.diretorio_foto+``+foto.nome_foto+`" alt="imagem protifolio">`);
                     $(filha).append(`<img src="`+foto.diretorio_foto+``+foto.nome_foto+`" alt="imagem protifolio">`);
                   });
                   
                
                }
                  
            },error: (a)=>{
                console.log(a);
            }
          });
    }
}
function filtraProfissionais(event){    
        event.preventDefault();
        let isso = document.getElementById("formFiltro");
        console.log(isso.nome_profissional.value);
        console.log(isso.serv.value);
        console.log(isso.cidade.value);
        console.log(isso.bairro.value);
        let idCidade = isso.cidade.value;
        let idBairro = isso.bairro.value;
        let idServico = isso.serv.value;
        let nomeProfissional = isso.nome_profissional.value;
        if(isso.nome_profissional.value == '' && isso.serv.value == '' &&  isso.cidade.value != 0 &&  isso.bairro.value != 0){
            console.log("nome e serv vazio");
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:{
                    op: 5,
                    idCidade: idCidade,
                    idBairro: idBairro,
                },
                url: "model/puxaFuncionariasCliente.php",
                success:(profissionais)=>{
                    console.log(profissionais);
                    $(".container-resultado").empty();
                    MontaContainerProfissional(profissionais);
                },
                error:(e)=>{
                    console.log(e);
                }
            });
        }else if(isso.nome_profissional.value == '' && isso.serv.value != 0 &&  isso.cidade.value != 0 &&  isso.bairro.value != 0){
            console.log("nome vazio");
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:{
                    op: 6,
                    idCidade: idCidade,
                    idBairro: idBairro,
                    idServico: idServico
                },
                url: "model/puxaFuncionariasCliente.php",
                success:(profissionais)=>{
                    console.log(profissionais);
                    $(".container-resultado").empty();
                    MontaContainerProfissional(profissionais);
                },
                error:(e)=>{
                    console.log(e);
                }
            });
        }else if(isso.serv.value == '' && isso.nome_profissional.value != '' &&  isso.cidade.value != 0 &&  isso.bairro.value != 0){
            console.log("serviço vazio");
            console.log(nomeProfissional);
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:{
                    op: 7,
                    idCidade: idCidade,
                    idBairro: idBairro,
                    nomeProfissional: nomeProfissional
                },
                url: "model/puxaFuncionariasCliente.php",
                success:(profissionais)=>{
                    console.log(profissionais);
                    $(".container-resultado").empty();
                    MontaContainerProfissional(profissionais);
                },
                error:(e)=>{
                    console.log(e);
                }
            });
        }else {
            console.log("tudo vazio");
            $.ajax({
                type: 'post',
                dataType: 'json',
                data:{
                    op: 1,
                },
                url: "model/puxaFuncionariasCliente.php",
                success:(profissionais)=>{
                    console.log(profissionais);
                    $(".container-resultado").empty();
                    MontaContainerProfissional(profissionais);
                },
                error:(e)=>{
                    console.log(e);
                }
            });
        }
}
function MontaContainerProfissional(profissionais){
    let cliente = JSON.parse(localStorage.getItem("usuario"));
    profissionais.forEach(profissional => {//nome_servico
        $(".container-resultado").append(`
          <div class="profissional">
              <h3 class="nome-profissional">`+profissional.nome_usuario+`</h3>
              <img class="img-profissional" src="`+profissional.diretorio_foto_perfil+``+profissional.nome_foto_perfil+`" alt="imagem profissional">
              <a id="estrelas" onclick="containerRank('`+profissional.email_usuario+`','`+cliente.emailUsuario+`')">Deixe sua avaliação</a>
              <div class="container-area-conhecimento">
                <h4 href="#" id="areaConhecimento">Areas de conhecimento</h4>
                <br><p>`+profissional.nome_servico+`</p>
              </div>
              <div class="container-area-descricao">
                <h4 href="#" id="descricao">descrição</h4>
                <p>`+profissional.descricao_profissional+`</p>
              </div>
              <p class="nome-contato">Contato:</p>
              <p class="telefone-profissional">`+profissional.telefone_profissional+`</p>
              <div id="`+profissional.email_usuario+`" class="container-area-descricao">
                <a href="#" id="protifolio" value="`+profissional.email_usuario+`" onclick="pegaPortifolio(this)">Ver portifolio</a>
                <div class="div-filha-portifolio"></div>
             </div>
          </div><br><br>
        `);
        $(".imagens-do-portifolio").hide('slow');
       });
}
function containerRank(emailProfissional, emailCliente){// AKEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
    console.log("Fazer container");
    $('body').append(` 
        <div class="containerPopUp">
            <form onsubmit="enviaComentario(this, event, '`+emailProfissional+`', '`+emailCliente+`')" id="formPop" class="formPop" action="" method="post">
                <a id="fecharContaienrPop" onclick="fechaContaienrPop()">X</a>
                <div class="container-radio">
                    <label for="1"> 1:</label>
                    <input type="radio" class="radio-pop" name="rdx" id="rd1" value="1" required>
                    <label for="2"> 2:</label>
                    <input type="radio" class="radio-pop" name="rdx" id="rd2" value="2" required>
                    <label for="3"> 3:</label>
                    <input type="radio" class="radio-pop" name="rdx" id="rd3" value="3" required>
                    <label for="4"> 4:</label>
                    <input type="radio" class="radio-pop" name="rdx" id="rd4" value="4" required>
                    <label for="5"> 5:</label>
                    <input type="radio" class="radio-pop" name="rdx" id="rd5" value="5" required><br>
                    <textarea name="comentarioCliente" id="comentarioCliente" cols="30" rows="10" placeholder="Deixe seu comentario"></textarea><br>
                    <input type="submit" value="Enviar Comentario">
                </div>
            </form>
        </div>
    `);
}
function enviaComentario(isso, event, emailProfissional, emailCliente) {
    event.preventDefault();
    let radios = document.getElementsByName("rdx");
    let rdcheked = 0;
    for (var i = 0; i < radios.length; i++){
        if (radios[i].checked){
            rdcheked =  radios[i].value;
        }
    }
    //console.log(isso.comentarioCliente.value);
    //console.log(rdcheked);
    $.ajax({
        type: 'post',
        dataType: 'json',
        data:{
            op: 6,
            comentarioCliente: isso.comentarioCliente.value,
            rdcheked: rdcheked,
            emailProfissional: emailProfissional, 
            emailCliente: emailCliente

        },
        url: "model/profissionalModel.php",
        success:(resultado)=>{
            console.log(resultado);
        },
        error:(e)=>{
            console.log(e);
        }
    });
}
function fechaContaienrPop(){
    $(".containerPopUp").remove();
}