<?php

namespace App\Repositories;

use App\Entry;
use App\Repositories\Interfaces\CategoriesRepositoryInterface;

class CategoriesRepository implements CategoriesRepositoryInterface
{

    protected $categories = array(
        'Business Applications' => array(
            'Information Consumer Applications',
            'Brokering Applications',
            'Information Provider Applications',
            'Shared Services Applications'
        ),
        'Infrastructure Applications' => array(
            'Productivity',
            'Development Tools',
            'Libraries',
            'Management Utilities',
            'Storage Management Utilities'
        ),
        'Application Platform' => array(
            'Software Engineering Services',
            'Operating System Services',
            'Security Services',
            'Human Interaction Services',
            'Data Interchange Services',
            'Data Management Services',
            'Network Services'
        ),
        'Technology Platforms' => array(
            'Hosting Services',
            'Infrastructure as a Service',
            'Platform as a Service',
            'Software as a Service'
        ),
        'Physical Infrastructure' => array(
            'Data Centres',
            'Data Networks',
            'End User Devices',
            'Server Devices'
        ),
        'Other' => array(
            'Not categorised'
        )
    );

    public function all()
    {
        return $this->categories;
    }
}
