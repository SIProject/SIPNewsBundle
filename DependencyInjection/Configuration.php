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
                ->scalarNode('controller')->defaultValue('Sylius\\Bundle\\ResourceBundle\\Controller\\ResourceController')->end()
                ->scalarNode('repository')->defaultValue('Sylius\\Bundle\\ResourceBundle\\Doctrine\\ORM\\EntityRepository')->end()
                ->scalarNode('admin')->defaultValue('SIP\\NewsBundle\\Admin\\NewsAdmin')->end()
            ->end();

        return $treeBuilder;
    }
}
