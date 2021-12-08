FROM php:8.0-cli


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /SparkApi
COPY ./SparkApi ./
RUN composer install
#RUN composer install
EXPOSE 8000
CMD php -S 0.0.0.0:8000 -t public

#docker build -t backend .
#docker run --name backend --net dbwebb -p 8000:8000 backend
