$(document).ready(() => {
                
    $("#escolha-profissional").on('click',(e)=>{
         e.preventDefault();
         $(".container-form-cadastro").html(`
                             <form id="cadastroProfissional" action="controller/profissionalController.php" method="post" enctype='multipart/form-data'>
                                 <label class="label-form-cadastro" for="nome">Selecione uma foto para você:</label><br>
                                 <input class="input-form" type="file" name="fotoPerfil" id="fotoPerfil"><br>
                                 <label class="label-form-cadastro" for="nome">Selecione as melhores fotos para seu portifolio:</label><br>
                                 <input class="input-form" type="file" name="fotosPortifolio[]" id="fotosPortifolio[]" multiple="multiple"><br>

                                 <input type="hidden" name="op" id="op" value="cadastro">
                                 <label class="label-form-cadastro" for="nome">Nome:</label><br>
                                 <input class="input-form" type="text" name="nome" id="nome"><br>

                                 <label class="label-form-cadastro" for="cpf">Cpf</label><br>
                                 <input class="input-form" type="text" name="cpf" id="cpf"><br>

                                 <label class="label-form-cadastro" for="email">Email:</label><br>
                                 <input class="input-form" type="email" name="email" id="email"><br>

                                 <label class="label-form-cadastro" for="senha">Digite uma senha:</label><br>
                                 <input class="input-form" type="password" name="senha" id="senha"><br>

                                 <label class="label-form-cadastro" for="telefone">Telefone:</label><br>
                                 <input class="input-form" type="text" name="telefone" id="telefone"><br>
                                 <label class="label-form-cadastro">Qual a sua principal(você poderá adicionar outras mais tarde)</label>
                                 <select name="tipos-servico" id="tipos-servico" class="tipos-servico"></select>
                                 <label class="label-form-cadastro" for="">Onde você irá atender os clientes:</label><br>
                                 <select class="input-form select-cidade" name="cidade" id="cidade"><br>
                                     <option value="">Escolha uma cidade</option>
                                 </select>

                                 <select class="input-form select-bairro"  name="bairro" id="bairro"><br>
                                     <option value="">Escolha uma cidade primeiro</option>
                                 </select><br>
                                 <textarea class="input-form" name="descricao" id="descricao" cols="30" rows="10"></textarea>
                                 <input class="btn-form-cadastro" type="submit" value="Cadastrar">
                             </form>
                         `);   
         
          montaOptions();
    });

    $("#escolha-cliente").on('click',(e)=>{
         e.preventDefault();
        // $(".container-form-cadastro").empty();
         $(".container-form-cadastro").html(`
                 <form id="cadastroCliente" action="controller/usuarioController.php" method="post" enctype='multipart/form-data'>
                     <label class="label-form-cadastro" for="nome">Selecione uma foto para você:</label><br>
                     <input class="input-form" type="file" name="fotoPerfil" id="fotoPerfil">
                     <input type="hidden" name="op" id="op" value="cadastro">
                     <label class="label-form-cadastro" for="nome">Nome:</label><br>
                     <input class="input-form" type="text" name="nome" id="nome"><br>
                     <label class="label-form-cadastro" for="cpf">Cpf</label><br>
                     <input class="input-form" type="text" name="cpf" id="cpf"><br>
                     <label class="label-form-cadastro" for="email">Email:</label><br>
                     <input class="input-form" type="email" name="email" id="email"><br>
                     <label class="label-form-cadastro" for="senha">Digite uma senha:</label><br>
                     <input class="input-form" type="password" name="senha" id="senha"><br>
                     <label class="label-form-cadastro" for="">Nos diga cidade e bairro onde mora:</label><br>
                                 <select class="input-form select-cidade" name="cidade" id="cidade"><br>
                                     <option value="">Escolha uma cidade</option>
                                 </select>

                                 <select class="input-form select-bairro"  name="bairro" id="bairro"><br>
                                     <option value="">Escolha uma cidade primeiro</option>
                                 </select><br>
                     <input class="btn-form-cadastro" type="submit" value="Cadastrar">
                 </form>
         `);
         montaOptions();
    });
 
    $(document).on("change", "#cidade", function(){
        let idCidade = $(this).val();
        console.log(idCidade);
        puxaCidade(idCidade);
    });

    /*function TestaCPF(strCPF) {
        let Soma;
        let Resto;
        Soma = 0;
        if (strCPF == "00000000000") return false;
        
        for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;
        
        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
        
        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;
        
        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
        return true;
    }*/



});

