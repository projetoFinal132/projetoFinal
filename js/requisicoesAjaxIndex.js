
    function montaOptions(){
        $.ajax({
            type:'post',
            dataType: 'json',
            data:{
                escolha: 1
            },
            url:'http://localhost/sla/model/puxaRequisicoesIndex.php',
            success:(servicos)=>{
                    
                    for (let index = 0; index < servicos.length; index++) {
                        $('.tipos-servico').append(`
                            <option value="`+servicos[index].id_servico+`">`+servicos[index].nome_servico+`</option>
                        `);
                        console.log(servicos[index].id_servico);
                        console.log(servicos[index].nome_servico);
                    }
                    
            },error: (e)=>{
                console.log(e);
            }
    
        });
         //inicio ajax interno de pegar cidade
         $.ajax({
                        type:'post',
                        dataType: 'json',
                        data:{
                            escolha: 2
                        },
                        url:'http://localhost/sla/model/puxaRequisicoesIndex.php',
                        success:(cidade)=>{
                                
                                for (let index = 0; index < cidade.length; index++) {
                                    $('.select-cidade').append(`
                                        <option value="`+cidade[index].id_cidade+`">`+cidade[index].nome_cidade+`</option>
                                    `);
                                    console.log(cidade[index].id_cidade);
                                    console.log(cidade[index].nome_cidade);
                                }
    
                                
    
                        },error: (e)=>{
                            console.log(e);
                        }
    
                    });   
                    // fim ajax interno de pegar cidade
    

    }

    function puxaCidade(idCidade){
        $.ajax({
            type:'post',
            dataType: 'json',
            data:{
                escolha: 3,
                idCidade: idCidade
            },
            url:'http://localhost/sla/model/puxaRequisicoesIndex.php',
            success:(bairros)=>{
                console.log(bairros);
                    for (let index = 0; index < bairros.length; index++) {
                        $('.select-bairro').append(`
                            <option value="`+bairros[index].id_bairro+`">`+bairros[index].nome_bairro+`</option>
                        `);
                        console.log(bairros[index].id_bairro);
                        console.log(bairros[index].nome_bairro);
                    }
                    
            },error: (e)=>{
                console.log(e);
            }
    
        }); 
    }