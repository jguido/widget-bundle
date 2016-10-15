<?php


namespace WidgetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateWidgetCommand extends ContainerAwareCommand
{
    private $serviceFile = __DIR__.'/../Resources/config/widget.yml';
    private $widgetPath = __DIR__.'/../Widget';
    private $viewPath = __DIR__.'/../Resources/views';
    private $nameCamelTag = "#NAME_CAMEL#";
    private $nameLowerTag = "#NAME_LOWER#";

    protected function configure()
    {
        $this
            ->setName('generate:widget')
            ->setDescription("Generate widget structure")
            ->addArgument('name'  , InputArgument::REQUIRED,'The name of the widget')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');

        $this->generateWidgetService($name, $io);
        $this->generateWidgetRouter($name, $io);
        $this->generateWidgetView($name, $io);

        //cache clear
        $command = $this->getApplication()->find('cache:clear');
        $arguments = [];
        $input = new ArrayInput($arguments);
        $command->run($input, $output);

        $io->writeln("");
        $io->success("Generation of the bundle is an epic success!");
        $io->note("You can render it be calling {{ render_widget('widget.".$name."') }}");
        $io->writeln("");
    }

    private function generateWidgetService($name, SymfonyStyle $console)
    {
        $console->section("Generation of the widget service definition");

        $skeletonServiceFile = __DIR__.'/skeletons/skeleton_service';

        $skeletonTemplate = file_get_contents($skeletonServiceFile);
        $nameCamel = ucfirst($name);
        $nameLower = strtolower($name);

        $widgetServiceContent = str_replace($this->nameCamelTag, $nameCamel, $skeletonTemplate);
        $widgetServiceContent = str_replace($this->nameLowerTag, $nameLower, $widgetServiceContent);

        file_put_contents($this->serviceFile, $widgetServiceContent, FILE_APPEND);

    }

    private function generateWidgetRouter($name, SymfonyStyle $console)
    {
        $console->section("Generation of the widget class");

        $skeletonWidgetFile = __DIR__.'/skeletons/skeleton_widget';

        $skeletonTemplate = file_get_contents($skeletonWidgetFile);
        $nameCamel = ucfirst($name);
        $nameLower = strtolower($name);

        $widgetContent = str_replace($this->nameCamelTag, $nameCamel, $skeletonTemplate);
        $widgetContent = str_replace($this->nameLowerTag, $nameLower, $widgetContent);

        file_put_contents($this->widgetPath."/$nameCamel"."Widget.php", $widgetContent);
    }

    private function generateWidgetView($name, SymfonyStyle $console)
    {
        $console->section("Generation of the widget view");

        $skeletonView = __DIR__.'/skeletons/skeleton_html';

        $skeletonTemplate = file_get_contents($skeletonView);
        $nameCamel = ucfirst($name);
        $nameLower = strtolower($name);

        $widgetViewContent = str_replace($this->nameCamelTag, $nameCamel, $skeletonTemplate);
        $widgetDir = $this->viewPath."/$nameCamel";
        if (!is_dir($widgetDir)) {
            mkdir($widgetDir);
        }

        file_put_contents("$widgetDir/$nameLower".".html.twig", $widgetViewContent);
    }


}