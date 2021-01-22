<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Bundle\DoctrineExtensionsExtraBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Register the expression language providers.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class RequestQueryFilterableFormGuesserPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container): void
    {
        if ($container->hasDefinition('klipper_doctrine_extensions_extra.request_query.filterable')) {
            $def = $container->getDefinition('klipper_doctrine_extensions_extra.request_query.filterable');

            $guessers = $this->findTags(
                $container,
                'klipper_doctrine_extensions_extra.request_query.filterable.form_guesser',
                $def->getArgument(7)
            );
            $def->replaceArgument(7, $guessers);
        }
    }

    /**
     * Find and returns the services with the tag.
     *
     * @param ContainerBuilder $container The container service
     * @param string           $tag       The tag name
     * @param Reference[]      $list      The list of services
     *
     * @return Reference[]
     */
    protected function findTags(ContainerBuilder $container, string $tag, array $list): array
    {
        foreach ($this->findAndSortTaggedServices($tag, $container) as $service) {
            $list[] = $service;
        }

        return $list;
    }
}
