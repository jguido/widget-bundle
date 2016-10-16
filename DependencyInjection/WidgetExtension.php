<?php

namespace WidgetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class WidgetExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $bundleDir = $container->getParameter('kernel.root_dir').'/../src/ApplicationWidgetBundle';
        if (!is_dir($bundleDir)) {
            mkdir($bundleDir);
            mkdir($bundleDir.'/Resources');
            mkdir($bundleDir.'/Resources/config');
            mkdir($bundleDir.'/Resources/views');
            mkdir($bundleDir.'/Widget');

            $dirWidget = __DIR__.'/../Command/skeletons';

            $configFile = file_get_contents($dirWidget.'/widget.yml');
            file_put_contents($bundleDir."/Resources/config/widgets.yml", $configFile);
            $widgetFile = file_get_contents($dirWidget.'/WidgetBundle.php');
            file_put_contents($bundleDir.'/ApplicationWidgetBundle.php', $widgetFile);
        }
    }
}
