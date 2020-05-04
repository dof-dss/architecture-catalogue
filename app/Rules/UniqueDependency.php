<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\DB;

use App\Entry;

class UniqueDependency implements Rule
{
    public $column1;
    public $value1;
    public $column2;
    public $value2;
    public $entry1;
    public $entry2;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($column1, $value1, $column2, $value2)
    {
        $this->column1 = $column1;
        $this->value1 = $value1;
        $this->column2 = $column2;
        $this->value2 = $value2;
        $this->entry1 = Entry::findOrFail($value1);
        $this->entry2 = Entry::findOrFail($value2);
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
        $row = DB::table('links')
            ->where($this->column1, $this->value1)
            ->where($this->column2, $this->value2)
            ->first();
        if ($row) {
            return false;
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
        $message = 'A dependency between ';
        $message .= $this->entry1->name . ($this->entry1->version ? '(' . $this->entry1->version . ')' : '');
        $message .= ' and ';
        $message .= $this->entry2->name . ($this->entry2->version ? '(' . $this->entry2->version . ')' : '');
        $message .= ' already exists.';
        return $message;
    }
}
