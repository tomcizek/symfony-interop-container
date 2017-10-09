<?php declare(strict_types = 1);

namespace TomCizek\SymfonyInteropContainer\Tests\TestBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TestBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		//$container->addCompilerPass(new ExtensionCompilerPass());
	}
}
