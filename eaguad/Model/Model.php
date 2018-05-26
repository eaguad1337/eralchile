<?php namespace EAguad\Model;

use App\Traits\GenerateUUID;

class Model extends \Illuminate\Database\Eloquent\Model {
    use GenerateUUID;

    public $incrementing = false;
}
