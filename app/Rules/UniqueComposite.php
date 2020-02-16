<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class UniqueComposite implements Rule
{
    public $table;
    public $column1;
    public $value1;
    public $column2;
    public $value2;
    public $ignore;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $column1, $value1, $column2, $value2, $ignore = null)
    {
        $this->table = $this->resolveTableName($table);
        $this->column1 = $column1;
        $this->value1 = $value1;
        $this->column2 = $column2;
        $this->value2 = $value2;
        $this->ignore = $ignore;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // need to get the model name dynamically later
        $row = DB::table($this->table)
            ->where($this->column1, $this->value1)
            ->where($this->column2, $this->value2)
            ->first();
        if ($row) {
            return $row->id == $this->ignore ? true : false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'An entry with this ' . $this->column1 . ' and ' . $this->column2 . ' already exists.';
    }

    /**
     * Resolves the name of the table from the given string.
     *
     * @param  string  $table
     * @return string
     */
    public function resolveTableName($table)
    {
        if (! Str::contains($table, '\\') || ! class_exists($table)) {
            return $table;
        }

        $model = new $table;

        return $model instanceof Model
                ? $model->getTable()
                : $table;
    }
}
