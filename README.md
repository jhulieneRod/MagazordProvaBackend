# MagazordProvaBackend

Para instalação do projeto necessário executar os seguintes comandos:

--Clonar o repositório
git clone https://github.com/jhulieneRod/MagazordProvaBackend.git

--Criar o container docker WEB e Mysql
docker-compose up -d

--Atualizar as dependências do Composer
composer update

--Acessar o link 127.0.0.1:8081

OBS: Caso o banco de dados não seja criado automaticamente, executar os seguintes comandos:

**docker exec -it magazordprovabeckend-db-1 mysql -uroot -p

**digitar a senha: #test-magazord#

**Executar o script do arquivo script_db.sql