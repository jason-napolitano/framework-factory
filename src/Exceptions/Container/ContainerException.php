<?php

namespace FrameworkFactory\Exceptions\Container {

    use Psr\Container\ContainerExceptionInterface;

	/**
	 * @inheritdoc
	 */
    class ContainerException extends \RuntimeException implements ContainerExceptionInterface
    {
        // ...
    }
}
