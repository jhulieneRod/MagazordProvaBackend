# Use a imagem do PHP
FROM php:7.4-apache

# Copie seu código-fonte para o contêiner
COPY ./agenda /var/www/html

# Instale as extensões do PHP que você precisa para o seu aplicativo
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar o módulo Apache para recarregar em tempo real
RUN a2enmod rewrite
RUN echo "EnableSendfile off" >> /etc/apache2/apache2.conf
RUN service apache2 restart