<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Rss;

if(!file_exists(dirname(__FILE__) . "/.process_import_porndig_rss"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_porndig_rss", "w");
	fclose($process);
	
	$rsss[] = 'https://www.porndig.com/rss/top/videos.xml';
	$rsss[] = 'https://www.porndig.com/rss/top/pornstars.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/33/anal.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/89/anal-virgins.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/91/arab.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/38/asian.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/46/bbw.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/43/big-boobs.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/802/big-dick.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/45/black.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/878/black-booty.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/36/blonde.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/52/blowjob.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/55/bondage-bdsm.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/63/brunette.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/59/bukkake.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/87/casting-porno.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/47/creampie.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/35/cum-swallowing.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/799/cumshot.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/80/deep-throat.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/73/domination.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/64/double-penetration.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/83/emo-gothic.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/1117/european.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/820/ex-girlfriend.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/803/exhibitionist.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/807/extreme.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/50/facial-ejaculation.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/65/female-friendly.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/57/fetish.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/66/fist-fucking.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/875/foot-fetish.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/882/full-hd.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/82/gang-bang.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/85/golden-showers.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/814/grandma.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/855/hairy-pussy.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/51/hentai.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/53/interracial.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/54/latina.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/40/lesbian.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/74/massage.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/48/masturbation.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/41/mature.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/77/mature-and-young-guy.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/877/midgets.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/39/milf.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/93/natural-big-tits.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/76/old-man-young-girl.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/42/orgy.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/884/outdoor.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/879/pornstar.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/58/pov.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/860/pregnant.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/60/redhead.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/1125/rimming.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/815/secretary.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/856/sextoys.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/75/sexy-lingerie.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/67/small-tits.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/822/smoking.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/805/soft.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/810/spying.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/68/squirters.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/816/stockings.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/819/strap-on.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/79/student.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/1043/threesome.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/86/tit-wank.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/1172/uhd-4k.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/84/uniforms.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/850/vintage.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/1042/violent-sex.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/88/virgin.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/70/webcam.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/90/xxx-scenario.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/34/young.xml';
	$rsss[] = 'https://www.porndig.com/rss/channel/812/young-black.xml';
	
	foreach($rsss as $rss)
	{
		Rss::getInstance()->url = $rss;
		Rss::getInstance()->curl = false;
		Rss::getInstance()->clean = false;
		Rss::getInstance()->run();
	}

	unlink(dirname(__FILE__) . "/.process_import_porndig_rss");
}