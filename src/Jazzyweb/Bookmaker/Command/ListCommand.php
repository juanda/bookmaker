<?php
/**
 * User: juanda
 * Date: 24/09/13
 * Time: 8:35
 */

namespace Jazzyweb\Bookmaker\Command;

use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command {

    protected function configure()
    {
        $this
            ->setName('bm:list')
            ->setDescription('List books')
            ->addOption(
                'config',
                null,
                InputOption::VALUE_OPTIONAL,
                'Show configuration?',
                false)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try{
            $container = $this->getApplication()->getContainer();
            $formatter = $this->getHelperSet()->get('formatter');

            $bookcollection = $container['bookcollection'];

            $output->writeln('<info>Book list</info>');
            $output->writeln('<info>#########</info>');
            foreach($bookcollection as $name => $book){
                $output->writeln('<info>' . $name . '</info>');
                if($input->getOption('config')){
                    $configs = array($book->getSource(), $book->getOutput());
                    $formattedBlock = $formatter->formatBlock($configs, 'info');
                    $output->writeln($formattedBlock);
                }
            }
        }catch (InvalidTypeException $e){
            $output->writeln('<error>list error: type invalid probably the config file is incorrect</error>');
        }
    }
}