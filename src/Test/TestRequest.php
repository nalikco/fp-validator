<?php

declare(strict_types=1);

namespace Framework\Test;

use Framework\Validator\ValueValidator\ValueValidator;
use Framework\Web\BaseFormRequest;
use Framework\Web\BaseFormRequest\Field;
use Framework\Web\BaseFormRequest\Fields;

final class TestRequest extends BaseFormRequest
{
    protected $userId;

    public function getUserId(): int
    {
        return (int)$this->userId;
    }

    protected function getFields(): Fields
    {
        $userIdValidator = ValueValidator::init()
            ->isRequired()
            ->isNumber();

        return new Fields(
            new Field('userId', 'userId', $userIdValidator),
        );
    }
}
