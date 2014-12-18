VDM Scrapper
========================

VDMScrapper is an application scrapping posts from http://viedemerde.fr.
Project is built on Symfony2.

1) Installing with composer
----------------------------------

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Clone it or Unpack it somewhere under your web server root directory.

Project is provided without vendors, you  need to install all the necessary dependencies running the following command:

    php composer.phar install

2) Update database from VDM
-------------------------------------

Execute the following command from the terminal:

    php app/console vdm:import

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

3) Retrieve data through the API
--------------------------------

Once data are stored in database, you can query a particular post

	/api/post/3
	
	/api/posts?from=2012-12-01&to=2012-12-03&author=Me



