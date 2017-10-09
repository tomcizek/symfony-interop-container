<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer\Tests;

use Symfony\Component\DependencyInjection\ContainerInterface;
use TomCizek\SymfonyInteropContainer\SymfonyInteropContainerBundle;
use TomCizek\SymfonyInteropContainer\Tests\Configurators\ConfigFile;
use TomCizek\SymfonyInteropContainer\Tests\Configurators\SymfonyInteropContainerTestCase;

class SymfonyInteropContainerBundleTest extends SymfonyInteropContainerTestCase
{
	/** @var ContainerInterface */
	protected $container;

	public function setUp(): void
	{
		parent::setUp();

	}

	public function testBuild_OnlyThisBundle_ShouldPass()
	{
		$this->whenBuildContainerWith(
			[
				SymfonyInteropContainerBundle::class,
			]
		);

		$this->thenPass();
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
}

