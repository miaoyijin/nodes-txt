FROM centos:7

ENV INSTALL_PHP_DIR=/opt/app/php72 \
INSTALL_NGINX_DIR=/opt/app/nginx
ADD php/php-7.2.24.tar.bz2 /tmp/
RUN rm -f /etc/yum.repos.d/epel.repo
RUN  echo '[epel]' >> /etc/yum.repos.d/epel.repo
RUN  echo 'name=base' >>  /etc/yum.repos.d/epel.repo
RUN  echo 'baseurl=http://mirrors.aliyun.com/epel/7/x86_64' >> /etc/yum.repos.d/epel.repo
RUN  echo 'enabled=1' >> /etc/yum.repos.d/epel.repo
RUN  echo 'gpgcheck=0' >> /etc/yum.repos.d/epel.repo

RUN yum -y install epel-release && \
    yum -y install gcc gcc-c++ gd-devel libxml2 libxml2-devel libcurl-devel \
    openssl openssl-devel curl curl-devel libjpeg libjpeg-devel libpng  \
    freestyle freestyle-devel pcre pcre-devel libxslt libxslt-devel bzip2 bzip2-devel \
    php-mcrypt libmcrypt libmcrypt-devel freetype-devel libpng-devel \
    openldap-devel libtidy-devel gmp-devel autoconf re2c libsodium-devel && \
    yum -y install ImageMagick-devel && \
    yum -y install wget && \
    yum -y install tar && \
    yum clean all -y

# Timezone
RUN cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime \
    && echo 'Asia/Shanghai' > /etc/timezone \
RUN tar -jxvf /tmp/php-7.2.24.tar.bz2 -C /tmp \
    && cd /tmp/php-7.2.24 \
    && ./configure --prefix=${INSTALL_PHP_DIR} \
    --with-config-file-path=${INSTALL_PHP_DIR}/etc \
    --disable-ipv6 \
    --enable-bcmath \
    --enable-dba \
    --enable-ftp \
    --enable-mbstring \
    --enable-sockets \
    --enable-exif \
    --enable-opcache \
    --enable-pcntl \
    --enable-soap \
    --enable-zip \
    --with-curl \
    --with-iconv \
    --with-gettext \
    --with-gd \
    --with-gmp \
    --with-freetype-dir \
    --with-jpeg-dir \
    --with-png-dir \
    --with-mcrypt \
    --with-mhash \
    --with-openssl \
    --with-tidy \
    --with-zlib \
    --with-mysqli=mysqlnd \
    --with-pdo-mysql=mysqlnd \
    --enable-fpm \
    --enable-xml \
    && make && make install \
    && cp ./sapi/fpm/init.d.php-fpm /opt/app/php72/sbin/init.d.php-fpm \
    && chmod +x /opt/app/php72/sbin/init.d.php-fpm \
    && groupadd -g 2000 httpd \
    && useradd -g 2000 -u 2000 httpd \
    && mkdir -p /opt/logs/php72 && chown httpd. /opt/logs/php72 \
    && rm -r /tmp/php-7.2.24
COPY php/etc/ ${INSTALL_PHP_DIR}/etc
RUN /opt/app/php72/bin/pecl install redis && /opt/app/php72/bin/pecl install mongodb \
&& echo "extension=redis.so" >> ${INSTALL_PHP_DIR}/etc/php.ini \
&& echo "extension=mongodb.so" >> ${INSTALL_PHP_DIR}/etc/php.ini

COPY nginx/nginx-1.12.1.tar.gz /tmp/
RUN tar -zxvf /tmp/nginx-1.12.1.tar.gz -C /tmp \
    && cd /tmp/nginx-1.12.1 \
    && ./configure \
    --prefix=${INSTALL_NGINX_DIR} \
    --conf-path=/usr/local/nginx/conf/nginx.conf \
    --pid-path=/usr/local/nginx/conf/nginx.pid \
    --lock-path=/var/lock/nginx.lock \
    --error-log-path=/var/log/nginx/error.log \
    --http-log-path=/var/log/nginx/access.log \
    --with-http_gzip_static_module \
    --http-client-body-temp-path=/var/temp/nginx/client \
    --http-proxy-temp-path=/var/temp/nginx/proxy \
    --http-fastcgi-temp-path=/var/temp/nginx/fastcgi \
    --http-uwsgi-temp-path=/var/temp/nginx/uwsgi \
    --http-scgi-temp-path=/var/temp/nginx/scgi
RUN mkdir -p /var/temp/nginx/client && mkdir /opt/app/php72/var/logs/ \
&& mkdir /opt/app/php72/logs/
RUN cd /tmp/nginx-1.12.1 && make && make install
RUN chown -R httpd:httpd /opt
COPY nginx/conf/ ${INSTALL_NGINX_DIR}/conf/
EXPOSE 80 443 9000
CMD /opt/app/nginx/sbin/nginx && /opt/app/php72/sbin/php-fpm --nodaemonize
