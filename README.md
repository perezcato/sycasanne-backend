## Sycasane backend API for both EStores and MFI

This Repo currently has 2 Branches 
1. Master branch - For MFI
2. Estores branch - For Estores

but currently the estores branch is the updated one for both MFi and Estores.

Code Structure
---------------

```bash 
Composer.json - Contains the app metadata (i.e the app name, packages used)
```
```bash
Routes(api.php) - Contains the routes for the application
```
```bash
Resources - Contains the views for the project but in this case the views here for the print page for account details on MFI
```
```bash
app/http/Controllers - Contains the app logic and where the routes execute their actions from
```
```bash
app/http/Middleware - Contains the app middleware that acts on the request in general. The most applicable one being used here is the authentication logic for the app
```
```bash
app/Models - Contains the app for the entities of the app
```
```bash
Config (database.php) - Contains the entire database config for the app
```

Running the project
--------------------
```NB: Make sure you have php and composer installed globally```

```bash
    From the project root execute: composer install 
```
```bash
    php artisan serve
 ```

