# Installation
composer require jguido/widget-bundle
Add in app/config/routing.yml

    bundle_widget:
        resource: "@WidgetBundle/Resources/config/routing.yml"
        prefix:   /

# Usage

There is a command for generating files of the desired widget :

    php bin/console generate:widget <widget_name>

Add this line in the style declaration of your layout
    
    <link href="{{ asset('bundles/widget/css/widget-render.css') }}" rel="stylesheet" media="screen" type="text/css"/>

Add this line in the javascript declaration of your layout
    
    <script type="text/javascript" src="{{ asset('bundles/widget/js/Widget.js') }}"></script>

The rendering of a widget is done like this

The simpliest way
    
    {{ render_widget('widget.<widget_name>') }}
    
If the route of your widget needs parameters
    
    {{ render_widget('widget.<widget_name>', {'param1': param1}) }}
    
Content of the widget is loaded with ajax calls, all the dom events are functionnals (window.onload, $(function){...)
