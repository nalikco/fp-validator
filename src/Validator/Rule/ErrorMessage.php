<?php

declare(strict_types=1);

namespace Framework\Validator\Rule;

final class ErrorMessage
{
    private $message;

    public function __construct(
        string $message
    ) {
        $this->message = $message;
    }

    /**
     * Returns an error message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
