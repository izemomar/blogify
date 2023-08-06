FROM node:19.0.0-alpine as node

# workdir
WORKDIR /usr/app

# install vite globally
RUN npm install -g vite

# add entrypoint
COPY ./docker/setup/create-project.entrypoint.sh /usr/local/bin/create-project.entrypoint.sh
RUN chmod +x /usr/local/bin/create-project.entrypoint.sh
ENTRYPOINT [ "sh" , "/usr/local/bin/create-project.entrypoint.sh" ]