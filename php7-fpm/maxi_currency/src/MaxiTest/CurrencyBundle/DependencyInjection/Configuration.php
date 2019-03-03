<?php

namespace MaxiTest\CurrencyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('maxitest_currency');

//        $rootNode
//            ->children()
//                ->arrayNode('sources')
//                    ->scalarPrototype()
    }
}
