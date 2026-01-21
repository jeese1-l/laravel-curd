<?php

namespace App\Models\<namespace>;
use DateTimeInterface;

class <model>Model extends BaseModel
{
    protected $table ='<table>';
    const UPDATED_AT = "update_time";
    const CREATED_AT = "create_time";

    /**
    * Prepare a date for array / JSON serialization.
    *
    * @param  \DateTimeInterface  $date
    * @return string
    */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

