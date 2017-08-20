<?php

namespace Applicant;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Dispatcher middleware.
 *
 */
class Dispatcher implements DelegateInterface
{
    /**
     * @var array
     */
    private $middlewares = [];

    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var Response
     */
    private $response;

    /**
     * Dispatcher constructor.
     */
    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return Dispatcher
     */
    public function pipe(MiddlewareInterface $middleware): self
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getMiddleware();
        $this->index++;

        if (null === $middleware) {
            return $this->response;
        }

        return $middleware->process($request, $this);
    }

    /**
     * @return MiddlewareInterface|null
     */
    private function getMiddleware(): ?MiddlewareInterface
    {
        if (isset($this->middlewares[$this->index])) {
            return $this->middlewares[$this->index];
        }

        return null;
    }
}
