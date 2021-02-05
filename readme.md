# Quiz App

Aim of the project is a realization of a quiz app. The app should be moderated
and in realtime, thus uses websockets. 

The planing can be found [under this miro link](https://miro.com/app/board/o9J_lW5IJ2o=/)

## Installation

*docker-compose.yml*

Change the network name to avoid conflicts with other docker environments.
Don't forget to change the network name for every container as well.

Prefix your container names with your project name, same reason as above

*docker/nginx/conf.d/site.conf*

Change the domain for your project. Add this domain to your hosts file.

Should you use this scaffold for a framework other than laravel, make sure the document root is according to the settings of that framework ([...]/public/ for laravel)

*.env*

Change the values to your favorite settings.


Now, start the environment and install the dependencies:

```
[project-root]> docker-compose up -d
docker-compose exec app composer install
```

since the framework is in the sub-directory _src_ the npm commands should be executed there

```
[project-root]> cd src
npm install
npm run watch
```

Also, the .env file must be added and filled with data and an encryption key (can be done via command)

```
[project-root]> cd src
cp .env.example .env
[change DB settings in .env file]
```

Application secret:

```
[project-root]> docker-compose exec app php artisan key:generate
```


start the websocket server (keep terminal open to watch transactions)

```
[project-root]> docker-compose exec app php artisan websockets:serve
```
