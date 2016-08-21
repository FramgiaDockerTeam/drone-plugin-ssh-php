FROM php:7
MAINTAINER thangtd90@gmail.com

COPY entrypoint.php /scripts/entrypoint.php

ENTRYPOINT ["php", "/scripts/entrypoint.php"]
