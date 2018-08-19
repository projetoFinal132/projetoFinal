CREATE DATABASE sla DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use sla;
/*drop database sla;*/
/* if tipo_usuario == 1 usuario*/
CREATE TABLE usuario(
    email_usuario VARCHAR(200) NOT NULL,
    tipo_usuario TINYINT NOT NULL,
    nome_usuario VARCHAR(200),
    senha_usuario VARCHAR(16),
    diretorio_foto_perfil VARCHAR(255),
    nome_foto_perfil VARCHAR(255),
	CONSTRAINT PRIMARY KEY(email_usuario)
);
CREATE TABLE log_usuario(
	id_log_usuario INT NOT NULL,
    fk_log_usuario_usuario VARCHAR(200) NOT NULL,
    CONSTRAINT FOREIGN KEY (fk_log_usuario_usuario) REFERENCES usuario(email_usuario),
    CONSTRAINT PRIMARY KEY (id_log_usuario,fk_log_usuario_usuario)

);
CREATE TABLE profissional(
	fk_profissional_usuario VARCHAR(200),
	cpf_profissional VARCHAR(11) NOT NULL,
    descricao_profissional TEXT NOT NULL,
    telefone_profissional VARCHAR(255),
    CONSTRAINT FOREIGN KEY(fk_profissional_usuario) REFERENCES usuario(email_usuario),
    CONSTRAINT PRIMARY KEY(fk_profissional_usuario)    
);
CREATE TABLE img_portifolio(
	fk_img_portifolio_usuario VARCHAR(200),
    diretorio_foto VARCHAR(255),
    nome_foto VARCHAR(50),
	PRIMARY KEY(fk_img_portifolio_usuario,nome_foto),
    FOREIGN KEY (fk_img_portifolio_usuario) REFERENCES usuario(email_usuario)
);
CREATE TABLE cidade(
	id_cidade INT AUTO_INCREMENT NOT NULL,
    nome_cidade VARCHAR(60) NOT NULL,
    PRIMARY KEY(id_cidade)
);
CREATE TABLE bairro(
	id_bairro INT AUTO_INCREMENT NOT NULL,
    nome_bairro VARCHAR(100),
    fk_bairro_cidade INT,
    PRIMARY KEY(id_bairro,fk_bairro_cidade),
    FOREIGN KEY(fk_bairro_cidade) REFERENCES cidade(id_cidade)
);
CREATE TABLE atendimento_profissional_cidade(
	fk_atendimento_profissional_usuario VARCHAR(200),
    fk_atendimento_profissional_cidade INT,
    FOREIGN KEY (fk_atendimento_profissional_usuario) REFERENCES usuario(email_usuario),
    FOREIGN KEY (fk_atendimento_profissional_cidade) REFERENCES cidade(id_cidade),
    PRIMARY KEY (fk_atendimento_profissional_usuario,fk_atendimento_profissional_cidade)
);
CREATE TABLE atendimento_profissional_bairro(
	fk_atendimento_profissional_usuario VARCHAR(200) NOT NULL,
    fk_atendimento_profissional_bairro INT NOT NULL,
    atendimento_profissional_bairro_cidade INT NOT NULL,
    FOREIGN KEY (fk_atendimento_profissional_usuario) REFERENCES usuario(email_usuario),
    FOREIGN KEY (fk_atendimento_profissional_bairro) REFERENCES bairro(id_bairro),
    FOREIGN KEY (atendimento_profissional_bairro_cidade) REFERENCES cidade(id_cidade),
    PRIMARY KEY (fk_atendimento_profissional_usuario,fk_atendimento_profissional_bairro, atendimento_profissional_bairro_cidade)
);
CREATE TABLE avaliacao(
	id_comentario INT NOT NULL AUTO_INCREMENT,
    estrela INT NOT NULL,
    comentario VARCHAR(200) NOT NULL,
    fk_avaliacao_usuario VARCHAR(200) NOT NULL,
    fk_avaliacao_profissional VARCHAR(200) NOT NULL,
    FOREIGN KEY(fk_avaliacao_usuario) REFERENCES usuario(email_usuario),
    FOREIGN KEY(fk_avaliacao_profissional) REFERENCES profissional(fk_profissional_usuario),
    PRIMARY KEY(id_comentario, fk_avaliacao_usuario) 
);
 /*INSERT INTO atendimento_profissional_bairro (fk_atendimento_profissional_usuario, fk_atendimento_profissional_bairro, atendimento_profissional_bairro_cidade)
 VALUES('lala69@gmail.com',4,1), ('lala69@gmail.com',4,2), ('lala69@gmail.com',4,3);*/

CREATE TABLE tipo_servico(
	id_servico INT AUTO_INCREMENT NOT NULL,
    nome_servico VARCHAR(100),
    PRIMARY KEY(id_servico)
);

SELECT * FROM avaliacao;
INSERT INTO avaliacao(estrela, comentario, fk_avaliacao_usuario, fk_avaliacao_profissional) VALUES(7,'{$comentario}','{$emailCliente}','{$emailProfissional}');
INSERT INTO avaliacao(estrela, comentario, fk_avaliacao_usuario, fk_avaliacao_profissional) VALUES('','','','');

INSERT INTO tipo_servico (nome_servico)
VALUES ('manicure e pedicure'),('depilação'),('sobrancelhas'),('capilares');

CREATE TABLE profissional_tipo_servico(
	fk_profissional_tipo_servico_usuario VARCHAR(200),
    fk_profissional_tipo_servico_tipo_servico INT,
    FOREIGN KEY (fk_profissional_tipo_servico_usuario) REFERENCES usuario(id_profissional),
    FOREIGN KEY (fk_profissional_tipo_servico_tipo_servico) REFERENCES tipo_servico(id_tipo_servico),
    PRIMARY KEY(fk_profissional_tipo_servico_usuario,fk_profissional_tipo_servico_tipo_servico)
);

/*
INSERT INTO usuario(email_usuario, tipo_usuario, nome_usuario, senha_usuario, diretorio_foto_perfil, nome_foto_perfil)
VALUES ('$profissional->email', 2,'$profissional->nome','$profissional->senha','$profissional->$telefone','$profissional->$descricao');

INSERT INTO profissional(fk_profissional_usuario, cpf_profissional, descricao_profissional, telefone_profissional) 
VALUES('$profissional->email','','','');

INSERT INTO profissional_tipo_servico(fk_profissional_tipo_servico_usuario, fk_profissional_tipo_servico_tipo_servico)
VALUES('$profissional->email','');

INSERT INTO img_portifolio(fk_img_portifolio_usuario, diretorio_foto, nome_foto)
VALUES ('$profissional->email','','');

INSERT INTO atendimento_profissional_cidade()
VALUES ('$profissional->email','');

INSERT INTO atendimento_profissional_bairro()
VALUES ('$profissional->email','');

INSERT INTO img_portifolio(fk_img_portifolio_usuario, diretorio_foto, nome_foto) 
VALUES('$profissional->email', '$img[$i]->diretorioFoto', '$img[$i]->nomeFoto');
*/
INSERT INTO cidade(nome_cidade) VALUES('recife');

INSERT INTO bairro(nome_bairro, fk_bairro_cidade) VALUES('Boa Vista',1),('São José',1),('Santo Antônio',1),('Santo Amaro',1),('Centro',1);

select * from usuario where email_usuario = 'lala@gmail.com';

select * from usuario;
select * from tipo_servico;
select * from profissional;
select * from img_portifolio;
select * from atendimento_profissional_bairro;
select * from bairro;
select * from profissional_tipo_servico;

/* puxar usuario especifico*/
 SELECT tipo_servico.* ,usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
 profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
 cidade.id_cidade, cidade.nome_cidade, bairro.id_bairro, bairro.nome_bairro
 FROM usuario, profissional, tipo_servico, profissional_tipo_servico, cidade, bairro, atendimento_profissional_cidade, atendimento_profissional_bairro
 WHERE usuario.email_usuario = 'lala123123123@gmail.com' AND
 atendimento_profissional_bairro.fk_atendimento_profissional_usuario = 'lala123123123@gmail.com' AND
 atendimento_profissional_cidade.fk_atendimento_profissional_usuario = 'lala123123123@gmail.com' AND
 bairro.id_bairro = atendimento_profissional_bairro.fk_atendimento_profissional_bairro AND
 cidade.id_cidade = atendimento_profissional_cidade.fk_atendimento_profissional_cidade AND
 tipo_servico.id_servico = profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico
 GROUP BY usuario.email_usuario;
 
 /* puxar todos os usuarios especifico*/
 SELECT tipo_servico.* ,usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
 profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
 cidade.id_cidade, cidade.nome_cidade, bairro.id_bairro, bairro.nome_bairro
 FROM usuario, profissional, tipo_servico, profissional_tipo_servico, cidade, bairro, atendimento_profissional_cidade, atendimento_profissional_bairro
 WHERE fk_profissional_usuario = 'lala69@gmail.com' AND usuario.email_usuario = 'lala69@gmail.com' AND 
 atendimento_profissional_bairro.fk_atendimento_profissional_usuario = 'lala69@gmail.com' AND
 atendimento_profissional_cidade.fk_atendimento_profissional_usuario = 'lala69@gmail.com' AND
 bairro.id_bairro = atendimento_profissional_bairro.fk_atendimento_profissional_bairro AND
 cidade.id_cidade = atendimento_profissional_cidade.fk_atendimento_profissional_cidade AND
 tipo_servico.id_servico = profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico AND
 profissional_tipo_servico.fk_profissional_tipo_servico_usuario = 'lala69@gmail.com'
 GROUP BY email_usuario;


select * from atendimento_profissional_bairro WHERE fk_atendimento_profissional_usuario = 'lala123123123@gmail.com';

/* puxar portifolio do profissional*/
SELECT *
FROM usuario
WHERE email_usuario = 'lala74@gmail.com';
select * from usuario where tipo_usuario = 2;


SELECT usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
 profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
 atendimento_profissional_cidade.fk_atendimento_profissional_cidade, atendimento_profissional_bairro.fk_atendimento_profissional_bairro
 FROM usuario, profissional, atendimento_profissional_cidade, atendimento_profissional_bairro
 WHERE usuario.email_usuario = 'lala69@gmail.com'
 GROUP BY usuario.email_usuario;

/* query de buscar bairro da função pega profissional*/
SELECT bairro.id_bairro, bairro.nome_bairro, bairro.fk_bairro_cidade
 FROM  bairro, atendimento_profissional_bairro, cidade
 WHERE atendimento_profissional_bairro.fk_atendimento_profissional_usuario = 'lala@gmail.com' AND
 atendimento_profissional_bairro.atendimento_profissional_bairro_cidade = cidade.id_cidade AND
 atendimento_profissional_bairro.fk_atendimento_profissional_bairro = bairro.id_bairro;

/* query de buscar cidade da função pega profissional*/
SELECT cidade.* 
        FROM cidade, atendimento_profissional_cidade
        WHERE atendimento_profissional_cidade.fk_atendimento_profissional_usuario = 'lala@gmail.com' AND
        atendimento_profissional_cidade.fk_atendimento_profissional_cidade = cidade.id_cidade;

SELECT tipo_servico.* 
 FROM tipo_servico, profissional_tipo_servico, usuario
 WHERE profissional_tipo_servico.fk_profissional_tipo_servico_usuario = usuario.email_usuario AND
 profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico = tipo_servico.id_servico
 group by tipo_servico.id_servico;

SELECT cidade.* 
                FROM cidade, atendimento_profissional_cidade
                WHERE atendimento_profissional_cidade.fk_atendimento_profissional_usuario = 'lala74@gmail.com' AND
                atendimento_profissional_cidade.fk_atendimento_profissional_cidade = cidade.id_cidade;

SELECT * FROM usuario
        WHERE email_usuario = 'lala@gmail.com';

SELECT profissional.* FROM profissional, usuario 
WHERE usuario.email_usuario = 'lala69@gmail.com' AND profissional.fk_profissional_usuario = usuario.email_usuario;


  SELECT tipo_servico.* ,usuario.email_usuario, usuario.nome_usuario, usuario.diretorio_foto_perfil, usuario.nome_foto_perfil, 
 profissional.cpf_profissional, profissional.descricao_profissional, profissional.telefone_profissional,
 cidade.id_cidade, cidade.nome_cidade, bairro.id_bairro, bairro.nome_bairro
 FROM usuario, profissional, tipo_servico, profissional_tipo_servico, cidade, bairro, atendimento_profissional_cidade, atendimento_profissional_bairro
 WHERE fk_profissional_usuario = usuario.email_usuario AND usuario.email_usuario = usuario.email_usuario AND 
 atendimento_profissional_bairro.fk_atendimento_profissional_usuario = usuario.email_usuario AND
 atendimento_profissional_cidade.fk_atendimento_profissional_usuario = usuario.email_usuario AND
 bairro.id_bairro = atendimento_profissional_bairro.fk_atendimento_profissional_bairro AND
 cidade.id_cidade = atendimento_profissional_cidade.fk_atendimento_profissional_cidade AND
 tipo_servico.id_servico = profissional_tipo_servico.fk_profissional_tipo_servico_tipo_servico AND
 profissional_tipo_servico.fk_profissional_tipo_servico_usuario = usuario.email_usuario
 GROUP BY email_usuario;

select * from img_portifolio;

UPDATE img_portifolio SET nome_foto = '{$nomeAntigo}' WHERE fk_img_portifolio_usuario = '{$emailUsuario}' AND nome_foto = '{$nomeAntigo}';

























