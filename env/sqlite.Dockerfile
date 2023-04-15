FROM alpine

RUN apk add --no-cache sqlite
VOLUME /var/db

ENTRYPOINT ["sqlite3"]
