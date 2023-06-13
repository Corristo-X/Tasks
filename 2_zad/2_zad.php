<?php
class TextInput {
    protected $value = '';

    public function add($text) {
        $this->value .= $text;
    }

    public function getValue() {
        return $this->value;
    }
}

class NumericInput extends TextInput {
    public function add($text) {
        if(is_numeric($text)) {
            $this->value .= $text;
        }
    }
}
$textInput = new TextInput();
$textInput->add('Hello');
$textInput->add('123');
echo $textInput->getValue(); // Wyświetli 'Hello123'

$numericInput = new NumericInput();
$numericInput->add('Hello');
$numericInput->add('123');
echo $numericInput->getValue(); // Wyświetli '123'

?>