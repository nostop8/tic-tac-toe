## Main

There are 2 folders: `api` (stands for REST API) and `app` (client web app)

## API (REST)

#### Requirements
- Apache 2+
- PHP 7+
- MySQL 5.7+
- Composer

> In case you are unable to run the console commands (CLI), run `php requirements.php`. It should show to you what your environment is still missing.

#### Installation instructions

- Create empty 2 MySQL databases, e.g. `tictactoe` and `tictactoe_test`. The last is for running tests. 
- Edit `config/db.php` and `config/test_db.php` files: make sure that `db_name` is set to your newly created databases and set your MySQL host, user and pass
- Run `cd api`
- Run `composer install`
- Make sure that folder `runtime` has permissions set to `0777` and `yii` file permissions are set to `0755` (if you are on Unix like machine)
- Run `yii migrate` and `yii_test migrate`. This will create game tables in your databases.


#### Running tests

`php vendor/bin/codecept run --coverage-html`

This command will also generate coverage reports inside the `api/tests/_output/coverage/index.html`

#### Check API DOC tool

 Goto URL `http://<yourhost>/api/documentation`



## APP (WEB)

#### Requirements
 - Node/NPM
 - Angular CLI
 
#### Installation instructions

- Run `cd api`
- Run `npm i`
- Open file `app/src/environments/environment.ts` and adjust `apiUrl` property to your own virtual host (for REST API)
- Run `ng serve`
- Open browser and goto `http://localhost:4200`
- Play the game

#### Running tests

TBD
