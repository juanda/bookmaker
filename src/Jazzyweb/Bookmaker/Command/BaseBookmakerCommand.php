<?php
/**
 * Created by JetBrains PhpStorm.
 * User: juanda
 * Date: 24/09/13
 * Time: 8:45
 * To change this template use File | Settings | File Templates.
 */

namespace Jazzyweb\Bookmaker\Command;


use Jazzyweb\Bookmaker\Configuration\ConfigLoader;
use Symfony\Component\Console\Command\Command;

class BaseBookmakerCommand extends Command {

    private $configuration;

    public function getConfiguration(){
        if(null === $this->configuration){
            $this->configuration = ConfigLoader::load(__DIR__.'/../../../../config');
        }
        return $this->configuration;
    }

}