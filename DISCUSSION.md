For Development:
.env set up credentials
set DB_CONNECTION=mysql

fixed some migrations:
in app service provider-> \Illuminate\Support\Facades\Schema::defaultStringLength(191);
my mysql limit is at 1000bytes, I am using utf8mb4 which is 4 bytes per char
setting the defaultStringLength to 191x4 = safe approach

2026_04_01_172645_create_destinations_table
cannot set default to [] for json-> set to nullable and can handle that in the model if needed
protected $attributes = [
    'activities' => '[]',
];

Uncommented in DestinationExplorer to use DB data, and got some errors
1) on blade- had to default to [] when using implode
2) added cast as an array in model

Uncommented in DestinationController for the API to use the database
Used postman to hit http://localhost:8000/api/destinations to confirm data coming across

Install Sanctum for auth for api endpoints
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate (for creating access tokens table)

add api routes encased in middleware
make sure header in postman is sent as Accept: application/json

I started process of making a checkAPIToken file
I see I don't have a kernel in this project...
I would normally add 'api.token' => \App\Http\Middleware\CheckApiToken::class right into kernel

Instead I will need to add it manually in api route
Added HasApiTokens trait to User model
I used php artisan tinker to create user 
$user = \App\Models\User::create([    'name' => 'API User',    'email' => 'api@example.com',    'password' => bcrypt('password'),]);
$token = $user->createToken('API Token')->plainTextToken;

use that as bearer token when connecting to api endpoints 
1|HiPW0JYKhqFP7eB95KcAqy6Z3u1CZuog4zQXKiPx42885690
