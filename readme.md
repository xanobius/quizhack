# Simple docker scaffold

Can be used with laravel

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
