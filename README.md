# example-nginx-mysql-php-docker

## Step 1

### Instalar o Docker e docker-compose

```
$ sudo apt install docker.io

$ sudo apt install docker-compose

```

Configurar o Docker - groupadd

```
# Create groupadd docker
$ sudo groupadd docker

# add your user to docker group
$ sudo usermod -aG docker ${USER}

# You would need to loog out and log back in so that your group membership is re-evaluated
# or type the following command:

$ su -s ${USER}

# verify that you can run docker commands without sudo:
$ sudo docker run hello-world
```


## Step 2
Git clone projeto em sua instancia e inicia os container docker
```
$ git clone git@github.com:ademirrocha/docker-api-php.git
$ cd docker-api-php
$ docker-compose up -d --build
```

## Step 3
Configurar o mysql
```
# Entrar no container do bando de dados
$ docker-compose exec mydb bash

# Acessar o banco para alterar a senha
$ mysql -u root -p
# Enter password default 'root'

# Execute comandos sql:
mysql> use mysql;
mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'novasenha';
mysql> FLUSH PRIVILEGES;

# Criar o banco de dados
mysql> CREATE DATABASE backend_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Sair do mysql(Não esqueca de anotar a senha!)
mysql> exit;

# Sair do container do DB
$ exit

```

### Step 4

#### Configurar o container backend

```
# Entrar no container do backend
$ docker-compose exec backend ash
```

### Step 5

#### Configuração do .env

```
$ cd /backend
$ vim ./.env

# Alterar as configurações necessarias.
# Pressionar Ctrl + c | Ctrl + zz para salvar as alterações

## Save .env.backup

```


### Adicionar certificado ssl

Baixa os certificados e adiciona na pasta backend/certs
Concactena os aquivos em new_cert.crt como comando abaixo


```
# Criar diretorio 'certs' (se não existir), na raíz do backend
# Criar os arquivos certificate.crt, ca_bundle.crt e private.key
# Colar os conteúdos dos certificados nos repectivos arquivos criados

# Rodar o comando abaixo para concactenar os arquivos em um novo arquivo: new_cert.crt
$ cat certificate.crt ca_bundle.crt >> new_cert.crt
```

### Criar Zona DNS no LightSail

Usar o dominio seudominio.com

Criar um Registro A na Zona DNS, resolvida no IP da Aplicação

Adicionar na hospedagem (Hostgator como exemplo) um Registro A, no enderço IP da aplicação no LightSail
