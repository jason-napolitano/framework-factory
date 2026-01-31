<?php

namespace Tests\Providers {

	use FrameworkFactory\Contracts;
	use Tests\Services\DemoService;

	class DemoServiceProvider extends Contracts\Providers\ServiceProvider
	{
		/**
		 * @inheritdoc
		 */
		public function register(): void
		{
			$this->container->singleton('demo', fn() => new DemoService());
		}

		/**
		 * @inheritdoc
		 */
		public function provides(): array
		{
			return ['demo'];
		}
	}
}