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

    public function addError($error)
    {
        return $this->errors[] = $error;
    }

    public function addErrors(array $errors)
    {
        return $this->errors += $errors;
    }

    public function deleteAllErrors()
    {
        return $this->errors = [];
    }
}