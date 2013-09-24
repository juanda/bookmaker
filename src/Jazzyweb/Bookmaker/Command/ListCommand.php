<?php
/**
 * User: juanda
 * Date: 24/09/13
 * Time: 8:35
 */

namespace Jazzyweb\Bookmaker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends BaseBookmakerCommand {

    protected function configure()
    {
        $this
            ->setName('bookmaker:list')
            ->setDescription('List books')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configuration = $this->getConfiguration();

        $output->writeln('<info>Book list</info>');
        $output->writeln('<info>#########</info>');
        foreach($configuration['books'] as $book => $val){
            $output->writeln('<info>' . $book . '</info>');
        }
    }
}