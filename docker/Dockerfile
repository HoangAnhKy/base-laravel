FROM amazonlinux:2023

RUN yum update -y

RUN yum -y install httpd httpd-tools

RUN yum install -y php php-fpm php-common php-mbstring php-xml php-json php-gd php-zip  php-intl \
    php-mysqli php-cli php-core php-mysqlnd php-curl php-bcmath

RUN mkdir -p /run/php-fpm
RUN chmod -R 777 /run/php-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 80

CMD ["/bin/bash", "-c", "php-fpm && /usr/sbin/httpd -D FOREGROUND"]
