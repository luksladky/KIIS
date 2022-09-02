FROM php:7.0-apache
LABEL Lukas Sladky <lusladky@gmail.com>

USER root

RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite
