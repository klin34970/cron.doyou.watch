<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Rss;

if(!file_exists(dirname(__FILE__) . "/.process_import_pornhub_rss"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_pornhub_rss", "w");
	fclose($process);
	
	$rsss[] = 'http://www.pornhub.com/feed/amateur.xml';
	$rsss[] = 'http://www.pornhub.com/feed/anal.xml';
	$rsss[] = 'http://www.pornhub.com/feed/asian.xml';
	$rsss[] = 'http://www.pornhub.com/feed/babe.xml';
	$rsss[] = 'http://www.pornhub.com/feed/bbw.xml';
	$rsss[] = 'http://www.pornhub.com/feed/big-ass.xml';
	$rsss[] = 'http://www.pornhub.com/feed/big-dick.xml';
	$rsss[] = 'http://www.pornhub.com/feed/big-tits.xml';
	$rsss[] = 'http://www.pornhub.com/feed/bisexual.xml';
	$rsss[] = 'http://www.pornhub.com/feed/blonde.xml';
	$rsss[] = 'http://www.pornhub.com/feed/blowjob.xml';
	$rsss[] = 'http://www.pornhub.com/feed/bondage.xml';
	$rsss[] = 'http://www.pornhub.com/feed/brunette.xml';
	$rsss[] = 'http://www.pornhub.com/feed/bukkake.xml';
	$rsss[] = 'http://www.pornhub.com/feed/celebrity.xml';
	$rsss[] = 'http://www.pornhub.com/feed/college.xml';
	$rsss[] = 'http://www.pornhub.com/feed/compilation.xml';
	$rsss[] = 'http://www.pornhub.com/feed/creampie.xml';
	$rsss[] = 'http://www.pornhub.com/feed/cumshots.xml';
	$rsss[] = 'http://www.pornhub.com/feed/double-penetration.xml';
	$rsss[] = 'http://www.pornhub.com/feed/ebony.xml';
	$rsss[] = 'http://www.pornhub.com/feed/euro.xml';
	$rsss[] = 'http://www.pornhub.com/feed/exclusive.xml';
	$rsss[] = 'http://www.pornhub.com/feed/fetish.xml';
	$rsss[] = 'http://www.pornhub.com/feed/fisting.xml';
	$rsss[] = 'http://www.pornhub.com/feed/for-women.xml';
	$rsss[] = 'http://www.pornhub.com/feed/funny.xml';
	$rsss[] = 'http://www.pornhub.com/feed/gangbang.xml';
	$rsss[] = 'http://www.pornhub.com/feed/handjob.xml';
	$rsss[] = 'http://www.pornhub.com/feed/hardcore.xml';
	$rsss[] = 'http://www.pornhub.com/feed/hentai.xml';
	$rsss[] = 'http://www.pornhub.com/feed/indian.xml';
	$rsss[] = 'http://www.pornhub.com/feed/interracial.xml';
	$rsss[] = 'http://www.pornhub.com/feed/japanese.xml';
	$rsss[] = 'http://www.pornhub.com/feed/latina.xml';
	$rsss[] = 'http://www.pornhub.com/feed/lesbian.xml';
	$rsss[] = 'http://www.pornhub.com/feed/massage.xml';
	$rsss[] = 'http://www.pornhub.com/feed/masturbation.xml';
	$rsss[] = 'http://www.pornhub.com/feed/mature.xml';
	$rsss[] = 'http://www.pornhub.com/feed/milf.xml';
	$rsss[] = 'http://www.pornhub.com/feed/orgy.xml';
	$rsss[] = 'http://www.pornhub.com/feed/outdoor.xml';
	$rsss[] = 'http://www.pornhub.com/feed/party.xml';
	$rsss[] = 'http://www.pornhub.com/feed/pornstar.xml';
	$rsss[] = 'http://www.pornhub.com/feed/pov.xml';
	$rsss[] = 'http://www.pornhub.com/feed/reality.xml';
	$rsss[] = 'http://www.pornhub.com/feed/red-head.xml';
	$rsss[] = 'http://www.pornhub.com/feed/rough-sex.xml';
	$rsss[] = 'http://www.pornhub.com/feed/shemale.xml';
	$rsss[] = 'http://www.pornhub.com/feed/small-tits.xml';
	$rsss[] = 'http://www.pornhub.com/feed/solo-male.xml';
	$rsss[] = 'http://www.pornhub.com/feed/squirt.xml';
	$rsss[] = 'http://www.pornhub.com/feed/striptease.xml';
	$rsss[] = 'http://www.pornhub.com/feed/teen.xml';
	$rsss[] = 'http://www.pornhub.com/feed/threesome.xml';
	$rsss[] = 'http://www.pornhub.com/feed/toys.xml';
	$rsss[] = 'http://www.pornhub.com/feed/uniforms.xml';
	$rsss[] = 'http://www.pornhub.com/feed/vintage.xml';
	$rsss[] = 'http://www.pornhub.com/feed/webcam.xml';
	
	foreach($rsss as $rss)
	{
		Rss::getInstance()->url = $rss;
		Rss::getInstance()->curl = false;
		Rss::getInstance()->clean = true;
		Rss::getInstance()->run();
	}

	unlink(dirname(__FILE__) . "/.process_import_pornhub_rss");
}