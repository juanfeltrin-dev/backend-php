FROM centos:7
EXPOSE 80 443 9000
RUN curl https://packages.microsoft.com/config/rhel/7/prod.repo > /etc/yum.repos.d/mssql-release.repo \
    && yum remove unixODBC-utf16 unixODBC-utf16-devel \
    && yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm \
    && export ACCEPT_EULA=y && yum install -y --enablerepo=remi-php73 nginx php-cli php-intl php-pdo php-sqlsrv php-mbstring php-json php-fpm php-memcached php-opcache php-gd php-soap php-mysqlnd php-mcrypt php-xml php-pecl-xdebug php-pecl-zip php-pecl-redis git wget openssh-server \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && HASH="$(wget -q -O - https://composer.github.io/installer.sig)" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer
COPY files/nginx/conf/laravel.conf /etc/nginx/conf.d/
COPY files/php/conf/php-fpm.d/www.conf /etc/php-fpm.d/
COPY files/php/conf/php-fpm.conf /etc/
ADD files/startup.sh /
RUN mkdir -p /var/run/php-fpm.d/ && mkdir -p /var/run/php-fpm/ \
    && chown -R nginx: /var/run/php-fpm.d/ /var/run/php-fpm/ /var/lib/php/ \
    && sshd-keygen -A \
    && chmod 0755 /startup.sh
WORKDIR /var/www/
ENTRYPOINT ["/startup.sh"]
