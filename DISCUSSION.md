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

