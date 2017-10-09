<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer;

class ConfigArrayBuilder
{
	private $configs = [];
	private $key;

	private function __construct(array $configs, string $key)
	{
		$this->key = $key;
		$this->mergeOverByConfigs($configs);
	}

	public function mergeOverByConfigs(array $configs): self
	{
		foreach ($configs as $config) {
			$this->mergeOverByConfig($config);
		}

		return $this;
	}

	public function mergeOverByConfig(array $config): self
	{
		$this->configs[] = $config;

		return $this;
	}

	public static function withConfigsOnKey(array $configs = [], string $key): self
	{
		return new self($configs, $key);
	}

	public function mergeDefaultConfig(array $config): self
	{
		array_unshift($this->configs, $config);

		return $this;
	}

	public function build(): array
	{
		$builtConfig = [];
		foreach ($this->configs as $overridingConfig) {
			$builtConfig = $this->mergeConfigs($overridingConfig, $builtConfig);
		}

		return $builtConfig;
	}

	private function mergeConfigs(array $overridingConfig, array $overriddenConfig): array
	{
		return array_replace_recursive($overriddenConfig, $overridingConfig);
	}

	public function getKey(): string
	{
		return $this->key;
	}

	public function setKey(string $key)
	{
		$this->key = $key;
	}
}
