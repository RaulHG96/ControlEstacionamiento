# Control de estacionamiento

Versiones utilizadas para el proyecto:

| Lenguaje/Framework  | Versión     |
| :------------------ | :---------- |
| PHP                 | 8.0.9       |
| Laravel Framework   | 9.14.1      |
| Node.js             | 16.15.0     |
| NPM                 | 8.5.5       |
| Angular             | 13.3.10     |
| MariaDB             | 10.3.32     |
| Laragon             | 5.0.0       |

La base de datos ya está en las migraciones del Backend (Laravel).

Se requiere correr el siguiente comando para el JWT del Api: 
```php artisan jwt:secret```

**VARIABLES DE ENTORNO ANGULAR**

`urlAPI`:  Variable con la url de la api

`email`: Correo del usuario para la conexión a la Api

`password`: Contraseña del usuario para la conexión a la Api