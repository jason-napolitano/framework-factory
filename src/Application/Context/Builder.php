<?php

namespace FrameworkFactory\Application\Context {

    use FrameworkFactory\Contracts\Container\ContainerInstance;
    use FrameworkFactory\Contracts\Container\ContextBuilder;

	/**
	 * The context builder allows access to a service providers Context API,
	 * allowing for services to be swapped depending on the context of the
	 * swap
	 */
    class Builder implements ContextBuilder
    {
        /** @var string $needs stores the specific dependency that will be overridden for a given context. */
        protected string $needs;

        /**
         * New builder instance
         *
         * @param ContainerInstance $container
         * @param string            $concrete
         */
        public function __construct(protected ContainerInstance $container, protected string $concrete)
        {
        }

        /**
         * @inheritdoc
         */
        public function needs(string $abstract): self
        {
            $this->needs = $abstract;
            return $this;
        }

        /**
         * @inheritdoc
         */
        public function give(callable|string $implementation): void
        {
            $this->container->addContextualBinding($this->concrete, $this->needs, $implementation);
        }
    }
}
