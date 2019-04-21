# Rest API with lumen 5.7

A RESTful API boilerplate for lumen 5.7. Features included:

- Users Resource
- OAuth2 Authentication using JWT Auth
- Scope based Authorization
- Validation
- Pagination
- Event Handling
- Sending Mail using Mailable class
- Endpoint Tests

## Required

* composer  
* php(version>=7.2)  
* mysql  

### Install lumen
```
$ composer create-project laravel/lumen rest_api
```

### Install JWT Auth
```
$ composer require tymon/jwt-auth
```

### Required Changes:

#### In "bootstrap/app.php" file

```bash
// Uncomment this line
$app->register(App\Providers\AuthServiceProvider::class);

// Add this line
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
```

#### Uncomment from "auth" middleware

```bash
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
]);
```

#### Create "secret token" clients which will be used to generate access tokens:
```bash
php artisan jwt:secret
```

#### Use this trait in user model for authentication:
```bash
use Tymon\JWTAuth\Contracts\JWTSubject
```

#### All needed settings found in following Package:
```bash
https://github.com/tymondesigns/jwt-auth
```

### API Routes

| HTTP Method	| Path | Action | Scope | Desciption  |
| ----- | ----- | ----- | ---- |------------- |
| GET      | /users | index | users:list | Get all users
| POST     | /users | store | users:create | Create an user
| GET      | /users/{user} | show | users:read |  Fetch an user by id
| PUT      | /users/{user} | update | users:write | Update an user by id
| DELETE   | /users/{user} | destroy | users:delete | Delete an user by id

Note: ```users/me``` is a special route for getting current authenticated user.
And for all User routes 'users' scope is available if you want to perform all actions.
