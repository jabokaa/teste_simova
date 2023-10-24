
# Desafio Simova

Objetivo desse desafio é criar uma API Rest.

## Contexto

O Desafio vai ser criar uma API para receber dados de Apontamentos de um Funcionário para registrar as suas tarefas realizadas no dia, vamos trabalhar com 3 rotas: Inserção, Alteração e Obtenção dos dados.

### Inserção

Ao inserir um novo Apontamento somente serão enviados os dados:

- Data inicial do Apontamento;
- Funcionário;
- Trabalho Realizado;
- Data Final só enviado no último apontamento do dia.

Com isso você vai aplicar as seguintes regras:

- seq: Vai ser um sequencial único que vai ser gerado a cada novo apontamento
- end_date: A Data Final sempre será a Data Inicial do Apontamento Anterior, se não tiver apontamento Anterior, será a Data Atual;
- total_time: É a diferente entre a data final e inicial em segundos, para saber o tempo total da tarefa

### Alteração

Ao realizar uma alteração só poderão ser enviados:

- Id
- Data Inicial
- Ativo (Possivel desativar um registro)

Ao realizar a alteração da Data é necessário realizar o cálculo da data inicial e final dos apontamentos

### Obtenção

Ter uma rota para obter os dados de Apontamentos por funcionário, nela precisamos saber:

- Todos os Apontamentos Ativos do Funcionário
- Tempo total de cada apontamento
- Enviar no retorno o total de apontamentos

Para sabermos quando tempo foi gasto em cada atividade


## Itens obrigatórios

###  Frameworks

- Php >= 7.4
- Twig
- Slim
- Composer
- Phpunit
- MySQL
- PDO

### Design Patterns

- MVC

### Comunicação API

- JSON
- Descreva no README de forma simples como utilizar a sua funcionalidade e exemplos

### Tabelas

#### Appointment

Tabela onde terá apontamentos de Horas

| Coluna   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `bigint` | **Obrigatório**. Chave única e auto incrementável |
| `seq`      | `bigint` | **Obrigatório**. sequencial único |
| `create_date`      | `datetime` | **Obrigatório**. Data de criação do registro |
| `update_date`      | `datetime` | **Obrigatório**. Data de alteração do registro |
| `start_date`      | `datetime` | **Obrigatório**. Data Inicial do apontamento |
| `end_date`      | `datetime` | Data final do apontamento, padrão NULL |
| `total_time`      | `bigint` | Tempo total do apontamento (end_date - start_date) em segundos, padrão 0|
| `id_employe`      | `bigint` | **Obrigatório**. Chave Estrangeira para o Funcionário|
| `enabled`      | `boolean` | **Obrigatório**. Ativo ou não, padrão true|
| `description_work`      | `varchar(30)` | **Obrigatório**. Descrição do trabalho realizado |

#### Employee 

Tabela de Funcionários

| Coluna   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `bigint` | **Obrigatório**. Chave única e auto incrementável |
| `name`      | `varchar(50)` | **Obrigatório**. Nome do funcionário |
| `code`      | `varchar(10)` | **Obrigatório**. Código do Funcionário |


### Item não obrigatório

- Não é necessário realizar autenticação na API
- Não precisar ser Restful
- Docker não é obrigatório, se você já possuir experiência pode utilizar
- Não é necessário 100% de coverage no tests, faça apenas nas funções que você acredite ser as mais importantes e com grande impacto

## Dicas

- Mais é menos, mas não seje muito genérico
- Se atente ao Prazo de Entrega
- Se não for possível terminar, entregue até onde conseguiu fazer
