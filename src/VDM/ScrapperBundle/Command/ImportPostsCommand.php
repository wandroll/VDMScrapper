<?php

namespace VDM\ScrapperBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportPostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('vdm:import')
            ->setDescription('Import posts from vdm.fr')
        ;
    }

    protected function execute(InputInterface $input,OutputInterface $output)
    {
    	$vdmPostsUpdater = $this->getContainer()->get('vdm_scrapper.vdmpostsupdater');
    	$vdmPostsUpdater->runUpdate();
    	$output->writeln('Posts successfully retrieved !');
    }
}