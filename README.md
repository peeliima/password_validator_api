
# Password Validator Api

A password validator api é um serviço que testa senhas e valida se ela está seguindo
as regras escolhidas pelo usuário.



## Instalação

1 - Crie um arquivo .env aparti do .env.example na pasta raiz do projeto:

```bash
cp .env.example .env
```

2 - Suba o container através do docker-compose: Ps: Nessa etapa pode ocorrer conflito
com a porta do container que foi escolhida, caso aconteça, entre no arquivo docker-compose.yml
e mude a porta 8101:80 para uma porta disponível no seu sistema 8080:80

```bash
    docker-compose up -d
```

3 - Acesse o terminal do container e entre na pasta do projeto:

```
docker exec -it password_validator_api bash
cd home/project-folder
```

4 - Instale as dependências do projeto:

```
composer install
```

5 - Gere a chave da aplicação

```
php artisan key:g
```

6 - Configure as permissões do projeto:

```
chown www-data -R storage/
```
## Documentação da API

#### Valida a senha de acordo com as regras

```http
  POST /verify
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `password`  | `string`   | **Obrigatório**. A senha que deseja validar |
| `rules`     | `array`    | **Obrigatório**. As regras que deseja usar na validação da senha |

#### Exemplo de como montar a payload

{"password": "qwertQWERT!@00", "rules": [{
		"rule": "minSize",
		"value": 8
		},
		{
		"rule": "minUppercase",
		"value": 4
		},
		{
		"rule": "minLowercase",
		"value": 4
		},
		{
		"rule": "minSpecialChars",
		"value": 2
		},
		{
		"rule": "noRepeted",
		"value": 0
		}]
}

####Caso não queira alguma regra, basta remove-la.

####Caso não queira nenhuma regra, o payload deve ser montado da seguinte forma:

{"password": "qwertQWERT!@00", "rules": [{	}]}


## Autores

- [@Pedro Lima](https://github.com/peeliima/)
