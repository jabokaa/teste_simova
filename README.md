<h1>Alterações na Regra de Negócio</h1>
Este repositório contém informações sobre as recentes alterações na regra de negócio do projeto. Abaixo estão listados os principais ajustes realizados:

- Restrição para a inclusão de uma data de término: Agora, só é permitida a inclusão de uma data de término se esta for a maior data do mesmo dia da data de inicio.

- A data fim deve ser do mesmo dia da data inicio

- Tratamento de datas de início e fim: Em cenários onde não existe nenhum horário maior no dia e não foi especificada uma data de término, a data de início será automaticamente considerada como a data de término.


<h1> Executando o Sistema </h1>
<h4>Para executar este sistema, é necessário atender a alguns requisitos básicos e configurar o banco de dados. Certifique-se de que você possui os seguintes componentes instalados no seu ambiente:</h4>

Requisitos Básicos:

- Composer
- PHP 7.4 ou superior
- Configuração do Banco de Dados:

Antes de executar o sistema, é necessário configurar o acesso ao banco de dados. Siga as etapas abaixo:

Crie um arquivo env.php na raiz do projeto, se ainda não existir.

Dentro do arquivo env.php, configure as informações de acesso ao banco de dados, incluindo o nome do banco de dados, o nome de usuário e a senha. Por exemplo:

```
<?php

putenv('DB_HOST=localhost');
putenv('DB_PORT=3306');
putenv('DB_DATABASE=simova_teste');
putenv('DB_USERNAME=root');
putenv('DB_PASSWORD=');
```
Execute as queries:
```
CREATE TABLE Employee (
id BIGINT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(50) NOT NULL,
code VARCHAR(10) NOT NULL UNIQUE NOT NULL
);

CREATE TABLE Appointment (
id BIGINT AUTO_INCREMENT PRIMARY KEY,
seq BIGINT UNIQUE NOT NULL,
create_date DATETIME NULL,
update_date DATETIME NULL,
start_date DATETIME NULL,
end_date DATETIME,
total_time BIGINT DEFAULT 0,
id_employee BIGINT NOT NULL,
enabled BOOLEAN NOT NULL DEFAULT true,
description_work VARCHAR(30) NOT NULL,
FOREIGN KEY (id_employee) REFERENCES Employee(id)
);

```


<h4>Instalação das Dependências:</h4>

composer install

<h4>Iniciando o Servidor Local:</h4>

php -S localhost:8080 -t public

Isso iniciará um servidor de desenvolvimento local que estará acessível em http://localhost:8080 no seu navegador.

Agora o sistema está em execução


```
# Script mysql

CREATE TABLE Employee (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    code VARCHAR(10) NOT NULL UNIQUE NOT NULL
);

CREATE TABLE Appointment (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    seq BIGINT UNIQUE NOT NULL,
    create_date DATETIME NULL,
    update_date DATETIME NULL,
    start_date DATETIME NULL,
    end_date DATETIME,
    total_time BIGINT DEFAULT 0,
    id_employee BIGINT NOT NULL,
    enabled BOOLEAN NOT NULL DEFAULT true,
    description_work VARCHAR(30) NOT NULL,
    FOREIGN KEY (id_employee) REFERENCES Employee(id)
);

```


<h4>Rotas criadas:</h4>

| Rota                          | Descrição                      | Tipo  |
| ----------------------------- | ------------------------------- | ----- |
| /                             | Lista de Funcionários          | GET   |
| apontamentos/{idFuncionario}  | Lista de Apontamentos           | GET   |
| employee                      | Criação de Funcionário         | POST  |
| apontamentos                  | Criação de Apontamento          | POST  |
| apontamentos/{id}             | Atualização de Apontamento     | PUT   |
