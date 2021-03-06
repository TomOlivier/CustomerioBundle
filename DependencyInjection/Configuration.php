<?php

/*
 * This file is part of the EE\CustomerioBundle
 *
 * (c) Thomas Olivier <thomas@explee.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EE\CustomerioBundle\DependencyInjection;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     * @return treeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ee_customerio');

        $rootNode->children()
                ->scalarNode('api_key')
                ->isRequired()
                ->cannotBeEmpty()
                ->end()
                ->scalarNode('site_id')
                ->isRequired()
                ->cannotBeEmpty()
                ->end()
                ->booleanNode('ssl')
                ->defaultTrue()
                ->end()
                ->end();

        return $treeBuilder;
    }
}
