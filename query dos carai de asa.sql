CREATE DATABASE sla DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use sla;

drop database sla;
/* pontuar o cliente  e o profissional dps*/ 

CREATE TABLE cliente(
	id_cliente INT NOT NULL AUTO_INCREMENT,
    nome_cliente VARCHAR(200) NOT NULL,
    cpf_cliente VARCHAR(20),
    senha_cliente VARCHAR(18) NOT NULL,
    email_cliente VARCHAR(200) NOT NULL,
    telefone_cliente VARCHAR(20) NOT NULL,
	PRIMARY KEY (id_cliente)
);

CREATE TABLE profissional(
	id_profissional INT NOT NULL AUTO_INCREMENT,
    nome_profissional VARCHAR(200) NOT NULL,
    cpf_profissional VARCHAR(20) NOT NULL,
    email_profissional VARCHAR(200) NOT NULL,
    senha_profissional VARCHAR(18) NOT NULL,
    telefone_profissional VARCHAR(20) NOT NULL,
    descricao TEXT NOT NULL,
    PRIMARY KEY(id_profissional)
);

CREATE TABLE comentario_cliente_profissional(
	fk_comentario_cliente_profissional_cliente int,
	fk_comentario_cliente_profissional_profissional int,
    texto_comentario text,
    FOREIGN KEY (fk_comentario_cliente_profissional_cliente) REFERENCES cliente(id_cliente),
    FOREIGN KEY (fk_comentario_cliente_profissional_profissional) REFERENCES cliente(id_profissional),
    PRIMARY KEY(fk_comentario_cliente_profissional_cliente,fk_comentario_cliente_profissional_profissional)
);

CREATE TABLE tipo_servico(
	id_tipo_servico INT NOT NULL AUTO_INCREMENT,
    nome_servico VARCHAR(100),
    PRIMARY KEY(id_tipo_servico)
);

CREATE TABLE img_portifolio(
	id_img_portifolio int NOT NULL AUTO_INCREMENT,
    diretorio_foto VARCHAR(255),
    nome_foto VARCHAR(255),
    fk_img_protifolio_profissional INT,
	PRIMARY KEY(id_img_portifolio),
    FOREIGN KEY (fk_img_protifolio_profissional) REFERENCES profissional(id_profissional)
);

CREATE TABLE valida_portifolio(
	id_valida_protifolio INT AUTO_INCREMENT NOT NULL,
    fk_valida_protifolio_img_portifolio int,
    FOREIGN KEY (fk_valida_protifolio_img_portifolio) REFERENCES img_portifolio(id_img_portifolio),
    PRIMARY KEY (id_valida_protifolio, fk_valida_protifolio_img_portifolio)

);

CREATE TABLE foto_perfil(
	id_foto_perfil INT NOT NULL AUTO_INCREMENT,
    diretorio_foto VARCHAR(255),
    nome_foto VARCHAR(255),
    fk_id_cliente INT,
    fk_id_profissional INT,
    PRIMARY KEY(id_foto_perfil,fk_id_cliente,fk_id_profissional),
    FOREIGN KEY(fk_id_cliente) REFERENCES cliente(id_cliente),
    FOREIGN KEY(fk_id_profissional) REFERENCES cliente(id_profissional)
);

CREATE TABLE cidade(
	id_cidade INT NOT NULL AUTO_INCREMENT,
    nome_cidade VARCHAR(30) NOT NULL,
    PRIMARY KEY(id_cidade)
);

CREATE TABLE bairro(
	id_bairro INT NOT NULL AUTO_INCREMENT,
    nome_bairro VARCHAR(200),
    fk_bairro_cidade INT,
    PRIMARY KEY(id_bairro,fk_bairro_cidade),
    FOREIGN KEY(fk_bairro_cidade) REFERENCES cidade(id_cidade)
);

CREATE TABLE atendimento_profissional(
	fk_atendimento_profissional_profissional int,
    fk_atendimento_profissional_cidade int,
    fk_atendimento_profissional_bairro int,
    FOREIGN KEY (fk_atendimento_profissional_profissional) REFERENCES profissional(id_profissional),
    FOREIGN KEY (fk_atendimento_profissional_cidade) REFERENCES cidade(id_cidade),
    FOREIGN KEY (fk_atendimento_profissional_bairro) REFERENCES bairro(id_bairro),
    PRIMARY KEY (fk_atendimento_profissional_profissional,fk_atendimento_profissional_cidade,fk_atendimento_profissional_bairro)
);

CREATE TABLE moradia_cliente(
	fk_moradia_cliente_cliente int,
    fk_moradia_cliente_cidade int,
    fk_moradia_cliente_bairro int,
    FOREIGN KEY (fk_moradia_cliente_cliente) REFERENCES cliente(id_cliente),
    FOREIGN KEY (fk_moradia_cliente_cidade) REFERENCES cidade(id_cidade),
    FOREIGN KEY (fk_moradia_cliente_bairro) REFERENCES bairro(id_bairro),
    PRIMARY KEY (fk_moradia_cliente_cliente,fk_moradia_cliente_cidade,fk_moradia_cliente_bairro)
);

CREATE TABLE profissional_tipo_servico(
	fk_profissional_tipo_servico_profissional INT,
    fk_profissional_tipo_servico_tipo_servico INT,
    FOREIGN KEY (fk_profissional_tipo_servico_profissional) REFERENCES profissional(id_profissional),
    FOREIGN KEY (fk_profissional_tipo_servico_tipo_servico) REFERENCES tipo_servico(id_tipo_servico),
    PRIMARY KEY(fk_profissional_tipo_servico_profissional,fk_profissional_tipo_servico_tipo_servico)
);
	
    SELECT id_img_portifolio, diretorio_foto, nome_foto
        FROM profissional, img_portifolio 
         WHERE  12 = img_portifolio.fk_img_protifolio_profissional GROUP BY id_img_portifolio;
	
	SELECT * FROM foto_perfil, tipo_servico, profissional_tipo_servico, profissional, atendimento_profissional, cidade, bairro
        WHERE profissional.id_profissional = profissional_tipo_servico.fk_profissional_tipo_servico_profissional 
        AND profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico = tipo_servico.id_tipo_servico 
        AND fk_id_profissional = id_profissional AND atendimento_profissional.fk_atendimento_profissional_profissional = id_profissional
        AND atendimento_profissional.fk_atendimento_profissional_bairro = 3 
        AND atendimento_profissional.fk_atendimento_profissional_cidade = 1 
        GROUP BY id_profissional;
        
        SELECT * FROM foto_perfil, tipo_servico, profissional_tipo_servico, profissional, atendimento_profissional, cidade, bairro
        WHERE profissional.id_profissional = profissional_tipo_servico.fk_profissional_tipo_servico_profissional 
        AND profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico = tipo_servico.id_tipo_servico  
        AND fk_id_profissional = id_profissional AND atendimento_profissional.fk_atendimento_profissional_profissional = id_profissional
        AND atendimento_profissional.fk_atendimento_profissional_bairro = 3 
        AND atendimento_profissional.fk_atendimento_profissional_cidade = 1 
        AND profissional.nome_profissional = 'profissional teste 13'
        GROUP BY id_profissional;
    
	select * from profissional, atendimento_profissional, foto_perfil GROUP BY id_profissional;
    
    
    
    
    
    
    
    SELECT * FROM cliente where 'teste' = senha_cliente AND 'lala@gmail.com' = email_cliente;
    
	SELECT id_img_portifolio, diretorio_foto, nome_foto FROM profissional, img_portifolio WHERE 13 = img_portifolio.fk_img_protifolio_profissional;
	select * from foto_perfil,tipo_servico, profissional_tipo_servico, profissional 
	where profissional.id_profissional = profissional_tipo_servico.fk_profissional_tipo_servico_profissional 
	AND profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico = tipo_servico.id_tipo_servico
	AND fk_id_profissional = id_profissional;

   select * from cliente;
   select * from profissional, atendimento_profissional where atendimento_profissional.fk_atendimento_profissional_profissional = profissional.id_profissional;
	
/*INICO DOS INCERTES BASiCOS*/
INSERT INTO tipo_servico (nome_servico)
VALUES ('manicure e pedicure'),('depilação'),('sobrancelhas'),('capilares');

INSERT INTO cidade(nome_cidade) VALUES('recife');

INSERT INTO bairro(nome_bairro, fk_bairro_cidade) VALUES('Boa Vista',1),('São José',1),('Santo Antônio',1),('Santo Amaro',1),('Centro',1);
/*FIM DOS INCERTES BASiCOS*/
select * from profissional , foto_perfil where fk_id_profissional = id_profissional;