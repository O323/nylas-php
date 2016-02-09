<?php

namespace Nylas\Models;

use Nylas\NylasAPIObject;

class Contact extends NylasAPIObject
{
    public $collectionName = 'contacts';

    public function __construct($api)
    {
        parent::__construct();
    }
}
