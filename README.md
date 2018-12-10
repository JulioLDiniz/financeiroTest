# financeiroTest
Olá!

Esse projeto foi desenvolvido usando PHP7.2, Mysql como SGBD, Laravel como framework PHP e JWT para autenticação por token. Tem por objetivo ajudar no controle financeiro, criando, editando, deletando e listando registros além de dar baixa em registros já previamente cadastrados.

Para rodar o projeto, é preciso seguir os passos abaixo:

1 - Criar o banco de dados e ajustar os dados de acesso no arquivo .env. Dei o nome do banco de financeirotest mas fica a critério a nomenclatura. Caso não tenha o arquivo .env é necessário alterar o arquivo .env.example para .env.

2 - Dentro do diretório da aplicação, rode o comando composer install para a configuração de dependências do projeto.

3 - Com o banco criado e acesso no diretório do projeto, rode o comando php artisan migrate. Isso vai gerar toda a estrutura necessária dentro do banco de dados (tabelas, relacionamentos, foreign key, etc).

4 - Rode o comando php artisan key:generate para setar uma chave para a aplicação.

5 - Rode o comando jwt:secret para gerar uma chave na qual vai ser usada para geração de tokens do JWT.

6 - Ao fazer a autenticação, use como header da requisição a key 'Authorization' e o value 'Bearer token_criado'. 

