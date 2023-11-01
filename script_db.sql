CREATE DATABASE IF NOT EXISTS provamagazord;
USE provamagazord;

-- Criação da tabela Pessoa
CREATE TABLE IF NOT EXISTS Pessoa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(11) NOT NULL UNIQUE
);

-- Criação da tabela Contato
CREATE TABLE IF NOT EXISTS Contato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo BOOLEAN NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    id_pessoa INT NOT NULL,
    FOREIGN KEY (id_pessoa) REFERENCES Pessoa(id)
);