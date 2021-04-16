FROM node:15

# Create app directory
WORKDIR /var/www/html
COPY src/package*.json ./
EXPOSE 8080

RUN yarn

CMD ["yarn", "serve"]
