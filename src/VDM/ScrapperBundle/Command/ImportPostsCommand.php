<?php

namespace VDM\ScrapperBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportPostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('vdm:import')
            ->setDescription('Import posts from vdm.fr')
         //   ->addArgument('name', InputArgument::OPTIONAL, 'Qui voulez vous saluer??')
          //  ->addOption('yell', null, InputOption::VALUE_NONE, 'Si définie, la tâche criera en majuscules')
        ;
    }

    protected function execute(InputInterface $input,OutputInterface $output)
    {
    	//getApplication()->getKernel()->
    	$vdmPostsUpdater = $this->getContainer()->get('vdm_scrapper.vdmpostsupdater');
    	$vdmPostsUpdater->runUpdate();
    	$output->writeln('on a reussi');
    }
}