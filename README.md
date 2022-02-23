# Api Match - JWT - Symfony 6 - Docker

Api para gstão de matriculas, cursos, alunos e usuários.

### 📋 Pré-requisitos

Você precisa ter instalado o Git e Docker compose
* [Instalar Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
* [Instalar Docker compose](https://docs.docker.com/compose/install/)


### 🔧 Instalação

Faça uma cópia e acesse a pasta do projeto o comando abaixo.

```
git clone https://github.com/leandrosantiag/ApiMatch
cd ApiMatch
```

Mais alguns comandos para montar o seu container com o projeto e banco de dados.

```
docker-compose up -d
docker-compose exec php composer update
docker-compose exec php bin/console doctrine:migrations:migrate
```

### ⚙️ Consumindo a API


#### Autenticação
HEADER application/json

Crie um usuário e depois faça o login para obter um token de acesso.

| URI path       | Resource class           | HTTP methods | Notes                                                                                                |
|----------------|--------------------------|--------------|------------------------------------------------------------------------------------------------------|
| /api/register | AuthController | POST         | {     "username": "string",     "password": "string" } |
| /api/login    | AuthController | POST         | {    "username": "string",    "password":"string"}            

#### Cursos
HEADER application/json

HEADER authorization

O token de autorização deve ser fornecido com a ação desejada. Exemplo: `Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9....`

| URI path    | Resource class  | HTTP methods | Notes                                       |
|-------------|-----------------|--------------|---------------------------------------------|
| /api/cursos       | CursosController | GET          | Listar todos os cursos                            |
| /api/cursos/{id}  | CursosController | GET          | Obter um curso específico pela Id      |
| /api/cursos/      | CursosController | POST         | Criar um novo curso {"titulo": "string", "descricao": "string", "data_inicio": "date", "data_fim": "date", "status": "int"}     |
| /api/cursos/{id}  | CursosController | PUT          | Alterar um curso {"titulo": "string", "descricao": "string", "data_inicio": "date", "data_fim": "date", "status": "int"} |
| /api/cursos/{id}  | CursosController | DELETE       | Remover um curso específico pela Id   |

#### Alunos
HEADER application/json

HEADER authorization

| URI path    | Resource class  | HTTP methods | Notes                                       |
|-------------|-----------------|--------------|---------------------------------------------|
| /api/alunos       | AlunosController | GET          | Listar todos os alunos                            |
| /api/alunos/{id}  | AlunosController | GET          | Obter um aluno específico pela Id      |
| /api/alunos/      | AlunosController | POST         | Criar um novo aluno {"nome": "string", "email": "string", "data_nascimento": "date", "status": "int"}     |
| /api/alunos/{id}  | AlunosController | PUT          | Alterar um aluno {"nome": "string", "email": "string", "data_nascimento": "date", "status": "int"} |
| /api/alunos/{id}  | AlunosController | DELETE       | Remover um aluno específico pela Id   |

#### Matrículas
HEADER application/json
HEADER authorization

| URI path    | Resource class  | HTTP methods | Notes                                       |
|-------------|-----------------|--------------|---------------------------------------------|
| /api/matriculas       | MatriculasController | GET          | Listar todas as matrículas                            |
| /api/matriculas/{id}  | MatriculasController | GET          | Obter uma matrícula específica pela Id      |
| /api/matriculas/      | MatriculasController | POST         | Criar uma nova matrícula {"curso": "int", "aluno": "int"}     |
| /api/matriculas/{id}  | MatriculasController | PUT          | Alterar uma matrícula {"curso": "int", "aluno": "int"}  |
| /api/matriculas/{id}  | MatriculasController | DELETE       | Remover uma matrícula específica pela Id   |

