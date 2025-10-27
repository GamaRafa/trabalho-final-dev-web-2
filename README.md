# Cartucho Empoeirado

Esse projeto de uma loja fictícia de games vintage foi desenvolvido como trabalho final da disciplina Desenvolvimento Web II.


## Funcionalidades

## Estrutura do projeto

## Tabelas e relacionamentos

### usuarios

| Campo | Tipo | Descrição |
| -------- | ------- | -------- |
| id | INT (PK) | Identificador do usuário |
| nome | VARCHAR | Nome do usuário |
| email | VARCHAR | E-mail |
| senha | VARCHAR | Senha (hash) |
| endereco | VARCHAR | Endereco para entrega |
| data_cadastro | DATETIME | Data da criação do usuário |
**Relacionamentos:**
- 1 usuário -> N pedidos

### jogos

| Campo | Tipo | Descrição |
| -------- | ------- | -------- |
| id | INT (PK) | Identificador do jogo |
| nome | VARCHAR | Nome do jogo |
| descricao | TEXT | Descrição opcional |
| plataforma | VARCHAR | Ex.: "GameBoy", "SNES" |
| preco | DECIMAL | Preço do jogo |
| estoque | INT | Quantidade disponível |
| imagem | VARCHAR | Caminho/URL da imagem |

**Relacionamentos:**
- 1 jogo - N itens de pedido

### pedidos

| Campo | Tipo | Descrição |
| -------- | ------- | -------- |
| id | INT (PK) | Identificador do pedido |
| id_usuario | INT (FK) | Referência a `usuarios` |
| data_pedido | DATETIME | Data da compra |
| status | VARCHAR | Ex.: "Em andamento", "Concluído", "Cancelado" |
| valor_total | DECIMAL | Soma total dos itens |

**Relacionamentos:**
- N pedidos -> 1 usuário
- 1 pedido -> N itens de pedido

### itens_pedido

| Campo | Tipo | Descrição |
| -------- | ------- | -------- |
| id | INT (PK) | Identificador do item |
| id_pedido | INT (FK) | Referência a `pedidos` |
| id_jogo | INT (FK) | Referência a `jogos` |
| quantidade | INT | Quantidade comprada |
| preco_unitario | DECIMAL | Valor do jogo |

**Relacionamentos:**
- N itens -> 1 pedido
- N itens -> 1 jogo


## Como rodar localmente

### Requisitos

- Docker
- Docker Compose

### Passos para execução

1. Clone o repositório
`git clone https://github.com/GamaRafa/trabalho-final-dev-web-2.git`
ou
`git clone git@github.com:GamaRafa/trabalho-final-dev-web-2.git`

2. Suba os containers
`docker-compose up -d`

3. Acesse o projeto no navegador
`http://localhost:8080`

4. Popular o banco de dados
`docker exec -i mysql_db mysql -uuser -ppass soprando_cartucho < ./src/scripts/init.sql`