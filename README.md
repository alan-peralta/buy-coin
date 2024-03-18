# Olá, este é um teste com WESOME API

Para iniciar o projeto basta subir o mesmo no docker

```
docker compose up -d
```

Em algumas vezes o entrypoint não está rodando a migrate, talvez seja necessário entrar no container para executar o comando

Existe um collection do POSTMAN disponível no projeto


Front com apenas um tela de consuta de cotação, no momento ainda estou com problema de CSRF-TOKEN


Optei em criar uma estrutura desacoplada para consulta da cotação, assim é mais fácil há implementação de uma outra API para cotação, como por exemplo fixer.io.
Basta fazer a integração implementando a interface GetQuoteServiceInterface 

Criei dois commands, um para buscar as moedas que estão disponível na api e salvar na tabela coins, outro para buscar os câmbios disponível e salvar na tabela coin_combinations, a tabela orders é para criar um histórico das  transações do usuário que começa a valer desde o momento em que ele informa o valor que ele pretende comprar de um certa moeda.

## Cobetura de Teste 
Total: 77.0 %

![Cobertura de Teste](https://i.ibb.co/cTWK8xR/Captura-de-tela-2024-03-17-023016.png)

## Banco de dados
![Cobertura de Teste](https://i.ibb.co/QN9sgty/Estrutura-do-banco.png)
