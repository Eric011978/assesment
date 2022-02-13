# assesment execution

- Composer install
- In .env file db goed neerzetten
- Terminal: php bin/console doctrine:database:create
- Terminal: php bin/console make:migration
- Terminal: php bin/console doctrine:migration:migrate
- Terminal: php bin/console app:import-guidelines
