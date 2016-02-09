<?php

namespace Nylas\Models;

class Person
{
    public function __construct($name = null, $email = null)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function json()
    {
        return ['name'       => $this->name,
                     'email' => $this->email, ];
    }
}
