<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer\Tests;

use Symfony\Component\DependencyInjection\ContainerInterface;
use TomCizek\SymfonyInteropContainer\SymfonyInteropContainer;
use TomCizek\SymfonyInteropContainer\SymfonyInteropContainerBundle;
use TomCizek\SymfonyInteropContainer\Tests\Configurators\ConfigFile;
use TomCizek\SymfonyInteropContainer\Tests\Configurators\SymfonyInteropContainerTestCase;

class SymfonyInteropContainerExtensionTest extends SymfonyInteropContainerTestCase
{
	/** @var ContainerInterface */
	protected $container;

	public function testLoad_WithBundle_ShouldContainSymfonyInteropContainer()
	{
		$this->whenBuildContainerWith([SymfonyInteropContainerBundle::class]);

		$this->thenContainsSymfonyInteropContainer();
	}

	/**
	 * @param string[]     $bundles
	 * @param ConfigFile[] $configFiles
	 *
	 * @return void
	 */
	private function whenBuildContainerWith(array $bundles = [], array $configFiles = []): void
	{
		$this->container = $this->getContainerFromBootedKernelWith($bundles, $configFiles);
	}

	private function thenContainsSymfonyInteropContainer()
	{
		$interopContainer = $this->container->get('interop_container');
		self::assertInstanceOf(SymfonyInteropContainer::class, $interopContainer);
		$interopContainer = $this->container->get(SymfonyInteropContainer::class);
		self::assertInstanceOf(SymfonyInteropContainer::class, $interopContainer);
	}
}
