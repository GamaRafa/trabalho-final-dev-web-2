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

**Relacionamentos:**
- 1 usuário -> N pedidos

**Notas:**
Talvez incluir uma coluna relacionada a adesão de termos usando DATETIME.

### produtos

| Campo | Tipo | Descrição |
| -------- | ------- | -------- |
| id | INT (PK) | Identificador do produto |
| tipo | VARCHAR | Tipo do produto. Jogo ou console |
| nome | VARCHAR | Nome do produto |
| plataforma | VARCHAR | Ex.: GameBoy, SNES |
| preco | DECIMAL | Preço do produto |
| estoque | INT | Quantidade disponível |
| imagem | VARCHAR | Caminho/URL da imagem |
| descrição | TEXT | Descrição opcional |

**Relacionamentos:**
- 1 produto -> N itens de pedido

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
| id_produto | INT (FK) | Referência a `produtos` |
| quantidade | INT | Quantidade comprada |
| preco_unitario | DECIMAL | Valor do produto |

**Relacionamentos:**
- N itens -> 1 pedido
- N itens -> 1 produto


## Como rodar localmente

### Requisitos

### Instalação