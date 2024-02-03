instalado node y boostrap 
@vite(['resources/css/app.css','resources/scss/app.scss', 'resources/js/app.js'])
copy .env.example .env
git config user.name
git config user.email

After cloning reppository:
- composer install
- npm install

And after:
- npm i bootstrap --save-dev
- npm install sass --save-dev
- npm addd -D sass
- npm i bootstrap-icons

## .Env
DB_DATABASE=baygaming

mailtrap para el vendor

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=d920fa699198e3
MAIL_PASSWORD=87a27fa835994d
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="BayGaming@no-reply.com"
MAIL_FROM_NAME="${APP_NAME}"

# relations
```return $this->belongsTo(review::class);```
en caso de no especificar if forania coge por defecto [Nombre de la Tabla]+_id

# middleware
Un middleware es un puente que existe entre la petición que un usuario hace a una ruta y el controlador.
 `` php artisan make:middleware AdminMiddleware``
https://programacionymas.com/blog/restringir-acceso-solo-administradores-laravel-usando-middlewares

# routes group
https://codersfree.com/courses-status/aprende-laravel-avanzado/grupo-de-rutas

# foreign id nullable quitar
``'reviews_id' => null,``

    public function __construct()
    {
        if (Auth::check() && Auth::user()->role != 'admin') {
            abort(403, 'Acceso no autorizado.');
        }
    }
# ver vista de errores
```PS C:\xampp\htdocs\BayGaming> php artisan vendor:publish --tag=laravel-errors```