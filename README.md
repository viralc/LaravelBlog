# LaravelBlog

### Installation

run on command line

```git clone https://github.com/viralc/LaravelBlog.git```

```cd LaravelBlog```

```cp .env.example .env```

```composer install```

```php artisan key:generate```

### Config env file
Edit .env add your mysql details:
```php
DB_DATABASE=yourdb
DB_USERNAME=root
DB_PASSWORD=secret
```


run on command line

```php artisan db:seed --class="BlogsTableSeeder"```

```php artisan serve```


### User name and Password
```username = admin@admin.com```
```password = admin```
