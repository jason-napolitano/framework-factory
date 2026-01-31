<?php

namespace Tests {

	use FrameworkFactory\Contracts\Application\ApplicationInstance;

	final class TestState
	{
		public static ApplicationInstance $app;

		public static string $cachePath;
	}
}