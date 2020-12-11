
# Acerca de mercatodo

Mercatodo es un ecommerce de un proyecto personal en el cual estoy implementando las herramientras de [Laravel](https://laravel.com) para la administracón de: 

- Gestión de productos, categorias y sus tags.
- Administración de usuarios con sus roles y permisos..
- Carrito de compras con impuestos respectivos.
- Gestión de ordenes para los clientes.
- Generación de reportes en gráficos y exportación en Excel.
- REST-ful API para administración de productos y categorias y su atentificación con Tokens.
- Importación y exportación de productos por Excel.

En el cual se usa una de las mejores pasarelas de pago [Evertec](https://www.evertecinc.com/) para procesarlos.

## Requerimientos

- PHP 7.4+ `required`
- MYSQL 5.7+ `required`

## Instalación

- Clone el repositorio `git clone https://github.com/JhonathanAlfonso/mercatodo.git`.
- Use el gestor de paquetes [composer](https://getcomposer.org/download/).
- Use [npm](https://nodejs.org/es/) para instalar las dependecias del proyecto.
- Si quiere acceder al todo el historial del desarrollo use el comando.
 ```
$ git fetch --all
 ```
- Ejecute los siguiente comandos:
```bash
$ cd mercatodo
$ composer install 
$ npm install 
```

## Ambiente

- Recomendamos el uso de Laravel Valet, se listas las opciones para correr en cada OS:

[Laravel Valet - Windows Subsystem Linux](https://github.com/valeryan/valet-wsl)  
[Laravel Valet - Ubuntu](https://github.com/cpriego/valet-linux)  
[Laravel Valet - iOS](https://laravel.com/docs/8.x/valet)  


## Configuración

Copié el archivo .env.example en .env y agregue cada variables de entornos.

```bash
$ .env.example .env
```

- Variables de entorno:  
`DB_USERNAME` Usuario base de datos.  
`DB_PASSWORD` Password base de datos.  
`MAIL_USERNAME` Usuario Mailtrap para pruebas.  
`MAIL_PASSWORD` Password Mailtrap para pruebas.  
`MAIL_FROM_ADDRESS` Correo del sistema.  
`ALGOLIA_APP_ID` Id de motor de [Algolia](https://www.algolia.com/).  
`ALGOLIA_SECRET` Key de [Algolia](https://www.algolia.com/).  
`PLACE_TO_PAY_LOGIN` Login de [PlaceToPay](https://placetopay.github.io/web-checkout-api-docs/?shell#webcheckout).  
`PLACE_TO_PAY_SECRETKEY` Secret Key de [PlaceToPay](https://placetopay.github.io/web-checkout-api-docs/?shell#webcheckout).  

- Dentro de [Algolia](https://www.algolia.com/) configurar los atributos de busqueda con este nivel de importancia: name, branch, description.

  
- Corra el siguiente script.

```bash
$ php artisan key:generate
$ php artisan migrate --seed
$ php artisan storage:link
```

- Para activar los trabajos encolados, correr:

```bash
$ php artisan queue:work
```

## API REST-ful

- La API REST-ful implementa la especificación [json-api](https://jsonapi.org/).  
- Gestione los productos a través de la API REST-ful. Capacidades: gestión de productos (creación, actualización, eliminación), listado de categorias.

### Autentificación de la API

- La autentificación esta definida a través de Bearer token, para su generación:

 ```js
    let data = {
      email: 'admin@gmail.com',
      password: '123123'
    }
    axios.post('http://localhost/auth', data, {
    }).then(res => {
      console.log(res.data)
    }).catch(err => {
      console.log(err.message)
    })
 ```

- Para el consumo de los servicios usar en todas las consultas el `token_api` obtenido.
- La ruta base para las consultas es http://localhost/admin/api/v1

 ```js
    let data = {
      param1: 'param1',
      param2: 'param2'
    }
    axios.get('http://localhost/admin/api/v1/products', data, {
      headers: {
        Authorization: 'Bearer ' + token_api
      }
      }).then(res => {
      console.log(res.data)
    }).catch(err => {
      console.log(err.message)
    })
 ```

- Ejemplo de respuesta json con especificación `json-api`.

```json
    {
    "data": {
        "type": "products",
        "id": "1",
        "attributes": {
            "name": "Narciso",
            "ean": "17272977",
            "branch": "Hilpert",
            "price": "12000",
            "description": "Distinctio nostrum minus velit iusto reprehenderit. Ratione vero tempora hic consequatur et. Ut sed doloremque repudiandae et cum. Adipisci consectetur repellat sed sint.",
            "category_id": 2,
            "created-at": "2020-12-08T21:44:31-05:00",
            "updated-at": "2020-12-10T21:33:29-05:00"
        },
        "relationships": {
            "categories": {
                "links": {
                    "self": "http://mercatodo.test/api/v1/products/1/relationships/categories",
                    "related": "http://mercatodo.test/api/v1/products/1/categories"
                }
            }
        },
        "links": {
            "self": "http://mercatodo.test/api/v1/products/1"
        }
    }
}
```

## Contribuciones

Puedes hacer tus contribuciones mediantes pull request. Para cambios importantes primero crear un ISSUE.  

Asegurate de actualizar los test apropiadamente.

## License

**Mercatodo** es un proyecto bajo la licencia [MIT license](https://opensource.org/licenses/MIT).
