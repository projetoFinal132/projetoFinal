function verificaProfissional(){
  //var retorno;
    $.ajax({
        type: 'post',
        dataType: 'json',
        data:{
          op: 10
        },
        url:"model/puxaRequisicoesProfissionais.php",
        success:(data)=>{
          console.log(data);
          preenchePaginaProfissional(data)
        },
        error: (e)=>{
          console.log("erro cliente "+e);
          window.location = "http://localhost/sla/login.html";

        }
      });
      //console.log("retorno op"+retorno);
      //return retorno;
}

function preenchePaginaProfissional(profissional){
  $(".bem-vinda").append(`Seja bem vinda `+profissional.nome_profissional+`!`);
  $("#fotoProfissional").attr('src',profissional.diretorio_foto+``+profissional.nome_foto);
  $("#fotoProfissional").css('width','100px').css('border-radius','10px').css('margin-top','2%').css('float','left');
  $(".container-descricao").css("width",'60%').css('float','right');
  $(".container-descricao p").append(profissional.descricao).css('width','70%').css('margin-top','4%');
  $("#numeroProfissional").append(profissional.telefone_profissional).addClass("numero-profissional");
}