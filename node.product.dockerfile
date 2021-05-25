FROM node:14

# Create app directory
WORKDIR /var/www/html/frontend
COPY /frontend/package.json /frontend/yarn.lock /var/www/html/frontend/

# RUN yarn

# RUN yarn build