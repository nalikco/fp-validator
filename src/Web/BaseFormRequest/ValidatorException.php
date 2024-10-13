<?php

declare(strict_types=1);

namespace Framework\Web\BaseFormRequest;

use Exception;
use Framework\Validator\Error\ValidatorErrors;

class ValidatorException extends Exception
{
    private $validatorErrors;

    public static function withValidatorErrors(ValidatorErrors $errors): self
    {
        $instance = new self();
        $instance->validatorErrors = $errors;

        return $instance;
    }

    /**
     * Returns a list of validator errors.
     */
    public function getValidatorErrors(): ValidatorErrors
    {
        return $this->validatorErrors;
    }
}
