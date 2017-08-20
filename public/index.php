<?php

use Applicant\Application;
use DI\ContainerBuilder;
use Applicant\Dispatcher;
use function Http\Response\send;


$container = ContainerBuilder::buildDevContainer();

$application = new Application($router, $container);

$dispatcher = new Dispatcher();
//$dispatcher->pipe();

send($dispatcher->process($request));
