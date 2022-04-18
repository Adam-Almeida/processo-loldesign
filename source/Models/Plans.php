<?php


namespace Source\Models;


use Source\Core\Model;

class Plans extends Model
{
    public function __construct()
    {
        parent::__construct('plans', ['id'], ['plan', 'minutes']);
    }

    public function bootstrap(string $plan, int $minutes): Plans
    {
        $this->plan = $plan;
        $this->minutes = $minutes;
        return $this;
    }

}
