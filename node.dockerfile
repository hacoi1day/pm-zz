FROM node:14

# Create app directory
WORKDIR /var/www/html/frontend
COPY frontend/package*.json ./frontend
EXPOSE 8080

RUN yarn install --production=false

CMD ["yarn", "serve"]
