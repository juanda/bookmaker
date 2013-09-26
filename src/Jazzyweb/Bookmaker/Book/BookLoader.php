<?php
/**
 * This file is part of Bookmaker
 * User: juanda
 * Date: 26/09/13
 * Time: 10:30
 */

namespace Jazzyweb\Bookmaker\Book;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Yaml\Yaml;

class BookLoader {

    protected $processor;
    protected $bookconfig;

    public function __construct($processor, ConfigurationInterface $bookconfig){

        $this->processor   = $processor;
        $this->bookconfig  = $bookconfig;
    }

    public function load($configFile ){

        $config = Yaml::parse($configFile);

        $processedConfiguration = $this->processor->processConfiguration($this->bookconfig, array($config));

        $bookcollection = new BookCollection();

        foreach($processedConfiguration['books'] as $key => $val){
            $book = new Book();
            $book->setSource($val['source']);
            $book->setOutput($val['output']);
            $bookcollection->add($key, $book);
        }

        return $bookcollection;
    }
}