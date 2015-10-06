<?php

namespace MIM\traits;

/**
 * Class ErrorsTrait
 * @package MIM\traits
 */
trait ErrorsTrait {

    private $errors = [];

    public function getErrors()
    {
        return $this->errors;
    }

    protected function addError($error)
    {
        return $this->errors[] = $error;
    }

    protected function addErrors(array $errors)
    {
        return $this->errors += $errors;
    }

    protected function deleteAllErrors()
    {
        return $this->errors = [];
    }
}