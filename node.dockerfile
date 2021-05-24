FROM node:14

# Create app directory
WORKDIR /var/www/html/frontend
COPY /frontend/yarn.lock /var/www/html/frontend/
EXPOSE 8080

RUN yarn install

CMD ["yarn", "serve"]
