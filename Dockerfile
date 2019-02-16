FROM php:7.3.2-cli-alpine3.8
RUN apk update && apk add make
WORKDIR "/application"