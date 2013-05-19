#!/bin/bash

# Make sure there's parameters.yml file
cp app/config/parameters.yml-dist app/config/parameters.yml

# Install dependencies
php composer.phar install

# Show command list
php app/console
