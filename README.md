# Logistic - NÃO FINALIZADO (AINDA) FALTA A PARTE DE RESERVA DE ESTOQUE
Olá. Seja bem vindo ao meu projeto para o teste da Lynx.

Para fazer o sistema funcionar navegue até a pasta do projeto e execute o comando:
    - docker-compose up --build -d
Esse comando inicia os containers do NGINX, PHP e MySQL. 

Após a criação dos containers executar o comando do composer:
 - docker run --rm --interactive --tty -v %cd%/lumen:/app composer install
Esse comando instala os vendors.

Para a execução dos testes fiz diretamente na linha de comando do container do PHP. Navegando até a pasta /var/www/html e executando o comando:
 - php vendor/bin/phpunit
Todos os teste realizados são os básicos no sistema.

Algumas considerações sobre o código:
 - Os métodos de verificação dos registro estão retornando como 204 pois estou considerando que o código 404 se aplica a recurso não encontrado.
 - Criei 3 métodos de "mexer" no estoque para facilitar a implementação e não haver muito parametros a serem passados. Um que altera o estoque, um para aumentar e outro para diminuir.
