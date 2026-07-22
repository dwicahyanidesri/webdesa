composer install

Set-ExecutionPolicy RemoteSigned -Scope CurrentUser

npm install

php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve


Login superadmin: 
admin@tanjungagung.desa.id /
 TanjungAgung#2026 
 
 (ganti setelah login pertama, bisa lewat php artisan tinker).


 php artisan migrate --seed
