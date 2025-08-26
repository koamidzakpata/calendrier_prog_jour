<?php

namespace App;

class Validator {

    private $data;
    protected $errors = [];

    public function __construct(array $data = []) {
        $this->data = $data;
    }

    /**
     * Valide les données d'un évènement
     * @param array $data
     * @return array|bool
     */
    public function validates(array $data) {
        $this->errors = [];
        $this->data = $data;
        return $this->errors;
    }

    public function validate(string $field, string $method, ...$parameters): bool {
        if(!isset($this->data[$field])) {
            $this->errors[$field] = "Le champ $field n'est pas rempli.";
            return false;
        }
        else {
            return call_user_func([$this, $method], $field, ...$parameters);
        }
    }

    public function minLength(string $field, int $length): bool {
        if (mb_strlen($field) < $length) {
            $this->errors[$field] = "Le champ doit faire au moins $length caractères.";
            return false;
        }
        return true;
    }

    public function date (string $field): bool {
        if (\DateTime::createFromFormat('Y-m-d', $this->data[$field]) === false) {
            $this->errors[$field] = "La date ne semble pas valide.";
            return false;
        }
        return true;
    }

    public function time (string $field): bool {
        if (\DateTime::createFromFormat('H:i', $this->data[$field]) === false) {
            $this->errors[$field] = "La temps ne semble pas valide.";
            return false;
        }
        return true;
    }

    public function beforeTime (string $startField, string $endField) {
        if ($this->time($startField) && $this->time($endField)) {
            $début = \DateTime::createFromFormat('H:i', $this->data[$startField]);
            $fin = \DateTime::createFromFormat('H:i', $this->data[$endField]);
            if ($début->getTimeStamp() > $fin->getTimeStamp()) {
                $this->errors[$startField] = "L'heure de début doit être inférieur à l'heure de la fin.";
                return false;
            }
            return true;
        }
        return false;
    }

}

?>