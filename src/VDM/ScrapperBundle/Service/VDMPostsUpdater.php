<?php

namespace VDM\ScrapperBundle\Service;

use Doctrine\ORM\EntityManager;
use VDM\ScrapperBundle\Entity\VDMPost;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class VDMPostsUpdater
{
	protected $em;
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
	public function runUpdate()
	{
		$repository = $this->em->getRepository('VDMScrapperBundle:VDMPost');
		
		//bulck delete of all existing posts
		$vdmPosts = $repository->findAll();
		foreach ($vdmPosts as $vdmPost)
		{
			$this->em->remove($vdmPost);		
		}
		$this->em->flush();
		$this->em->clear();
		
		$maxPageToCrawl = 16;
		$base_url = 'http://www.viedemerde.fr/?page=';
		$currentPageNumber= 0;

		$client = new Client(); //Goutte client instance
		$client->getClient()->setDefaultOption('config/curl/'.CURLOPT_TIMEOUT, 60);

		while ($currentPageNumber < $maxPageToCrawl)
		{
			$crawler = $client->request('GET', $base_url.$currentPageNumber);

			$crawler->filter('div.post.article')->each(function ($node ) {

				$vdmPostContent = $node->children()->first()->text();

				//vdmPostDetailList contains both author and date and useless content
				$vdmPostDetailList = explode(" - ", $node->filter('.right_part')->children()->eq(1)->text());
				$author = preg_replace('/par /', "", end($vdmPostDetailList));
				$vdmPostAuthor = preg_replace('#\(.*?\)#','', $author); //remove useless content between parenthesis
				
				//we have 'Le 17/12/2014 à 21:56'and need 'Y-m-d h:i:s'
				$pattern = '#Le ([0-9]{2})\/([0-9]{2})\/([0-9]{4}) à ([0-9]{2}\:[0-9]{2})#';
				$replacement = '$1-$2-$3 $4';
				$vdmPostDate = preg_replace($pattern, $replacement, $vdmPostDetailList[0]);
				

				$vdmPost = new VDMPost;
				$vdmPost->setAuthor($vdmPostAuthor)
					->setContent($vdmPostContent)
					->setDate(new \DateTime($vdmPostDate))
				;
				$this->em->persist($vdmPost);
			});
			$currentPageNumber++;
		}
		$this->em->flush();
		$this->em->clear();
	}
}