<?php

declare(strict_types=1);

namespace Framework\Test;

use Framework\Web\BaseController;
use Framework\Web\BaseFormRequest\ValidatorException;
use Psr\Http\Message\ResponseInterface;

final class TestController extends BaseController
{
    protected function run(): ResponseInterface
    {
        try {
            $request = new TestRequest($this->getQueryParams());

            return $this->responseJson([
                'success' => 1,
                'message' => $request->getUserId(),
            ]);
        } catch (ValidatorException $e) {
            $error = $e->getValidatorErrors()->first();

            throw $this->badRequest($error->getFieldName() . ': ' . $error->getRule()->getErrorMessage()->getMessage());
        }
    }
}
