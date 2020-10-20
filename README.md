<p align="center"><a href="https://see.asseco.com" target="_blank"><img src="https://github.com/asseco-voice/art/blob/c5331628a9b5990b40a7ce46db01416599c4d7f6/asseco_logo.png" width="500"></a></p>

# Laravel Redis cache extension

This package enables clearing Redis cache using wildcards.

## Installation

Install the package through composer. It is automatically registered
as a Laravel service provider.

``composer require asseco-voice/laravel-redis-cache-extension``

## Usage

Since this is for Redis driver only, the command will fail if you
don't have ``CACHE_DRIVER=redis`` in your `.env` file.

Running the command ``php artisan voice:flush-redis`` will 
trigger cache flush for all items in the cache (you will be asked
for the confirmation), however the command takes pattern as argument.

When using Redis wildcard characters, argument will need to be 
enclosed within quotation marks:

``php artisan voice:flush-redis "*_item"``
