<?php

declare(strict_types=1);

namespace Validator;

use Framework\Validator\Field\Field;
use Framework\Validator\Field\Fields;
use Framework\Validator\Validator;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    public function testPassed(): void
    {
        $fields = new Fields();

        $fields->add(
            Field::key('data.name')
                ->isString('message for is_string')
                ->isNotEmpty('message for is_not_empty')
        );

        $fields->add(
            Field::key('data.description')
                ->isString('message for is_string')
                ->isNotEmpty('message for is_not_empty')
        );

        $data = [
            'data' => [
                'name' => 'John Doe',
                'description' => 'I am a description',
            ],
        ];

        $errors = Validator::validate($fields, $data);

        $this->assertTrue($errors->isEmpty());
    }

    public function testNotPassedOneError(): void
    {
        $fields = new Fields();

        $fields->add(
            Field::key('data.name')->isNotEmpty('message for is_not_empty')
        );

        $fields->add(
            Field::key('data.description')
                ->isString('message for is_string')
                ->isNotEmpty('message for is_not_empty')
        );

        $data = [
            'data' => [
                'description' => 'I am a description',
            ],
        ];

        $errors = Validator::validate($fields, $data);

        $this->assertEquals(1, $errors->getCount());
        $this->assertEquals('message for is_not_empty', $errors->all()[0]->getMessage());
    }
}
