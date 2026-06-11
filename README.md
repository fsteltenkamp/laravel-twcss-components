# Laravel TWCSS Components

A collection of TailwindCSS components for Laravel's Blade component library.

## Installation

```bash
composer require fsteltenkamp/laravel-twcss-components
```

The service provider is auto-discovered via Laravel's package discovery.

## Usage

Components are registered under the `twcss` namespace:

```blade
<x-twcss::button variant="primary">
    Save
</x-twcss::button>

<x-twcss::button variant="danger" type="submit">
    Delete
</x-twcss::button>
```

## Publishing

Publish views to override them:

```bash
php artisan vendor:publish --tag=twcss-components-views
```

## License

AGPL-3.0-only
