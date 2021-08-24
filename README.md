# Instalación

1. ```composer require rodrigorioo/backstrap-laravel```
2. ```php artisan vendor:publish --provider="Rodrigorioo\BackStrapLaravel\BackStrapLaravelServiceProvider"```
3. ```php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"```
4. ```php artisan migrate```
5. ```php artisan db:seed --class=AdministratorSeeder```
6. ```php artisan db:seed --class=RoleSeeder```
7. ```php artisan db:seed --class=ModelHasRoleSeeder```

Con esto nos creara el administrador con los datos:

admin@admin.com : 123456

## License
[MIT](https://choosealicense.com/licenses/mit/)