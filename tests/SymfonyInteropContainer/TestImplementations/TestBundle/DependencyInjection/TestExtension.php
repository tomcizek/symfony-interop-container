<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer\Tests\TestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use TomCizek\SymfonyInteropContainer\AbstractInteropExtension;

class TestExtension extends AbstractInteropExtension
{
	public function load(array $configs, ContainerBuilder $containerBuilder)
	{
		// parent call is mandatory, or it will not work as expected!
		parent::load($configs, $containerBuilder);

		// we can set another config key (default is extension alias: $this->getAlias())
		$this->configBuilder->setKey('test');

		// we can merge over another config
		$this->configBuilder->mergeOverByConfig([]);

		// we can merge over multiple configs
		$this->configBuilder->mergeOverByConfigs([[]]);

		// we can merge default config
		$this->configBuilder->mergeDefaultConfig([]);

		// if you want, you can build config by:
		$config = $this->configBuilder->build();

		// it will be built in process method and injected into interop_container service
	}

	public function process(ContainerBuilder $containerBuilder)
	{
		// If you need to redefine process method, parent call is mandatory.
		parent::process($containerBuilder);
	}
}
