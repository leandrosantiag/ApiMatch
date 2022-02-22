# Api Match - JWT - Symfony 6 - Docker

Api para gstão de matriculas, cursos, alunos e usuários.

### 📋 Pré-requisitos

Você precisa ter instalado o Git e Docker compose
* [Instalar Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
* [Instalar Docker compose](https://docs.docker.com/compose/install/)


### 🔧 Instalação

Faça uma cópia do projeto e execute o container usando com os comandos abaixo.

```
git clone https://github.com/leandrosantiag/ApiMatch
cd ApiMatch
docker-compose up --build
```

E mais um comando para montar o seu banco de dados.

```
docker-compose exec php bin/console doctrine:migrations:migrate
```

### ⚙️ Consumindo API

Registre um novo usuario para usar a API.
