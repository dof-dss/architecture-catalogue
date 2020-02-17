<?php

namespace App\Repositories\Eloquent;

use App\Entry;
use App\Repositories\Interfaces\StatusRepositoryInterface;

class StatusRepository implements StatusRepositoryInterface
{
    protected $statuses = [
        'approved',
        'unapproved',
        'prohibited',
        'retiring',
        'evaluating'
    ];

    protected $labels = [
        'approved' => 'label--green',
        'unapproved' => 'label--black',
        'prohibited'=> 'label--red',
        'retiring' => 'label--orange',
        'evaluating' => 'label--blue'
    ];

    public function all()
    {
        return $this->statuses;
    }

    public function labels()
    {
        return $this->labels;
    }
}
