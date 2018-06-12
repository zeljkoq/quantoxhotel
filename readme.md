# Quantox Hotel

> Application to manage party organizations in Quantox Hotel

## Quick Start

``` bash
# Install Dependencies
composer install

# Run Migrations
php artisan migrate

# Import User Roles
php artisan db:seed

# Add virtual host if using Apache

# If you get an error about an encryption key
php artisan key:generate
```

## Additional informations

#### This application uses JWT Auth as main authentication system. When you run  `composer install` you should be go to go, however, if you get some errors, you will need to make some changes 

### JWT quick start

``` bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

php artisan jwt:secret

# config/auth.php file

    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],
    
    ---
    
        'guards' => [
            'web' => [
                'driver' => 'session',
                'provider' => 'users',
            ],
    
            'api' => [
                'driver' => 'jwt',
                'provider' => 'users',
            ],
        ],

```

``` bash
# If above does not work, start with this
# JWT Auth package that works with Laravel 5.6

"tymon/jwt-auth": "^1.0.0-beta.3@dev"


# Find jwt.php config file and in that file change this

'jwt' => 'Tymon\JWTAuth\Providers\JWT\Namshi',
'auth' => 'Tymon\JWTAuth\Providers\Auth\Illuminate',
'storage' => 'Tymon\JWTAuth\Providers\Storage\Illuminate'

```

## Endpoints

### User login
``` bash
POST api/login

{  
	"email" : "mail@example.com",
	"password" : "password"
}
```

### User registration
``` bash
POST api/register-user

{    
	"name" : "Full Name",
	"email" : "mail@example.com",
	"password" : "password",
	"passwordConfirm" : "password"
}
```

### Get current user info
``` bash
POST api/auth/me

{
    "user": {
        "id": 1,
        "name": "Full Name",
        "email": "mail@wxample.com",
        "created_at": "2018-06-12 07:08:25",
        "updated_at": "2018-06-12 07:08:25"
    }
}
```
### Logout user
``` bash
POST api/auth/logout

{
    "message": "Successfully logged out"
}
```


## Songs manipulation
``` bash
# Songs can be added only by DJs
```

### Add song
``` bash
POST api/song/add

{
	"artist" : "Artist Name",
	"track" : "Track Name",
	"link" : "Link",
	"Duration" : "In minutes, only floats/integers"
}

You will receive this

{
    "data": {
        "artist": "Artist Name",
        "track": "Track Name",
        "link": "Link",
        "duration": "1.25",
        "edit": "http://laravel.local/edit/1", # Edit link
        "id": 1, # Song ID
        "admin": "1", # If user is DJ you will receive this boolean
        "user": "0",
        "updated_by": "Users Full Name",
        "updated_at": "1 second ago"
    }
}

```

### Edit song by it's ID

``` bash
GET api/song/edit/{song_id}

This route will get song informations

{
    "song": {
        "id": 1,
        "artist": "Artist",
        "track": "Track",
        "link": "Link",
        "duration": 1.25,
        "updated_by": 1,
        "created_at": "2018-06-12 07:08:33",
        "updated_at": "2018-06-12 07:08:33",
        "delete": "http://laravel.local/api/song/delete/1", # Delete link
        "edit_index": "http://laravel.local/edit/1" # Edit link
    }
}

```

### Update song

``` bash
GET api/song/update/{song_id}

# All fileds are required. In case you try to update with some empty field, you will receive this

{
    "message": "The given data was invalid.",
    "errors": {
        "artist": [
            "The artist field is required."
        ],
        "track": [
            "The track field is required."
        ],
        "link": [
            "The link field is required."
        ],
        "duration": [
            "The duration field is required."
        ]
    }
}

# Otherwise, you will get this

{
    "data": {
        "artist": "Artist Name",
        "track": "Track Name",
        "link": "Link",
        "duration": "1.22",
        "edit": "http://laravel.local/edit/1",
        "id": 1,
        "admin": "1",
        "user": "0",
        "updated_by": "Full Name",
        "updated_at": "1 second ago"
    }
}

```

### Delete song

``` bash
DEL api/song/delete/{song_id}

# If song does not exists you will receive this message

{
    "message": "Song with ID of 333 does not exists"
}

# Otherwise, you will get this, which you can append into songs table

{
    "data": {
        "artist": "Artist Name",
        "track": "Track Name",
        "link": "Link",
        "duration": 1.22,
        "edit": "http://laravel.local/edit/1",
        "id": 1,
        "admin": "1",
        "user": "0",
        "updated_by": "Full Name",
        "updated_at": "9 minutes ago"
    }
}

```


## App Info

### Author

Zeljko Marenovic
Quantox Hotel

### Version

1.0.0