# tomcizek/symfony-interop-container

[![Build Status](https://img.shields.io/travis/tomcizek/symfony-interop-container.svg?style=flat-square)](https://travis-ci.org/tomcizek/symfony-interop-container)
[![Quality Score](https://img.shields.io/scrutinizer/g/tomcizek/symfony-interop-container.svg?style=flat-square)](https://scrutinizer-ci.com/g/tomcizek/symfony-interop-container)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tomcizek/symfony-interop-container.svg?style=flat-square)](https://scrutinizer-ci.com/g/tomcizek/symfony-interop-container)


This bundle is handy when you want to create symfony vendor bundle that uses interoperability
factories with <a href="https://sandrokeil.github.io/interop-config/getting-started/overview.html#1-1">interop config</a>.

## Why bother?

It registers 'interop_container' service for you, which has same services as default
'service_container', plus it returns app config array under key 'config'. This config is 
something you need to define in your extension.

# Quick start

## 1) Install this library through composer
`composer require tomcizek/symfony-interop-container`

## 2) Register SymfonyInteropContainerBundle in your extension

## 3) Create your Extension, for example:

````````
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
````````

## Contribute

Please feel free to fork and extend existing or add new features and send a pull request with your changes! 
To establish a consistent code quality, please provide unit tests for all your changes and may adapt the documentation.
