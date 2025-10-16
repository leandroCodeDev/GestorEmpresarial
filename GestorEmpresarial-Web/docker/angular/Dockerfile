# Etapa 1: Build Angular
FROM node:20 AS build

WORKDIR /app

# Copia package.json e package-lock.json para cache de dependências
COPY ./package*.json ./
RUN npm install -g @angular/cli && npm install

# Copia todo o código
COPY . .

# Build de produção (output em dist/meu-projeto-angular)
RUN ng build --configuration production --output-path=dist/angular

# Etapa 2: Servir com Apache
FROM httpd:2.4

# Ativar módulos rewrite e deflate
RUN sed -i '/^#LoadModule rewrite_module/s/^#//' /usr/local/apache2/conf/httpd.conf && \
    sed -i '/^#LoadModule deflate_module/s/^#//' /usr/local/apache2/conf/httpd.conf

# Copia build Angular para a pasta do Apache
COPY --from=build /app/dist/angular /usr/local/apache2/htdocs/angular


# Copia vhost e inclui
COPY ./docker/angular/apache/vhost.conf /usr/local/apache2/conf/extra/vhost.conf
RUN echo "Include conf/extra/vhost.conf" >> /usr/local/apache2/conf/httpd.conf

EXPOSE 80
CMD ["httpd-foreground"]
