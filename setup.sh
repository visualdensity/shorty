#!/bin/bash

# -------------------
# Setup script
#
# To install as standard dev environment, run:
#   ./setup.sh
#
# If you wish to setup production environment, run:
#   ./setup.sh -p
# -------------------

while getopts ":pud" opt; do
    case $opt in
    d)
        db=1
	    echo "Setting penvironment including database..." >&2
	    ;;
	u)
	    update=1
	    echo "Updating production environment..." >&2
	    ;;
	p)
	    production=1
	    echo "Setting up production environment..." >&2
	    ;;
    esac
done

# get submodules
git submodule init
git submodule update

if [ ! -f "composer.phar" ]; then
    # get latest composer.phar
    curl -s http://getcomposer.org/installer | php
fi

if [ -n "$update" ]; then
    # Install dependencies
    php composer.phar udpate
    php app/console doctrine:schema:update --force
else 
    # Install dependencies
    php composer.phar install
fi

if [ -n "$db" ]; then
    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force
fi

chmod -R 777 app/cache app/logs
php app/console cache:clear
chmod -R 777 app/cache app/logs

# Setup assets and assetics
if [ -n "$production" ]; then
    php app/console assetic:dump --env=prod --no-debug
else
    # Override prod setting and use symlink for assets instead
    php app/console assets:install --symlink --env=dev
    php app/console assetic:dump --env=dev
fi

chmod -R 777 app/cache app/logs
