<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer\Tests\Configurators;

use DateTime;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use TomCizek\SymfonyInteropContainer\SymfonyInteropContainer;
use TomCizek\SymfonyInteropContainer\SymfonyInteropContainerBundle;
use TomCizek\SymfonyInteropContainer\Tests\TestBundle\TestBundle;
use TomCizek\SymfonyInteropContainer\Tests\TestBundle\TestService;

class SymfonyInteropContainerTest extends SymfonyInteropContainerTestCase
{
	const FIXTURE_CONGIGS_DIR = __DIR__ . '/fixtures/';

	/** @var SymfonyInteropContainer */
	private $interopContainer;

	public function setUp()
	{
		parent::setUp();

		$this->givenInteropContainerFromBootedKernelWith(
			[
				SymfonyInteropContainerBundle::class,
				TestBundle::class,
			],
			[
				ConfigFile::record(self::FIXTURE_CONGIGS_DIR . 'TestExtensionConfig.yml', 'yml'),
			]
		);
	}

	public function testHas_WithBadType_ShouldThrowContainerException()
	{
		$this->willThrowException(ContainerExceptionInterface::class);

		$this->whenAskInteropContainerWhetherHasKey(new DateTime());
	}

	public function testHas_NotExistingService_ShouldReturnFalse()
	{
		$hasConfig = $this->whenAskInteropContainerWhetherHasKey('not_existing_service');

		$this->thenResultIsFalse($hasConfig);
	}

	public function testHas_ConfigKey_ShouldReturnTrue()
	{
		$hasConfig = $this->whenAskInteropContainerWhetherHasKey('config');

		$this->thenResultIsTrue($hasConfig);
	}

	public function testHas_ExistingService_ShouldReturnTrue()
	{
		$hasConfig = $this->whenAskInteropContainerWhetherHasKey('test_service');

		$this->thenResultIsTrue($hasConfig);
	}

	public function testGet_WithBadType_ShouldThrowContainerException()
	{
		$this->willThrowException(ContainerExceptionInterface::class);

		$this->whenGetFromInteropContainerByKey(new DateTime());
	}

	public function testGet_NotExistingService_ShouldThrowNotFoundException()
	{
		$this->willThrowException(NotFoundExceptionInterface::class);

		$this->whenGetFromInteropContainerByKey('not_existing_service');
	}

	public function testGet_ExistingTestServiceFromConfig_ShouldBeInstanceOfTestService()
	{
		$testService = $this->whenGetFromInteropContainerByKey('test_service');

		$this->thenIsInstanceOf(TestService::class, $testService);
	}

	public function testGet_ConfigKey_ShouldContainTestExtensionConfig()
	{
		$config = $this->whenGetFromInteropContainerByKey('config');

		$this->thenIsexpecteedConfig($config);
	}

	/**
	 * @param string[]     $bundles
	 * @param ConfigFile[] $configFiles
	 *
	 * @return void
	 */
	private function givenInteropContainerFromBootedKernelWith(array $bundles = [], array $configFiles = []): void
	{
		$container = $this->getContainerFromBootedKernelWith($bundles, $configFiles);
		$this->interopContainer = $container->get(SymfonyInteropContainer::class);
	}

	private function willThrowException($class): void
	{
		$this->expectException($class);
	}

	private function whenAskInteropContainerWhetherHasKey($key)
	{
		return $this->interopContainer->has($key);
	}

	private function thenResultIsTrue($has): void
	{
		self::assertTrue($has);
	}

	private function thenResultIsFalse($has): void
	{
		self::assertFalse($has);
	}

	private function whenGetFromInteropContainerByKey($key)
	{
		return $this->interopContainer->get($key);
	}

	private function thenIsInstanceOf($expectedClass, $instance): void
	{
		self::assertInstanceOf($expectedClass, $instance);

	}

	private function thenIsexpecteedConfig(array $config): void
	{
		$expectedConfig = [
			'test' => [
				'foo' => 'bar',
			],
		];
		self::assertEquals($expectedConfig, $config);
	}
}
