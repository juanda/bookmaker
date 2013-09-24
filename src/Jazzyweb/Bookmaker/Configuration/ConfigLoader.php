<?php
/**
 * Created by JetBrains PhpStorm.
 * User: juanda
 * Date: 24/09/13
 * Time: 8:40
 * To change this template use File | Settings | File Templates.
 */

namespace Jazzyweb\Bookmaker\Configuration;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Yaml\Yaml;

class ConfigLoader {

    public static function load($fileConfig){

        $output = new ConsoleOutput();
        try{
            $configDirectories = array($fileConfig);

            $locator = new FileLocator($configDirectories);
            $configFile = $locator->locate('config.yml');
            $config = Yaml::parse($configFile);

            $processor = new Processor();
            $configuration = new BookmakerConfiguration();
            $processedConfiguration = $processor->processConfiguration($configuration, array($config));

            return $processedConfiguration;
        }catch (InvalidConfigurationException $e){
            $output->writeln('<error>Configuration Error: '.$e->getMessage().'</error>');
        }catch(ParseException $e){
            $output->writeln('<error>Parse Error: '.$e->getMessage().'</error>');
        }
    }
}