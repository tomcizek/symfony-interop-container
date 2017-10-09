<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

abstract class AbstractInteropExtension extends Extension implements CompilerPassInterface
{
	/** @var ConfigArrayBuilder */
	protected $configBuilder;

	public function load(array $configs, ContainerBuilder $containerBuilder)
	{
		$this->configBuilder = ConfigArrayBuilder::withConfigsOnKey($configs, $this->getAlias());
	}

	public function process(ContainerBuilder $containerBuilder)
	{
		$this->setupConfigInInteropContainer($containerBuilder);
	}

	/**
	 * @param ContainerBuilder $containerBuilder
	 *
	 * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
	 * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
	 */
	protected function setupConfigInInteropContainer(ContainerBuilder $containerBuilder): void
	{
		/** @var SymfonyInteropContainer $containerWrapper */
		$interopContainerDefinition = $containerBuilder->getDefinition('interop_container');
		$interopContainerDefinition->addMethodCall(
			'mergeOverConfigOnKey',
			[
				$this->configBuilder->getKey(),
				$this->configBuilder->build(),
			]
		);
	}
}
