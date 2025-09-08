<h1 align="center">
Projeto TO-DO List (Smart Leader)
</h1>

## Sobre
Aplicação completa para gerenciamento de tarefas (to-do list)

## Tecnologias utilizadas
- Laravel
- Migrate
- Fila assíncrona: Redis
- Job
- Mailpit
- Factory / Seeder
- Mysql
- PHPUnit

## Rodando projeto
### Pré-requisitos
- Git
- Docker

### Passo a Passo
- 1- Clonar o repositório
```
https://github.com/nepogabriel/api-fidelizi.git
```

- 2- Entre no diretório 
```bash
cd fidelizi-api
```

- 3- Configure variáveis de ambiente
```bash
cp .env.example .env
```

- 4- Instale as dependências
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

- 5- Inicie o container
```bash
./vendor/bin/sail up -d
```

- 6- Acesse o container
```bash
docker exec -it fidelizi-api bash
```

- 7- Dentro do container execute para gerar uma chave do laravel
```bash
php artisan key:generate
```

- 8- Dentro do container execute para criar as tabelas do banco de dados e criar seeders
```bash
php artisan migrate --seed
```

- **Observação:** Caso apresente erro ao criar as tabelas do banco de dados, tente os comandos abaixo e execute novamente o comando para criação das tabelas. 
``` bash
# Primeiro comando
docker exec -it fidelizi-mysql bash

# Segundo comando
composer update
```

- 9- Este projeto usa seeders, dentro do container use o comando abaixo
``` bash
php artisan db:seed
```

# Configurar servidor de e-mail
## Dentro do .env informe as credenciais
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=9c90fe016f9g55
MAIL_PASSWORD=********b373d
```

## Processar fila e-mails
- Dentro do container execute:
``` bash
docker exec -it fidelizi-api bash

php artisan queue:work
```

## Processar cronjob
- Dentro do container execute:
``` bash
docker exec -it fidelizi-api bash

php artisan schedule:work
```

# Testes Unitários
- Executar os testes:
``` bash
docker exec -it fidelizi-api bash

php artisan test
```

### Banco de dados
- Porta externa: 33061
- Porta interna: 3306
- Banco de dados: db_fidelizi
- Usuário: root
- Senha:

# Documentação (Endpoints)
- http://localhost:8181/docs/api

## 👥 Contribuidor
Gabriel Ribeiro.
🌐 https://linkedin.com/in/gabriel-ribeiro-br/
