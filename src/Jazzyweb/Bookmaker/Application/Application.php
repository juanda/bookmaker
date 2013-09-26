<?php
/**
 * This file is part of Bookmaker
 * User: juanda
 * Date: 25/09/13
 * Time: 14:24
 */

namespace Jazzyweb\Bookmaker\Application;

use Jazzyweb\Bookmaker\Book\BookLoader;
use Jazzyweb\Bookmaker\Command\ListCommand;
use Jazzyweb\Bookmaker\Command\PublishCommand;
use Jazzyweb\Bookmaker\Configuration\BookmakerConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication{

    protected $container;

    public function __construct($configFile, $name = 'UNKNOWN', $version = 'UNKNOWN'){

        parent::__construct($name. $version);
        $this->container = new \Pimple();

        // Aplication Commands
        $this->add(new PublishCommand());
        $this->add(new ListCommand());

        // Container params
        $this->container['configfile'] = $configFile;

        // Container services
        $this->container['bookcollection'] = $this->container->share(function($c){
            $bookcollection = $c['bookloader']->load($c['configfile']);
            return  $bookcollection;
        });

        $this->container['filelocator'] = $this->container->share(function($c){
            return new FileLocator();
        });

        $this->container['definition_processor'] = function($c){
            return new Processor();
        };

        $this->container['bookmaker_configuration'] = $this->container->share(function($c){
            return new BookmakerConfiguration();
        });

        $this->container['bookloader'] = $this->container->share(function($c){
            $procesor   = $c['definition_processor'];
            $bookconfig = $c['bookmaker_configuration'];

            return new BookLoader($procesor, $bookconfig);
        });

    }

    public function getContainer(){
        return $this->container;
    }

}