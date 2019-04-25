## Dev
    symfony server:start

## PHP CLI
- Create db:
    php bin/console doctrine:database:create
- Create entity:
    php bin/console make:entity Client
- Create schema:
    php bin/console doctrine:migrations:diff
- Run migration / Update
    php bin/console doctrine:migrations:migrate

- Query:
    php bin/console doctrine:query:sql 'SELECT * FROM client'