# Test-PHP

### Dependencias

- PHP 7.4
- Phalcon 4.0.5
- phpunit/phpunit 9.0
- phalcon/incubator-test 1.0.0-alpha.1
- phalcon/migrations 2.1
- vlucas/phpdotenv 5.5

## Preparar ambiente de desarrollo

- Instalar `Docker`, Ir a https://www.docker.com/get-started
- Executar el comando `docker-compose up -d` el cual prepara los servicios de la api y estara disponible
  en http://localhost:5000
- Instalar dependencias
  ```bash  
  $ docker-compose exec api composer install
  ```

### Preparar la base de datos

- Renombrar el archivo `.env.example` por `.env`

```bash 
$ docker-compose exec api ./devcli db synchronize
```

### Para correr las pruebas unitarias

```bash 
$ docker-compose exec api php ./vendor/bin/phpunit
  ```
