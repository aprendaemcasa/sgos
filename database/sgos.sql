CREATE DATABASE IF NOT EXISTS sgos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sgos;

CREATE TABLE IF NOT EXISTS clientes (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(120) NOT NULL,
 telefone VARCHAR(20) NOT NULL,
 email VARCHAR(150),
 endereco VARCHAR(200)
);

CREATE TABLE IF NOT EXISTS servicos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(120) NOT NULL,
 descricao TEXT,
 valor DECIMAL(10,2) NOT NULL DEFAULT 0.00
);

CREATE TABLE IF NOT EXISTS usuarios (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 senha VARCHAR(255) NOT NULL,
 tipo VARCHAR(30) DEFAULT 'funcionario'
);

CREATE TABLE IF NOT EXISTS ordens_servico (
 id INT AUTO_INCREMENT PRIMARY KEY,
 cliente_id INT NOT NULL,
 servico_id INT NOT NULL,
 usuario_id INT NULL,
 descricao TEXT NOT NULL,
 status ENUM('Aberta','Em andamento','Concluída','Cancelada') DEFAULT 'Aberta',
 data_abertura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 data_prazo DATE NULL,
 valor DECIMAL(10,2) NOT NULL DEFAULT 0.00,
 CONSTRAINT fk_ordem_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id),
 CONSTRAINT fk_ordem_servico FOREIGN KEY (servico_id) REFERENCES servicos(id),
 CONSTRAINT fk_ordem_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
