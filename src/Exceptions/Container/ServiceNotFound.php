<?php

namespace FrameworkFactory\Exceptions\Container {

    use Psr\Container\NotFoundExceptionInterface;

	/**
	 * @inheritdoc
	 */
    class ServiceNotFound extends \RuntimeException implements NotFoundExceptionInterface
    {
        // ...
    }
}
