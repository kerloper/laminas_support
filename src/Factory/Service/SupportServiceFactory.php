<?php

namespace Support\Factory\Service;

use Content\Service\ItemService;
use Content\Service\MetaService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Support\Service\SupportService;
use User\Service\AccountService;
use User\Service\UtilityService;

class SupportServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     *
     * @return SupportService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): SupportService
    {
        $config = $container->get('config');

        return new SupportService(
            $container->get(AccountService::class),
            $container->get(UtilityService::class),
            $container->get(MetaService::class),
            $container->get(ItemService::class),
            ///TODO: kerloper: set config array in global if need it
            []
        );
    }
}
