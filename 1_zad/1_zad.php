<?php
class Pipeline
{
    protected $stages;

    public function make(...$stages)
    {
        $this->stages = $stages;

        return function($arg) {
            return $this->process($arg);
        };
    }

    protected function process($payload)
    {
        foreach ($this->stages as $stage) {
            $payload = $stage($payload);
        }

        return $payload;
    }
}

// Tworzymy nowy obiekt Pipeline
$pipeline = new Pipeline();

// Utworzenie funkcji przez make
$pipeline_func = $pipeline->make(
    function($var) { return $var * 3; },
    function($var) { return $var + 1; },
    function($var) { return $var / 2; }
);

// Wywołanie funkcji z argumentem 3
echo $pipeline_func(3); // Wypisze 5
?>