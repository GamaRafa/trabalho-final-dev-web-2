-- Criação do banco
CREATE DATABASE IF NOT EXISTS soprando_cartucho;
USE soprando_cartucho;

-- Tabela de usuários
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  senha VARCHAR(255) NOT NULL,
  endereco VARCHAR(255),
  data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de jogos
CREATE TABLE jogos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT,
  plataforma VARCHAR(100),
  preco DECIMAL(10,2) NOT NULL,
  estoque INT DEFAULT 0,
  imagem VARCHAR(255)
);

-- Tabela de pedidos (1..n com usuarios)
CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('ABERTO', 'PAGO', 'CANCELADO') DEFAULT 'ABERTO',
  valor_total DECIMAL (10,2) DEFAULT 0,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Relacionamento n..n entre pedidos e jogos
CREATE TABLE itens_pedido (
  id_pedido INT,
  id_jogo INT,
  quantidade INT DEFAULT 1,
  preco_unitario DECIMAL(10,2),
  PRIMARY KEY (id_pedido, id_jogo),
  FOREIGN KEY (id_pedido) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (id_jogo) REFERENCES jogos(id) ON DELETE CASCADE
);

-- Dados fictícios

-- Usuários
INSERT INTO usuarios (nome, email, senha, endereco) VALUES
('Rafael Gama', 'rafael@fakemail.com', '123456', 'Rua A, 123'),
('Bruna Gama', 'bruna@fakemail.com', '654321', 'Rua B, 456');

-- Jogos
INSERT INTO jogos (nome, descricao, plataforma, preco, estoque, imagem) VALUES
('Super Mario World', 'Clássico do SNES, aventure-se pelos níveis icônicos.', 'SNES', 199.90, 5, 'super_mario_world.jpg'),
('The Legend of Zelda: A Link to the Past', 'Aventura épica no mundo de Hyrule.', 'SNES', 249.90, 3, 'zelda_link.jpg'),
('Metroid II: Return of Samus', 'A caçada de Samus Aran no Game Boy.', 'GameBoy', 199.90, 2, 'metroid_ii.jpg'),
('Pokémon Yellow', 'Aventura clássica de Pokémon.', 'GameBoy', 299.90, 4, 'pokemon_yellow.jpg'),
('Donkey Kong Country', 'Jogo clássico de aventura com gráficos revolucionários para a época.', 'SNES', 139.90, 3, 'donkey_kong_country.jpg');

-- Pedidos
INSERT INTO pedidos (id_usuario, status, valor_total) VALUES
(1, 'PAGO', 449.80),
(2, 'ABERTO', 299.90);

-- Itens de pedidos
INSERT INTO itens_pedido (id_pedido, id_jogo, quantidade, preco_unitario) VALUES
(1, 1, 1, 199.90),
(1, 5, 1, 149.90),
(2, 4, 1, 299.90);

-- Para conectar com o banco dentro do container: docker exec -it mysql_db mysql -u user -p
-- Senha: pass