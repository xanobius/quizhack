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
docker-compose up -d
docker-compose exec app composer install
```

since the framework is in the sub-directory _src_ the npm commands should be executed there

```
cd src
npm run watch
```