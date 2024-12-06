create database hackthon;

use hackthon;
-- Tabela Itens
CREATE TABLE itens ( 
    id INT IDENTITY(1,1) PRIMARY KEY, -- IDENTITY substitui AUTO_INCREMENT
    descricao VARCHAR(255) NOT NULL,
    codigo_item INT NOT NULL,
    categoria INT NOT NULL,
    quantidade INT NOT NULL,
    disponibilidade BIT NOT NULL -- Substituir TINYINT(1) por BIT para valores booleanos
);


-- Tabela Usuario
CREATE TABLE usuario (
    id INT IDENTITY(1,1) PRIMARY KEY, -- IDENTITY substitui AUTO_INCREMENT
    email VARCHAR(255) NOT NULL,
    usuario VARCHAR(255) NOT NULL,
    celular VARCHAR(15) NOT NULL,
    data_nascimento DATE NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    rua VARCHAR(255) NOT NULL,
    rua_num VARCHAR(10) NOT NULL,
    complemento VARCHAR(255),
    senha VARCHAR(255) NOT NULL,
    adm BIT NOT NULL -- Substituir BOOLEAN por BIT
);


-- Adicionando índices para melhorar a performance em campos com buscas frequentes
CREATE INDEX idx_email ON usuario(email);
CREATE INDEX idx_usuario ON usuario(usuario);
CREATE INDEX idx_celular ON usuario(celular);
CREATE INDEX idx_cpf ON usuario(cpf);


-- Tabela Categoria
CREATE TABLE categoria (
    id INT IDENTITY(1,1) PRIMARY KEY,
    categoria VARCHAR(255) NOT NULL
);

-- Exemplo de como relacionar a tabela Itens à tabela Categoria através de uma chave estrangeira
ALTER TABLE itens
ADD CONSTRAINT fk_categoria
FOREIGN KEY (categoria) REFERENCES categoria(id);

select * from usuario;
