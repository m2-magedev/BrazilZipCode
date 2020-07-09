# BrazilZipCode

## Sobre o Módulo

Módulo criado para utilização de serviços de consulta de CEP, já contendo de forma básica consulta pelo ViaCep e Correios.

### Como instalar

#### Instalar via Composer (recomendado)
```
composer require magedev/brazilzipcode
php bin/magento module:enable MageDev_BrazilZipCode
php bin/magento setup;upgrade
```

### Configurações

Para configurar o módulo acesse: Lojas > Configurações > MageDev > Brazil ZipCode

### Como usar a consulta

Em seu javascript (seja para qualquer área da loja que deseja consultar um CEP), faça uma chamada GET para o endpoint abaixo utilizando o cep com ou sem formatação:
```
URL_DA_LOJA/rest/V1/magedev-brazil-zipcode/search/CEP_A_SER_CONSULTADO
https://minhaloja.com.br/rest/V1/magedev-brazil-zipcode/search/08226-021
https://minhaloja.com.br/rest/V1/magedev-brazil-zipcode/search/08226021
```

### Payload de retorno
```
{
    "zip_code": "08226021",
    "street": "Rua 18 de Abril",
    "neighborhood": "Cidade Antônio Estevão de Carvalho",
    "additional_info": "",
    "city": "São Paulo",
    "state": "SP",
    "code": "3550308",
    "data_source": "ViaCep",
    "is_valid": true
}
```
#### Observações: 
- Caso a funcionalidade de persistência no banco de dados esteja ativa, os dados serão armazenados no banco de dados e, em uma consulta posterior ao mesmo CEP, o dado será retornado do banco.
- Caso a funcionalidade de cache esteja ativa, o CEP sejá armazenado no cache, e em uma posterior consulta ao mesmo CEP, o dado será retornado do cache.

### Limpando o cache apenas do módulo
```
php bin/magento cache:clean config_zipcode_search_api
```

### Uso da consulta de CEP por serviços externos (Outras plataformas, sistemas ou postman)

Criar uma chave de integração no Magento e fazer uso do header de Authorization.
