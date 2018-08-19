function logar(event){
    event.preventDefault();
    let form = document.getElementById("formLogin");
    //console.log(form.email.value);
    //console.log(form.senha.value);
    $.ajax({
        type:'post',
        dataType: 'json',
        data:{
            op: 1,
            email: form.email.value,
            senha: form.senha.value
        },
        url:"controller/usuarioController.php",
        success:(usuario)=>{
            //let obj = JSON.parse(data);
            console.log(usuario);
            localStorage.clear();
            
            localStorage.removeItem("auto_saved_sql");
            let data_serialized = JSON.stringify(usuario);

            localStorage.setItem("usuario", data_serialized);
            console.log(localStorage);

            let data_desserializado = JSON.parse(localStorage.getItem("usuario"));
            console.log(data_desserializado);
            if (usuario.tipoUsuario == 1) {
                window.location = "http://localhost/sla/cliente.html";
            }else if(usuario.tipoUsuario == 2){
                window.location = "http://localhost/sla/profissional.html";
            }
        },
        error:(e)=>{
            console.log(e);
            $(".falha-login").empty();
            $(".falha-login").append(`Ops, algo foi deu errado`);
        }
    });

    //let form = document.querySelector("#formLogin");
    //let fotos = form.fotos.files;
/*
    let form_data = new FormData();                  // Creating object of FormData class
    form_data.append('op', 1);              // Adding extra parameters to form_data 
    form_data.append('email', form.email.value); 
    form_data.append('senha', form.senha.value); 
    let request = new XMLHttpRequest();
    request.open('post','controller/usuarioController.php',true);
    request.send(form_data);
    request.upload.addEventListener('load',(e)=>{
        console.log(request.responseText);
    },false);
    
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //let resposta = this.responseText;
          if (this.responseText == 1) {
            console.log("operação deu bom krai");
            //slocation.reload(); 
          }
          let resposta = this.response;
          console.log(resposta);
          request.abort();
        }else if(this.status != 200){
            console.log("error"+this.responseText);
            request.abort();
        }
    };
*/


}