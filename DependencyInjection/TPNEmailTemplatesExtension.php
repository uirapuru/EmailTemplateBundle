<?php

namespace TPN\EmailTemplatesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TPNEmailTemplatesExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('tpn.email_templates.template_variables', $config['email_variables']);
        $container->setParameter('tpn.email_templates.header', $config['email_layout']['header']);
        $container->setParameter('tpn.email_templates.footer', $config['email_layout']['footer']);
        $container->setParameter('tpn.email_templates.styles', $config['email_layout']['styles']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
