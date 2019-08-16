## Processo Seletivo DevSquad

A proposta é aplicar Laravel e Vue.js no desenvolvimento de funcionalidades para administrar os produtos de uma plataforma e-commerce.

### Steps to run

**1. Rename .env.example to .env**

**2. Install dependencies**
```
composer install
yarn
```

**Generate app key:**
```
php artisan key:generate
```

**Run migrates and seed the database...**
```
php artisan migrate
php artisan db:seed
```
