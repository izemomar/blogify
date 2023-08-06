#!/bin/bash

set -e

if [ ! -f /usr/app/package.json ]; then
    # create a new Vite project
    echo "Creating a new Vite project..."
    npm init vite@latest ./project -- --template vue-ts

    # move the project files to the root directory
    mv /usr/app/project/* /usr/app

    # remove the project directory
    rm -rf /usr/app/project

    # install the dependencies
    echo "Installing project dependencies..."
    npm install

    echo "A new Vue.js application has been created."
fi

exec "$@"
