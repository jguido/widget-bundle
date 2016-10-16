# Installation
    composer require jguido/widget-bundle

Then add this bundle to your kernel (app/AppKernel.php) :

    new WidgetBundle\WidgetBundle(),
    new ApplicationWidgetBundle\ApplicationWidgetBundle(),

Add in app/config/routing.yml

    bundle_widget:
        resource: "@WidgetBundle/Resources/config/routing.yml"
        prefix:   /

Add in app/config/config.yml in import section

    - { resource: "@ApplicationWidgetBundle/Resources/config/widgets.yml" }

Add this line in the style declaration of your layout
    
    <link href="{{ asset('bundles/widget/css/widget-render.css') }}" rel="stylesheet" media="screen" type="text/css"/>

Add this line in the javascript declaration of your layout
    
    <script type="text/javascript" src="{{ asset('bundles/widget/js/Widget.js') }}"></script>

# Usage

There is a command for generating files of the desired widget :

    php bin/console generate:widget <widget_name>


The rendering of a widget is done like this

The simpliest way
    
    {{ render_widget('widget.<widget_name>') }}
    
If the route of your widget needs parameters
    
    {{ render_widget('widget.<widget_name>', {'param1': param1}) }}

But if you do so, you will have to update the route definition in the file of your bundle (in src/ApplicationWidgetBundle/Widget/your_widget)
    
Content of the widget is loaded with ajax calls, all the dom events are functionnals (window.onload, $(function){...});)

File structure :
src
-- ApplicationWidgetBundle
----Resources
------config
--------widgets.yml (the widgets service definition)
------views (where the views generated are placed)
----Widget (inside all the widget (controller) class

# Example (Use case)

You want to generate a bundle "test"

in console :

    php bin/console generate:widget test
    
What i will have in the service definition (src/ApplicationWidgetBundle/Resources/config/widgets.yml):

    services:
    
        widget.test:
            class: ApplicationWidgetBundle\Widget\TestWidget
            
Inside the widget class:

    <?php
    
    
    namespace ApplicationWidgetBundle\Widget;
    
    
    use WidgetBundle\Base\BaseWidget;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Component\HttpFoundation\Response;
    
    class TestWidget extends BaseWidget
    {
    
        /**
         * @param $params
         * @return mixed
         */
        protected function getData($params)
        {
            throw new \Exception("Not implemented");
        }
    
        /**
         * @param array|null $params
         * @return string
         */
        public function getUri(array $params = null)
        {
            return $this->generateUrl('path_widget_test', $params);
        }
    
        /**
         * @return Response
         * @internal param Request $request
         * @Route("/widgets/test/render", name="path_widget_test")
         */
        public function widgetAction()
        {
            return $this->render('ApplicationWidgetBundle:Test:test.html.twig');
        }
    }
    
This TestWidget class will act as a common controller
    
Inside the views directory:

a sub directory called Test and inside a file test.html.twig

    <div class="col-xs-12">
        This is widget Test
    </div>

You will be able to render it through other twig views like this :

    {{ render_widget('widget.test') }}
