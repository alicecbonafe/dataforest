# Dataforest

A powerful Laravel Livewire data table component that presents data in a tabular format with advanced features.
# Dataforest

A powerful Laravel Livewire data table component that presents data in a tabular format with advanced features, designed to work with Bootstrap.

## Features

- Pagination
- Sorting (click column headers to sort)
- Filtering (filter data based on column values)
- Global search functionality
- Column visibility control (hide/show columns)
- Column reordering (drag and drop columns)
- Responsive design
- Bootstrap styling
- Export options (CSV, Excel, PDF)

## Installation

You can install the package via composer:

```bash
composer require alicebonafe/dataforest
```

Publish the config file with:

```bash
php artisan vendor:publish --tag="dataforest-config"
```

Optionally, you can publish the views:

```bash
php artisan vendor:publish --tag="dataforest-views"
```

## Bootstrap Integration

Dataforest is designed to work with Bootstrap 5. Make sure to include Bootstrap in your project:

```html
<!-- In your layout file -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
```

## Usage

```php
use Dataforest\Components\DataforestTable;

class UsersTable extends DataforestTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Email', 'email')->sortable()->searchable(),
            Column::make('Created At', 'created_at')->sortable(),
            Column::make('Actions')->view('users.actions'),
        ];
    }

    public function query()
    {
        return User::query();
    }
}
```

In your Blade view:

```blade
<livewire:users-table />
```

## Customizing Bootstrap Styles

You can customize the appearance of the data table by publishing the views and modifying the Bootstrap classes:

```bash
php artisan vendor:publish --tag="dataforest-views"
```

Then edit the published views in `resources/views/vendor/dataforest/`.

## Configuration

You can configure various aspects of the data table in the published config file.

## Credits

- [Your Name](https://github.com/yourusername)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Features

- Pagination
- Sorting (click column headers to sort)
- Filtering (filter data based on column values)
- Global search functionality
- Column visibility control (hide/show columns)
- Column reordering (drag and drop columns)
- Responsive design
- Customizable styling
- Export options (CSV, Excel, PDF)

## Installation

You can install the package via composer:

```bash
composer require alicebonafe/dataforest
```

Publish the config file with:

```bash
php artisan vendor:publish --tag="dataforest-config"
```

Optionally, you can publish the views:

```bash
php artisan vendor:publish --tag="dataforest-views"
```

## Usage

```php
use Dataforest\Components\DataforestTable;

class UsersTable extends DataforestTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Email', 'email')->sortable()->searchable(),
            Column::make('Created At', 'created_at')->sortable(),
            Column::make('Actions')->view('users.actions'),
        ];
    }

    public function query()
    {
        return User::query();
    }
}
```

In your Blade view:

```blade
<livewire:users-table />
```

## Configuration

You can configure various aspects of the data table in the published config file.

## Credits

- [Your Name](https://github.com/yourusername)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
