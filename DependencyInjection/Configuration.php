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
                ->scalarNode('model')->defaultValue('SIP\\ResourceBundle\\Entity\\News')->end()
                ->scalarNode('controller')->defaultValue('SIP\\NewsBundle\\Controller\\NewsController')->end()
                ->scalarNode('repository')->defaultValue('SIP\\NewsBundle\\Repository\\NewsRepository')->end()
                ->scalarNode('admin')->defaultValue('SIP\\NewsBundle\\Admin\\NewsAdmin')->end()
            ->end();

        return $treeBuilder;
    }
}
