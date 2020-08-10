
# Acerca de Mercatodo-Evertec

Mercatodo es un ecommerce de un proyecto personal en el cual estoy implementando las herramientras de [Laravel](https://laravel.com) para la administracón de: 

- Productos.
- Usuarios.
- Pagos y transacciones.

En el cual se usa una de las mejores pasarelas de pago [Evertec](https://www.evertecinc.com/) para procesar los pagos. 

## Instalación

1.Clone el repositorio desde completo si quiere acceder al historial del repositorio utilicen el comando fetch de Git.

 ```
git fetch --all
 ```

 2.Definas las siguientes variables globales requeridas para conectar con [Mailtrap](https://mailtrap.io/) y [Algolia Engine](https://www.algolia.com/).
 
  ``` 
  MAIL_USERNAME=YOUR MAILTRAP
  MAIL_PASSWORD=YOUR MAILTRAP
  ALGOLIA_APP_ID=YOUR ANGOLIA
  ALGOLIA_SECRET=YOUR ANGOLIA
   ```
3.Dentro de Algolia Engine configurar los atributos de busqueda en, con ese nivel de importancia:
- Nombre.
- Marca
- Description.

4.Habilitar el storage link mediante el siguiente comando en la terminal:

``` 
php artisan storage:link
   ```
5.A usarlo :D.
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
