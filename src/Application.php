<?php

namespace Applicant;

use Applicant\Exception\ContainerNotRegisteredException;
use Applicant\Router\RouterInterface;
use Psr\Container\ContainerInterface;

/**
 * Application.
 */
final class Application
{
    /**
     * @var null|ContainerInterface
     */
    private $container;

    private $pipeline;


    /**
     * @var Router\RouterInterface
     */
    private $router;

    /**
     * List of all routes registered directly with the application.
     *
     * @var Router\Route[]
     */
    private $routes = [];

    /**
     * @param RouterInterface         $router
     * @param ContainerInterface|null $container
     */
    public function __construct(RouterInterface $router, ContainerInterface $container = null)
    {
        $this->router = $router;
        $this->container = $container;
    }

    /**
     * Retrieve the container.
     *
     * If no container is registered, we raise an exception.
     *
     * @return ContainerInterface
     * @throws ContainerNotRegisteredException
     */
    public function getContainer()
    {
        if (null === $this->container) {
            throw new ContainerNotRegisteredException();
        }

        return $this->container;
    }
}
