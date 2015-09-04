<?php

namespace TPN\EmailTemplatesBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EmailTemplateEnricherCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $commandsIds = $container->findTaggedServiceIds('email_template_enricher_command');

        if (count($commandsIds) !== 0) {
            foreach ($commandsIds as $serviceId => $tags) {
                foreach ($tags as $attributes) {
                    $definition = $container->findDefinition('tpn.email_templates.email_template_enricher');

                    $definition->addMethodCall('addCommand', [
                        $container->findDefinition($serviceId),
                        $attributes['index'],
                    ]);
                }
            }
        }
    }
}
