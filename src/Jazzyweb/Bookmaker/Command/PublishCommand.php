<?php
/**
 * User: juandalibaba
 * Date: 23/09/13
 * Time: 19:41
 */

namespace Jazzyweb\Bookmaker\Command;

use Jazzyweb\Bookmaker\Configuration\ConfigLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Process\Process;


class PublishCommand extends Command{

    protected function configure()
    {
        $this
            ->setName('bm:publish')
            ->setDescription('Publish book')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'What book do you want to publish?'
            )
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'What format do you want to build? (default HTML): HTML, PDF, EPUB',
                'html'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $format = $input->getOption('format');
        $dialog = $this->getHelperSet()->get('dialog');
        $container = $this->getApplication()->getContainer();

        $bookcollection = $container['bookcollection'];

        if(!$bookcollection->has($name)){
            $output->writeln('<error>the book "'. $name . '" is not registered in configuration file');
            return;
        }

        $book = $bookcollection->get($name);

        $sourceDir = $book->getSource();
        $outputDir = $book->getOutput();

        $output->writeln('<info>Source directory: ' . $sourceDir . '</info>');
        $output->writeln('<info>Output directory: ' . $outputDir . '</info>');

        if (!$dialog->askConfirmation(
            $output,
            '<question>Proceed to generate book?</question>',
            false
        )) {
            $output->writeln('<error>Action aborted</error>');
            return;
        }
        $output->writeln('<info>Running ...</info>');


        $process = new Process('sphinx-build -b html '. $sourceDir . ' ' . $outputDir);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $output->writeln('<fg=green>' . $process->getOutput() . '</fg=green>>');
    }
}