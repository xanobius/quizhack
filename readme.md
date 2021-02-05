# Quiz App

Aim of the project is a realization of a quiz app. The app should be moderated
and in realtime, thus uses websockets. 

The planing can be found [under this miro link](https://miro.com/app/board/o9J_lW5IJ2o=/)

## Participating

First, fork the project via github. Afterwards, clone your fork locally and make
sure to add the original repo as upstream:

```bash
git clone [your-fork]
git remote add upstream [original-repo]
```

Make sure to initialize git flow to have a proper workflow

```bash
git flow init
```

Then start your first feature and lets code!
``` 
git flow feature start myAwesomeFeature
```

When the feature is finished, you can push it and create a pull request via github
``` 
git flow feature publish myAwesomeFeature
```

### Syncing forked branch to original branch
``` 
git merge upstream/develop
```


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

```bash
[project-root]> docker-compose up -d
docker-compose exec app composer install
```

since the framework is in the sub-directory _src_ the npm commands should be executed there

```bash
[project-root]> cd src
npm install
npm run watch
```

Also, the .env file must be added and filled with data and an encryption key (can be done via command)
For the Pusher API, random data can be set, e.q. "local" (the data value doesn't matter, but it must be set)
```dotenv
PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_APP_CLUSTER=mt1
```

```bash
[project-root]> cd src
cp .env.example .env
[change DB settings in .env file]
```

Application secret:

```bash
[project-root]> docker-compose exec app php artisan key:generate
```


start the websocket server (keep terminal open to watch transactions)

```bash
[project-root]> docker-compose exec app php artisan websockets:serve
```


