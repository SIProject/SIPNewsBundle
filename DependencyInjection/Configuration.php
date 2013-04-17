<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\NewsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sip_news');

        $rootNode
            ->children()
                ->scalarNode('model')->cannotBeEmpty()->end()
                ->scalarNode('controller')->defaultValue('SIP\\NewsBundle\\Controller\\NewsController')->end()
                ->scalarNode('repository')->defaultValue('SIP\\ResourceBundle\\Repository\\EntityRepository')->end()
                ->scalarNode('admin')->defaultValue('SIP\\NewsBundle\\Admin\\NewsAdmin')->end()
            ->end();

        return $treeBuilder;
    }
}
