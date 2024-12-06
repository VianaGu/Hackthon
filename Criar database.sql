CREATE DATABASE hackthon;
USE hackthon;

-- Tabela Itens
CREATE TABLE itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) COLLATE utf8_bin NOT NULL,
    categoria INT NOT NULL,
    quantidade INT NOT NULL,
    disponibilidade BOOLEAN NOT NULL
);

-- Tabela Usuario
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) COLLATE utf8_bin NOT NULL,
    usuario VARCHAR(255) COLLATE utf8_bin NOT NULL,
    celular VARCHAR(15) COLLATE utf8_bin NOT NULL,
    data_nascimento DATE NOT NULL,
    cpf VARCHAR(14) COLLATE utf8_bin NOT NULL,
    rua VARCHAR(255) COLLATE utf8_bin NOT NULL,
    rua_num VARCHAR(10) COLLATE utf8_bin NOT NULL,
    complemento VARCHAR(255) COLLATE utf8_bin,
    senha VARCHAR(255) COLLATE utf8_bin NOT NULL,
    adm boolean
);

-- Adicionando índices para melhorar a performance em campos com buscas frequentes
CREATE INDEX idx_email ON usuario(email);
CREATE INDEX idx_usuario ON usuario(usuario);
CREATE INDEX idx_celular ON usuario(celular);
CREATE INDEX idx_cpf ON usuario(cpf);

-- Tabela Categoria
CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(255) COLLATE utf8_bin NOT NULL
);

-- Exemplo de como relacionar a tabela Itens à tabela Categoria através de uma chave estrangeira
ALTER TABLE itens
ADD CONSTRAINT fk_categoria
FOREIGN KEY (categoria) REFERENCES categoria(id);

-- Seleciona todos os registros da tabela usuario
-- SELECT * FROM usuario;


 INSERT INTO itens (descricao,  categoria, quantidade, disponibilidade)
 VALUES ('Andador infantil', 2, 1, true);

INSERT INTO categoria (categoria)
VALUE ('Cadeira de Rodas');

INSERT INTO categoria (categoria)
VALUE ('Andador');


-- Tabela de Retiradas
CREATE TABLE IF NOT EXISTS retiradas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    data_retirada DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_prevista_entrega DATE NOT NULL,
    FOREIGN KEY (item_id) REFERENCES itens(id) ON DELETE CASCADE
);

CREATE TABLE historico (
	id INT auto_increment PRIMARY KEY,
    id_Item int,
    id_Usuario int,
    data_retirada int,
    foreign key	(id_Item) REFERENCES itens (id),
    foreign key	(id_Usuario) REFERENCES usuario (id),
    foreign key (data_retirada) REFERENCES retiradas (id)
);
ALTER TABLE itens ADD COLUMN imagem VARCHAR(255);

select * from itens;
