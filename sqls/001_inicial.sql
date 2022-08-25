CREATE DATABASE receitas COLLATE 'utf8_unicode_ci';

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha CHAR(60) NOT NULL,
    PRIMARY KEY (id)
)
ENGINE = InnoDB;

CREATE TABLE receitas (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    ingredientes TEXT NOT NULL,
    preparo TEXT NOT NULL,
    data_receita timestamp not null default current_timestamp,

    usuario_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
)
ENGINE = InnoDB;

CREATE TABLE comentarios (
    id INT NOT NULL AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    receita_id INT NOT NULL,
    mensagem TEXT NOT NULL,
    data_publicado timestamp not null default current_timestamp,
    PRIMARY KEY (id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ,
    FOREIGN KEY (receita_id) REFERENCES receitas(id) 
)
ENGINE = InnoDB;
