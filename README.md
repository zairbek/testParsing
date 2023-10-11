### Запуск проекта

```bash
docker-compose up -d
```

### Установка зависимостей

```bash
docker-compose exec app composer install
```

### После установки зависимостей нужно перезапустит сервисы

```bash
docker-compose down && docker-compose up -d
```

### Пример запроса

```bash
curl --request POST \
  --url http://localhost/api/v1/parsing \
  --header 'Accept: application/json' \
  --header 'Authorization: Basic YWRtaW46YWRtaW4=' \
  --header 'Content-Type: multipart/form-data' \
  --header 'User-Agent: insomnia/8.2.0' \
  --form file=@/Users/zair.nur/Downloads/test.xlsx
```
