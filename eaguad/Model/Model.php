<?php namespace EAguad\Model;

use EAguad\Traits\GenerateUUID;

class Model extends \Illuminate\Database\Eloquent\Model {
    use GenerateUUID;

    public $incrementing = false;
}
