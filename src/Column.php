<?php

namespace Dataforest;

class Column
{
    public $label;
    public $field;
    public $sortable = false;
    public $searchable = false;
    public $filterable = false;
    public $view = null;
    public $format = null;
    public $hidden = false;
    public $attributes = [];

    /**
     * Create a new column instance.
     *
     * @param string $label The column label
     * @param string|null $field The database field
     * @return void
     */
    public function __construct(string $label, ?string $field = null)
    {
        $this->label = $label;
        $this->field = $field;
    }

    /**
     * Create a new column instance.
     *
     * @param string $label The column label
     * @param string|null $field The database field
     * @return static
     */
    public static function make(string $label, ?string $field = null)
    {
        return new static($label, $field);
    }

    /**
     * Make the column sortable.
     *
     * @param bool $sortable
     * @return $this
     */
    public function sortable(bool $sortable = true)
    {
        $this->sortable = $sortable;
        return $this;
    }

    /**
     * Make the column searchable.
     *
     * @param bool $searchable
     * @return $this
     */
    public function searchable(bool $searchable = true)
    {
        $this->searchable = $searchable;
        return $this;
    }

    /**
     * Make the column filterable.
     *
     * @param bool $filterable
     * @return $this
     */
    public function filterable(bool $filterable = true)
    {
        $this->filterable = $filterable;
        return $this;
    }

    /**
     * Set a view to render for this column.
     *
     * @param string $view
     * @return $this
     */
    public function view(string $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Set a format callback for this column.
     *
     * @param callable $callback
     * @return $this
     */
    public function format(callable $callback)
    {
        $this->format = $callback;
        return $this;
    }

    /**
     * Hide this column by default.
     *
     * @param bool $hidden
     * @return $this
     */
    public function hidden(bool $hidden = true)
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * Add HTML attributes to the column.
     *
     * @param array $attributes
     * @return $this
     */
    public function attributes(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * Convert the column to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'label' => $this->label,
            'field' => $this->field,
            'sortable' => $this->sortable,
            'searchable' => $this->searchable,
            'filterable' => $this->filterable,
            'view' => $this->view,
            'format' => $this->format,
            'hidden' => $this->hidden,
            'attributes' => $this->attributes,
        ];
    }
}
