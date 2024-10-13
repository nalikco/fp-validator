<?php

declare(strict_types=1);

namespace Framework\Web;

use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Throwable;

abstract class BaseController
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var array
     */
    private $args = [];

    /**
     * @var array
     */
    private $jsonParams;

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    final public function __invoke(Request $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->run();
        } catch (HttpNotFoundException $exception) {
            return $this->error(404, $exception->getMessage());
        } catch (HttpBadRequestException $exception) {
            return $this->error(400, $exception->getMessage());
        } catch (HttpForbiddenException $exception) {
            return $this->error(403, $exception->getMessage());
        } catch (HttpInternalServerErrorException|JsonException $exception) {
            return $this->error(500, $exception->getMessage());
        }
    }

    /**
     * @return ResponseInterface
     * @throws HttpForbiddenException
     * @throws HttpInternalServerErrorException
     * @throws HttpBadRequestException
     * @throws HttpNotFoundException
     *
     * @throws JsonException
     */
    abstract protected function run(): ResponseInterface;

    protected function error(int $code, string $reasonPhrase): ResponseInterface
    {
        $payload = ['error' => $code, 'message' => $reasonPhrase];

        $stringPayload = json_encode($payload, JSON_UNESCAPED_UNICODE);

        $this->response->getBody()->write($stringPayload);

        $this->response = $this->response->withStatus(200)->withHeader('Content-Type', 'application/json');

        return $this->response;
    }

    protected function getArgs(): array
    {
        return $this->args;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return array<string,mixed>
     */
    protected function getQueryParams(): array
    {
        return $this->request->getQueryParams();
    }

    /**
     * Получаем и обрабатываем данные пришедшие в формате json
     * @return array|mixed
     */
    protected function getPostJson()
    {
        if (!isset($this->jsonParams)) {
            $getContents = $this->request->getBody()->getContents();
            $this->jsonParams = json_decode($getContents, true) ?? [];
        }

        return $this->jsonParams;
    }

    protected function notFound(string $reasonPhrase, Throwable $previous = null): HttpNotFoundException
    {
        return new HttpNotFoundException($this->request, $reasonPhrase, $previous);
    }

    protected function badRequest(string $reasonPhrase, Throwable $previous = null): HttpBadRequestException
    {
        return new HttpBadRequestException($this->request, $reasonPhrase, $previous);
    }

    protected function serverError(string $reasonPhrase, Throwable $previous = null): HttpInternalServerErrorException
    {
        return new HttpInternalServerErrorException($this->request, $reasonPhrase, $previous);
    }

    protected function forbidden(string $reasonPhrase, Throwable $previous = null): HttpForbiddenException
    {
        return new HttpForbiddenException($this->request, $reasonPhrase, $previous);
    }

    protected function redirect(string $url = '/'): ResponseInterface
    {
        return $this->response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * Ответ в формате JSON
     * @param array|string $payload
     * @return ResponseInterface
     * @throws JsonException
     */
    protected function responseJson($payload): ResponseInterface
    {
        if (is_string($payload)) {
            $stringPayload = $payload;
        } else {
            $stringPayload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        }

        $this->response->getBody()->write($stringPayload);

        $this->response = $this->response->withStatus(200)->withHeader('Content-Type', 'application/json');

        return $this->response;
    }

    protected function responseHtml(string $html): ResponseInterface
    {
        $this->response->getBody()->write($html);
        return $this->response;
    }

    protected function responseAsCsvFile(string $fileName, StreamInterface $stream): ResponseInterface
    {
        return $this->responseAsFile($fileName, $stream, 'text/csv;charset=cp1251');
    }

    protected function responseAsFile(string $fileName, StreamInterface $stream, string $contentType): ResponseInterface
    {
        return $this->response->withBody($stream)->withHeader(
            'Content-Disposition',
            "attachment; filename=$fileName;"
        )->withHeader(
            'Content-Type',
            $contentType
        );
    }
}
