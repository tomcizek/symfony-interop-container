<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\ParameterBag;
use Throwable;

class SymfonyInteropContainer implements ContainerInterface
{
	/**
	 * @var ParameterBag
	 */
	private $config;

	/**
	 * @var Container
	 */
	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->config = new ParameterBag();
	}

	public function get($key)
	{
		return $this->tryToGetByKey($key);
	}

	private function tryToGetByKey($key)
	{
		try {
			if ($this->isKeyConfig($key)) {
				return $this->getConfig();
			}

			return $this->container->get($key);
		} catch (ServiceNotFoundException $e) {
			throw new NotFoundException($e->getMessage());
		} catch (Throwable $e) {
			throw new ContainerException($e->getMessage());
		}
	}

	private function isKeyConfig(string $key): bool
	{
		return $key === 'config';
	}

	private function getConfig()
	{
		return $this->config->all();
	}

	/**
	 * {@inheritdoc}
	 */
	public function has($key)
	{
		try {
			return (bool)$this->tryToGetByKey($key);
		} catch (NotFoundException $e) {
			return false;
		}

	}

	public function mergeOverConfigOnKey(string $key, array $config)
	{
		$this->config->add([$key => $config]);
	}
}
