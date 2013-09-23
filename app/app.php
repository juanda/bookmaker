#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use Jazzyweb\Command\PublishCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new PublishCommand());
$application->run();