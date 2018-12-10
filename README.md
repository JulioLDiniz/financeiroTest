# financeiroTest
Olá!

Para rodar o projeto, é preciso seguir os passos abaixo:

1 - Criar o banco de dados e ajustar os dados de acesso no arquivo .env. Dei o nome do banco de financeirotest mas fica a critério a nomenclatura. Caso não tenha o arquivo .env é necessário alterar o arquivo .env.example para .env.

2 - Com o banco criado e acesso no diretório do projeto, rode o comando php artisan migrate. Isso vai gerar toda a estrutura necessária dentro do banco de dados (tabelas, relacionamentos, foreign key, etc).

3 - Rode o comando php artisan key:generate para setar uma chave para a aplicação.

4 - Rode o comando jwt:secret para gerar uma chave na qual vai ser usada para geração de tokens do JWT.

5 - Ao fazer a autenticação, use como header da requisição a key 'Authorization' e a key 'Bearer token_criado'. 

