<?php


namespace Source\Models;


use Source\Core\Model;

class Call extends Model
{

    public function __construct()
    {
        parent::__construct('values_to_call', ['id'], ['origin', 'destiny', 'value']);
    }

    public function bootstrap(string $origin, string $destiny, $value): Call
    {
        $this->origin = $origin;
        $this->destiny = $destiny;
        $this->value = $value;
        return $this;
    }

}
