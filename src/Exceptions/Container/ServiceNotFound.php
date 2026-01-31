<?php

namespace FrameworkFactory\Exceptions\Container {

    use Psr\Container\NotFoundExceptionInterface;

    class ServiceNotFound extends \RuntimeException implements NotFoundExceptionInterface
    {
        // ...
    }
}
