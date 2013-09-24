#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use Jazzyweb\Bookmaker\Command\PublishCommand;
use Jazzyweb\Bookmaker\Command\ListCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new PublishCommand());
$application->add(new ListCommand());
$application->run();