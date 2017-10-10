<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use TomCizek\SymfonyInteropContainer\SymfonyInteropContainer;

class SymfonyInteropContainerExtension extends Extension
{
	/** @var array */
	public $defaults = [];

	public function load(array $configs, ContainerBuilder $containerBuilder): void
	{
		$this->registerInteropContainer($containerBuilder);
	}

	private function registerInteropContainer(ContainerBuilder $containerBuilder): void
	{
		$interopContainerDefinition = new Definition();
		$interopContainerDefinition->setClass(SymfonyInteropContainer::class);
		$interopContainerDefinition->addArgument(new Reference('service_container'));

		$containerBuilder->setDefinition('interop_container', $interopContainerDefinition);
		$containerBuilder->setAlias(SymfonyInteropContainer::class, 'interop_container');
	}
}

