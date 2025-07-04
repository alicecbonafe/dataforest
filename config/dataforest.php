<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Styling
    |--------------------------------------------------------------------------
    |
    | Choose the default styling for the data table. Options are:
    | 'tailwind' - Tailwind CSS styling
    | 'bootstrap' - Bootstrap 5 styling
    | 'custom' - Use your own custom CSS
    |
    */
    'styling' => 'custom',

    /*
    |--------------------------------------------------------------------------
    | Default Pagination Options
    |--------------------------------------------------------------------------
    |
    | Default options for items per page in the pagination dropdown
    |
    */
    'per_page_options' => [10, 25, 50, 100],

    /*
    |--------------------------------------------------------------------------
    | Default Per Page
    |--------------------------------------------------------------------------
    |
    | The default number of items to show per page
    |
    */
    'per_page' => 10,

    /*
    |--------------------------------------------------------------------------
    | Enable Features
    |--------------------------------------------------------------------------
    |
    | Enable or disable specific features of the data table
    |
    */
    'features' => [
        'pagination' => true,
        'sorting' => true,
        'filtering' => true,
        'global_search' => true,
        'column_visibility' => true,
        'column_reordering' => true,
        'export' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Export Options
    |--------------------------------------------------------------------------
    |
    | Configure export functionality
    |
    */
    'export' => [
        'formats' => ['csv', 'excel', 'pdf'],
        'default_format' => 'csv',
    ],

    /*
    |--------------------------------------------------------------------------
    | Debounce Time
    |--------------------------------------------------------------------------
    |
    | The debounce time in milliseconds for search and filter inputs
    |
    */
    'debounce' => 300,

    /*
    |--------------------------------------------------------------------------
    | Empty State Message
    |--------------------------------------------------------------------------
    |
    | The message to display when there are no records
    |
    */
    'empty_message' => 'No records found',
];
