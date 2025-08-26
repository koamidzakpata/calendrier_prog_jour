<?php

namespace Calendar;

use App\Validator;

class EventValidator extends Validator
{
    /**
     * Valide les données d'un évènement
     * @param array $data
     * @return array|bool
     */
    public function validates(array $data)
    {
        parent::validates($data);
        $this->validate('nom', 'minLength', 3);
        $this->validate('date', 'date');
        $this->validate('début', 'beforeTime', 'fin');
        return $this->errors;
    }
}
