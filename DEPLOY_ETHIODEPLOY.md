# Deploy Aqiqah Laravel app to EthioDeploy (Free)

## Project facts

- Laravel 13 (`laravel/framework` `^13.17`)
- PHP `^8.3`
- MySQL
- Blade + Vite + Tailwind CSS 4

EthioDeploy detects Laravel from `artisan` and `composer.json`. It installs Composer dependencies and builds Vite assets automatically. Do not add a Dockerfile or custom build command.

## Before the first deploy

1. Push this project to a GitHub repository.
2. In EthioDeploy, create a project from that repository.
3. Add a **MySQL** database addon.
4. Add these project environment variables:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR-PROJECT-SLUG.ethiodeploy.app
APP_KEY=
DB_CONNECTION=mysql
QUEUE_CONNECTION=sync
CACHE_STORE=database
SESSION_DRIVER=database
SUPERADMIN_NAME=Super Admin
SUPERADMIN_EMAIL=your-admin-email@example.com
SUPERADMIN_PASSWORD=CHOOSE_A_UNIQUE_STRONG_PASSWORD
```

Leave `APP_KEY` empty on the first deployment if EthioDeploy is configured to generate and persist it automatically. Do not reuse the local `.env` key.

The MySQL addon supplies `DATABASE_URL`. `config/database.php` has been adjusted to let Laravel read it through `DB_URL` as a fallback.

Replace `APP_URL` with the actual project URL after choosing the project slug. Keep `APP_DEBUG=false`.

## Start command

Set the custom **Start command** to:

```bash
php artisan migrate --force && php artisan db:seed --class=ProductionSuperAdminSeeder --force && ethiodeploy-start
```

Keep the default build/install commands. The platform's `ethiodeploy-start` command warms caches and starts nginx/PHP-FPM.

The production seeder creates a super-admin only when the `SUPERADMIN_EMAIL` and `SUPERADMIN_PASSWORD` environment variables are set. It uses `firstOrCreate`, so it will not reset the password on every redeploy.

**Do not run the default `DatabaseSeeder` in production.** It contains sample accounts with predictable demo passwords.

## Important free-plan limitations

- The app sleeps after 30 minutes without traffic; the first request after sleep can take longer.
- MySQL storage is limited to 512 MB on the free plan.
- The app filesystem is ephemeral. User-uploaded animal images stored in `storage/app/public` can disappear on redeploy.
- For durable uploads, configure an S3-compatible object-storage service and change the upload implementation/disk to `s3` before using real user uploads.
- Keep backups of important database data.

## After deployment

1. Open the public URL and check the home page.
2. Sign in using the super-admin email/password configured above.
3. Register a test DKM account and approve it from the super-admin dashboard.
4. Test catalog creation, chat, and image uploads (do not rely on local uploads until durable object storage is configured).
5. Check application logs if any page returns an error.

## Security

- Never commit `.env`.
- Never commit database passwords, `APP_KEY`, SMTP credentials, or object-storage keys.
- Use a unique production super-admin password.
- Do not turn `APP_DEBUG` on in production.
