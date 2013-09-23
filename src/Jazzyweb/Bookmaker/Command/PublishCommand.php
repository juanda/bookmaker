<?php
/**
 * User: juandalibaba
 * Date: 23/09/13
 * Time: 19:41
 */

namespace Jazzyweb\Bookmaker\Command;

use Jazzyweb\Bookmaker\Configuration\BookmakerConfiguration;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

class PublishCommand extends Command{

    protected $processedConfiguration;

    public function __construct(){
        parent::__construct();

        try{
            $configDirectories = array(__DIR__.'/../../../../config');

            $locator = new FileLocator($configDirectories);
            $configFile = $locator->locate('config.yml');
            $config = Yaml::parse($configFile);

            $processor = new Processor();
            $configuration = new BookmakerConfiguration();
            $this->processedConfiguration = $processor->processConfiguration($configuration, array($config));
        }catch (InvalidConfigurationException $e){
            $output = new ConsoleOutput();
            $output->writeln('<error>Error: '.$e->getMessage().'</error>');
        }
    }
    protected function configure()
    {
        $this
            ->setName('publish')
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


        if(!array_key_exists($name,$this->processedConfiguration['books'])){
            $output->writeln('<error>the book "'. $name . '" is not registered in configuration file');
            return;
        }

        $sourceDir = $this->processedConfiguration['books'][$name]['source'];
        $outputDir = $this->processedConfiguration['books'][$name]['output'];

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