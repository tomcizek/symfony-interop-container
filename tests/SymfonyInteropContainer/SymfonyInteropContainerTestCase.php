<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer\Tests\Configurators;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TomCizek\SymfonyInteropContainer\Tests\TestKernel;

abstract class SymfonyInteropContainerTestCase extends KernelTestCase
{

	/** @var ContainerBuilder */
	protected $container;

	/**
	 * @param string[]     $bundles
	 * @param ConfigFile[] $configFiles
	 *
	 * @return ContainerInterface
	 */
	protected function getContainerFromBootedKernelWith(
		array $bundles = [],
		array $configFiles = []
	): ContainerInterface {
		$kernel = $this->bootKernelWith($bundles, $configFiles);

		return $kernel->getContainer();
	}

	/**
	 * @param string[]     $bundles
	 * @param ConfigFile[] $configFiles
	 *
	 * @return TestKernel
	 */
	public function bootKernelWith(array $bundles = [], array $configFiles = []): TestKernel
	{
		$randomEnvironment = bin2hex(random_bytes(10));
		$kernel = new TestKernel($randomEnvironment, true);

		$kernel->addBundleClasses($bundles);
		$kernel->addConfigFiles($configFiles);
		$kernel->boot();

		return $kernel;
	}

	protected function thenIsInstanceOfExpectedClass($expected, $actual): void
	{
		self::assertInstanceOf($expected, $actual);
	}

	protected function thenPass(): void
	{
		self::assertTrue(true);
	}
}
