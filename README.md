# assesment execution

Installeren composer packages

```bash
composer install
```

Database instellingen goed zetten in de .env

```bash
DATABASE_URL="mysql://root:root@127.0.0.1:3306/assesment?serverVersion=5.7"
```

Met Doctrine db aanmaken

```bash
php bin/console doctrine:database:create
```

Voorbereiden data migratie

```bash
php bin/console make:migration
```

Met Doctrine data migreren

```bash
php bin/console doctrine:migration:migrate
```

Nieuwe import draaien na aanmaken db / nieuwe tabellen

```bash
php bin/console app:import-guidelines
```
