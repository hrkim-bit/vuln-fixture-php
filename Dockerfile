FROM php:latest

WORKDIR /var/www/html
COPY . /var/www/html

ENV AWS_SECRET_ACCESS_KEY="wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY"
ENV DB_PASSWORD="Pa55w0rd!"
ENV SECRET_KEY="django-insecure-do-not-use-0000000000"

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "index.php"]
