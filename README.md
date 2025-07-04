# Dataforest

A powerful Laravel Livewire data table component that presents data in a tabular format with advanced features.

## Features

- Pagination
- Sorting (click column headers to sort)
- Filtering (filter data based on column values)
- Global search functionality
- Column visibility control (hide/show columns)
- Column reordering (drag and drop columns)
- Responsive design
- Customizable styling (Tailwind, Bootstrap, or Custom CSS)
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

This will create a `config/dataforest.php` file in your project, where you can configure the default styling and other options.

## Styling

Dataforest supports three styling options out of the box:

- `tailwind`: For projects using Tailwind CSS.
- `bootstrap`: For projects using Bootstrap 5.
- `custom`: For your own custom CSS.

You can set the default styling in the `config/dataforest.php` file.

### Custom Styling

If you choose the `custom` styling option, you'll need to publish the assets:

```bash
php artisan vendor:publish --tag="dataforest-assets"
```

This will publish the CSS and JS files to `public/vendor/dataforest`. You can then include them in your layout file:

```html
<!-- In your layout file -->
<link href="{{ asset('vendor/dataforest/css/dataforest.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/dataforest/js/dataforest.js') }}"></script>
```

You can also publish the views to customize the table's HTML structure:

```bash
php artisan vendor:publish --tag="dataforest-views"
```

## Usage

Create a new Livewire component that extends `Dataforest\Components\DataforestTable`:

```php
use Dataforest\Components\DataforestTable;
use App\Models\User;

class UsersTable extends DataforestTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Email', 'email')->sortable()->searchable(),
            Column::make('Created At', 'created_at')->sortable(),
        ];
    }

    public function query()
    {
        return User::query();
    }
}
```

In your Blade view, render the Livewire component:

```blade
<livewire:users-table />
```

## Configuration

You can configure various aspects of the data table in the `config/dataforest.php` file, including:

- Default number of items per page
- Pagination options
- Feature toggles (sorting, filtering, etc.)
- Export formats
- Debounce time for search inputs

## Credits

- [Alice Bonafe](https://github.com/alicebonafe)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
