<?php
namespace TPN\EmailTemplatesBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use TPN\EmailTemplatesBundle\DependencyInjection\CompilerPass\EmailTemplateEnricherCompilerPass;

class TPNEmailTemplatesBundle extends Bundle {
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new EmailTemplateEnricherCompilerPass());
    }
}