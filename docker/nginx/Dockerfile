FROM nginx:1.19

ARG UID
ARG NGINX_FASTCGI_READ_TIMEOUT

RUN adduser -u ${UID} --disabled-password --gecos "" appuser

COPY default.conf /etc/nginx/conf.d/
COPY dev.next.vsgamers.es.conf /etc/nginx/conf.d/

ENV TZ=Europa/Madrid
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
