<?php


namespace WidgetBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;

class WidgetExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'render_widget' => new \Twig_SimpleFunction('render_widget', array($this, 'renderWidget'), array(
                'is_safe' => array('html'),
                'needs_environment' => true
            )),
        );
    }

    public function renderWidget(\Twig_Environment $twig, $widgetService, array $params = [])
    {
        $widget = $this->container->get($widgetService);
        $widget->setContainer($this->container);
        $options = [
            'url' => $widget->getUri($params),
            'id' => md5(microtime())
        ];
        return $twig->render('WidgetBundle:Widget:render.html.twig', $options);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'widget_extension';
    }
}