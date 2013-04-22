<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\NewsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SIPNewsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('controller.yml');
        $loader->load("admin.{$config['manager_type']}.yml");
        $loader->load("driver/{$config['manager_type']}.yml");

        $container->setParameter('sip.news.controller.class', $config['controller']);
        $container->setParameter('sip.news.model.class', $config['model']);
        $container->setParameter('sip_news.repository.class', $config['repository']);
        $container->setParameter('sip_news.admin.class', $config['admin']);
    }
}
