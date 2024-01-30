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
