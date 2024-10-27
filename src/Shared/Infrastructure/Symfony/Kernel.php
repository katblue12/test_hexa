<?php

namespace Shared\Infrastructure\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

class Kernel extends BaseKernel implements CompilerPassInterface
{
    use MicroKernelTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->setParameter("kernel.secret", "secret");
    }
    public function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('/{services}.yaml');
        $container->import('/{services}/*/{services}.yaml');
    }

    public function configureRoutes(RoutingConfigurator $routes): void
    {
        $resources = $this->getResourcePaths(
            [
            '/{routes}/%env%/.yaml',
            '/{routes}/*.yaml',
            '/{routes}.yaml'
            ]
        );

        foreach($resources as $resource)
        {
            $routes->import($resource);
        }
    }

    public function getResourcePaths(array $resources): array
    {
       $configDir = $this->getConfigDir();
       $context = ['%env%' => $this->environment];

       return array_map(
           static function ($resource) use ($configDir, $context) {
               return $configDir . str_replace(
                   array_keys($context),
                       $context,
                       $resource
                   );
           },
           $resources
       );
    }


    public function process(ContainerBuilder $container)
    {
    }
}
