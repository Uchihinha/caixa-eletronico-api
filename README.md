<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# APIs para sistema de Caixa Eletrônico

Esta aplicação tem como objetivo simular operações de um caixa eletrônico. Foi utilizado o framework PHP Laravel (8.12) + PostgreSQL + Docker.

## Instalação e Configuração

Primeiramente, deve-se ter o Docker instalado no ambiente.

Assumindo isso, clone o projeto e inicie os containers.

```
docker-compose -f "docker-compose.yml" up -d --build
```
Após isso, irá rodar um script de inicialização, o qual ia fazer os seguintes processos:
```
# cria o arquivo de configuração de ambiente
cp .env.example .env

# instala as dependências do projeto
composer install

# cria e configura o banco para os testes
sed -i '12s/.*/DB_HOST=db-test/' .env
php /var/www/app/artisan config:cache
php /var/www/app/artisan migrate
php /var/www/app/artisan passport:install

# cria e configura o banco principal
sed -i '12s/.*/DB_HOST=db/' .env
php /var/www/app/artisan config:cache
php /var/www/app/artisan migrate --seed
php /var/www/app/artisan passport:install
```
Você pode acompanhar todo esse processo acessando os logs em tempo real do container. Para isso, execute o seguinte comando:
```
docker logs --tail 1000 -f <<CONTAINER_ID>>
```
Para saber o ID do container, basta executar o seguinte comando:
```
docker ps
```
e olhar para a coluna "CONTAINER ID".

Após tudo isso configurado, o ambiente estará rodando, por padrão, em seu endereço local na porta 8080, pode ser acessada sua página inicial em [http://localhost:8080](http://localhost:8080).

## A Aplicação
Acompanhe na [documentação](https://documenter.getpostman.com/view/6846169/TzRUAmtU) para um melhor entendimento.

O sistema trabalha com conceito de *roles* (permissões) em 2 níveis, basicamente usuário comum e administrador.

O usuário comum tem acesso aos dados de suas contas bancárias, depósito e saque.

O usuário administrador tem acesso ao gerenciamento de usuários e contas bancárias, sendo o único responsável pela atribuição de uma conta a um usuário.

A documentação tem uma sessão separada para os requests exclusivos de administradores, marcada pela flag (ADMIN).

## Testes
Foi utilizada a própria estrutura do Laravel para os testes da aplicação, sendo eles unitários (*tests/Unit*) e de integração (*tests/Feature*).

Para rodar os testes, basta executar o seguinte comando:
```
php artisan test
```

Também foi criado um banco de dados em um container separado para a realização dos testes de integração.
