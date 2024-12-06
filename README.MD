## Como Executar o Projeto

1. Clone o repositório:
   ```bash
   git clone https://github.com/lucassempre/ZapBot
   ```

2. Edite o env.template de acordo com suas necessidades e renomeie-o para .env:
    ```bash
    cp env.template .env
    ```
   
4. Execute o Docker:
    ```bash
    docker compose -it app php artisan migrate
    ```

5. Aguarde a inicialização. Sua aplicação estará pronta para uso. Caso queira realizar os testes, execute o seguinte comando após a aplicação estar funcionando:
    ```bash
    docker exec -it app php artistan test -v 2
    ```