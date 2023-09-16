<?php

Namespace DoyouWatch\Database;

Use DoyouWatch\Config;
Use PDO;

/**
 * Database class.
 */
Class Database
{	/**
     * sql_prefix
     * 
     * @var mixed
	 *
     * @access private
     */
	private $sql_prefix;

	/**
     * _instance
     * 
     * @var mixed
	 *
     * @access private
     */
	private static $_instance;
	
	/**
     * getInstance function.
     * 
     * @access private
     * @return void
     */
	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Database();
		}
		return self::$_instance;
	}
	
	/**
     * get function.
     * 
	 * @param string key
	 *
     * @access private
     * @return void
     */
	public function get($key)
	{
		if(!isset($this->{$key}))
		{
			return null;
		}
		return $this->{$key};
	}	
	
	/**
     * connect function.
     * 
     * @access public
     * @return mixed
     */
	public function connect()
	{
		try
		{
			//$config = new Config();
			
			$options['OPTIONS']	= array(
											PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
											PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);
			
			$pdo = new PDO(
							Config::getInstance()->get('sql_driver') .':host='. Config::getInstance()->get('sql_host') .';dbname='. Config::getInstance()->get('sql_dbname'),
							Config::getInstance()->get('sql_user'),
							Config::getInstance()->get('sql_password'),
							$options['OPTIONS']
			);
			
		}
		catch(Exception $e)
		{
			trigger_error($e->getMessage(), E_USER_ERROR);
		}
		finally
		{
			$this->sql_prefix = Config::getInstance()->get('sql_prefix');
			return $pdo;
		}
	}
	
	public function getCategoriesVideos()
	{
		return array(
						''						=> 'Others',
						'3D'					=> '3D',
						'3d'					=> '3D',
						'Amateur'				=> 'Amateur',
						'Anal'					=> 'Anal',
						'Anime'					=> 'Anime',
						'Asian'					=> 'Asian',
						'Babe'					=> 'Babe',
						'Bareback'				=> 'Bareback',
						'BBW'					=> 'BBW',
						'Bbw/bear'				=> 'BBW',
						'Bdsm'					=> 'Bdsm',
						'Bear'					=> 'BBW',
						'Bear-Gay'				=> 'BBW',
						'Bears/hairy'			=> 'BBW',
						'Bi/straight Guys'		=> 'Bi/straight Guys',
						'Big Ass'				=> 'Big Ass',
						'Big Boobs'				=> 'Big Boobs',
						'Big Butt'				=> 'Big Ass',
						'Big Cock'				=> 'Big Dick',
						'Big Cocks'				=> 'Big Dick',
						'Big Dick'				=> 'Big Dick',
						'Big Tits'				=> 'Big Tits',
						'Bisexual'				=> 'Bisexual',
						'Black'					=> 'Black',
						'Blonde'				=> 'Blonde',
						'Blowjob'				=> 'Blowjob',
						'Bondage'				=> 'Bondage',
						'Brunette'				=> 'Brunette',
						'Bukkake'				=> 'Bukkake',
						'Bush'					=> 'Bush',
						'Butts'					=> 'Ass',
						'Camel Toe'				=> 'Camel Toe',
						'Celebrity'				=> 'Celebrity',
						'Coed'					=> 'Coed',
						'College'				=> 'College',
						'College/jocks'			=> 'College',
						'Compilation'			=> 'Compilation',
						'Couples'				=> 'Couples',
						'Creampie'				=> 'Creampie',
						'Cumshot'				=> 'Cumshot',
						'Cumshots'				=> 'Cumshot',
						'Cunnilingus'			=> 'Cunnilingus',
						'Daddies'				=> 'Daddies',
						'Daddy'					=> 'Daddies',
						'Daddy/mature'			=> 'Daddies',
						'Dildo/toys'			=> 'Dildo/toys',
						'Dildos/toys'			=> 'Dildo/toys',
						'Dildos/Toys'			=> 'Dildo/toys',
						'Double Penetration'	=> 'Double Penetration',
						'Dp'					=> 'Double Penetration',
						'Ebony'					=> 'Ebony',
						'Euro'					=> 'Euro',
						'European'				=> 'Euro',
						'Facial'				=> 'Facial',
						'Facials'				=> 'Facial',
						'Fantasy'				=> 'Fantasy',
						'Fetish'				=> 'Bdsm',
						'Fetish & Bdsm'			=> 'Bdsm',
						'Fingering'				=> 'Fingering',
						'Fisting'				=> 'Fisting',
						'For Woman'				=> 'For Women',
						'For Women'				=> 'For Women',
						'Funny'					=> 'Funny',
						'Fursuits'				=> 'Fursuits',
						'Gangbang'				=> 'Gangbang',
						'Gay'					=> 'Gay',
						'German'				=> 'German',
						'Gonzo'					=> 'Gonzo',
						'Group'					=> 'Group',
						'Group Sex'				=> 'Group',
						'Hairy'					=> 'Hairy',
						'Handjob'				=> 'Handjob',
						'Hardcore'				=> 'Hardcore',
						'HD'					=> 'HD',
						'Hentai'				=> 'Hentai',
						'Hentai & Anime'		=> 'Hentai',
						'Homemade'				=> 'Homemade',
						'Hunks'					=> 'Hunks',
						'Indian'				=> 'Indian',
						'Interracial'			=> 'Interracial',
						'Interview'				=> 'Interview',
						'Japanese'				=> 'Japanese',
						'Japanese Censored'		=> 'Japanese',
						'Jerk-Off'				=> 'Jerk-Off',
						'Kissing'				=> 'Kissing',
						'Latina'				=> 'Latina/latino',
						'Latina/latino'			=> 'Latina/latino',
						'Latino'				=> 'Latina/latino',
						'Lesbian'				=> 'Lesbian',
						'Lingerie'				=> 'Lingerie',
						'Massage'				=> 'Massage',
						'Masturbate'			=> 'Masturbation',
						'Masturbation'			=> 'Masturbation',
						'Mature'				=> 'Mature',
						'MILF'					=> 'MILF',
						'Milf/dilf'				=> 'MILF',
						'Miscellaneous'			=> 'Miscellaneous',
						'Muscle'				=> 'Muscle',
						'Muscle Guys'			=> 'Muscle',
						'Muscle Worship'		=> 'Muscle',
						'Muscles'				=> 'Muscle',
						'My Cock'				=> 'My Cock',
						'News'					=> 'News',
						'Orgy'					=> 'Orgy',
						'Outdoor'				=> 'Outdoor',
						'Panties/underwear'		=> 'Panties/underwear',
						'Panties'				=> 'Panties/underwear',
						'Pantyhose'				=> 'Pantyhose',
						'Party'					=> 'Party',
						'Porn Stars'			=> 'Pornstar',
						'Pornstar'				=> 'Pornstar',
						'POV'					=> 'POV',
						'Public'				=> 'Public',
						'Reality'				=> 'Reality',
						'Red Head'				=> 'Red Head',
						'Redhead'				=> 'Red Head',
						'Romantic'				=> 'Romantic',
						'Rimming'				=> 'Rimming',
						'Rough Sex'				=> 'Rough Sex',
						'Sex'					=> 'Sex',
						'Shaved'				=> 'Shaved',
						'Shemale'				=> 'Shemale',
						'Small Tits'			=> 'Small Tits',
						'Softcore'				=> 'Softcore',
						'Solo & Masturbation'	=> 'Solo',
						'Solo Girl'				=> 'Solo',
						'Solo Male'				=> 'Solo',
						'Spanking'				=> 'Spanking',
						'Squirt'				=> 'Squirt',
						'Squirting'				=> 'Squirt',
						'Straight Guys'			=> 'Straight',
						'Straight Sex'			=> 'Straight',
						'Striptease'			=> 'Striptease',
						'Swallow'				=> 'Swallow',
						'Swingers'				=> 'Swingers',
						'Teen'					=> 'Teen',
						'Teen/twink'			=> 'Teen',
						'Teens'					=> 'Teen',
						'Threesome'				=> 'Threesome',
						'Toys'					=> 'Toys'	,
						'Transexual'			=> 'Transexual',
						'Twink'					=> 'Twink',
						'Twinks'				=> 'Twink',
						'Uniforms'				=> 'Uniforms',
						'Vintage'				=> 'Vintage',
						'Voyeur'				=> 'Voyeur',
						'Webcam'				=> 'Webcam',
						'Wild & Crazy'			=> 'Wild & Crazy',
						'Yaoi'					=> 'Yaoi',
						'Young/Old'				=> 'Young/Old',
						
						'Albanian'				=> 'Albanian',
						'Algerian'				=> 'Algerian',
						'Arab'					=> 'Arab',
						'Argentinian'			=> 'Argentinian',
						'Armenian'				=> 'Armenian',
						'Ass Licking'			=> 'Ass',
						'Audition'				=> 'Audition',
						'Australian'			=> 'Australian',
						'Austrian'				=> 'Austrian',
						'Azeri'					=> 'Azeri',
						'Bangladeshi'			=> 'Bangladeshi',
						'Ballbusting'			=> 'Ballbusting',
						'Belgian'				=> 'Belgian',
						'Bolivian'				=> 'Bolivian',
						'Bosnian'				=> 'Bosnian',
						'Brazilian'				=> 'Brazilian',
						'British'				=> 'British',
						'Bulgarian'				=> 'Bulgarian',
						'Cambodian'				=> 'Cambodian',
						'Canadian'				=> 'Canadian',
						'Chilean'				=> 'Chilean',
						'Chinese'				=> 'Chinese',
						'Colombian'				=> 'Colombian',
						'Croatian'				=> 'Croatian',
						'Czech'					=> 'Czech',
						'Danish'				=> 'Danish',
						'Dutch'					=> 'Dutch',
						'Ecuador'				=> 'Ecuador',
						'Egyptian'				=> 'Egyptian',
						'Estonia'				=> 'Estonia',
						'French'				=> 'French',
						'German'				=> 'German',
						'Greek'					=> 'Greek',
						'Guadeloupe'			=> 'Guadeloupe',
						'Guatemala'				=> 'Guatemala',
						'Hungarian'				=> 'Hungarian',
						'Indonesian'			=> 'Indonesian',
						'Iranian'				=> 'Iranian',
						'Irish'					=> 'Irish',
						'Israeli'				=> 'Israeli',
						'Italian'				=> 'Italian',
						'Jamaican'				=> 'Jamaican',
						'Korean'				=> 'Korean',
						'Latvian'				=> 'Latvian',
						'Lithuanian'			=> 'Lithuanian',
						'Macedonian'			=> 'Macedonian',
						'Malaysian'				=> 'Malaysian',
						'Medical'				=> 'Medical',
						'Mexican'				=> 'Mexican',
						'Military'				=> 'Military',
						'Moldavian'				=> 'Moldavian',
						'Moroccan'				=> 'Moroccan',
						'Nigerian'				=> 'Nigerian',
						'Norwegian'				=> 'Norwegian',
						'Pakistani'				=> 'Pakistani',
						'Peruvian'				=> 'Peruvian',
						'Philippines'			=> 'Philippines',
						'Polish'				=> 'Polish',
						'Portuguese'			=> 'Portuguese',
						'Puerto Rican'			=> 'Puerto Rican',
						'Romanian'				=> 'Romanian',
						'Russian'				=> 'Russian',
						'Serbian'				=> 'Serbian',
						'Singaporean'			=> 'Singaporean',
						'Slovakian'				=> 'Slovakian',
						'Slovenian'				=> 'Slovenian',
						'Spanish'				=> 'Spanish',
						'Sri Lankan'			=> 'Sri Lankan',
						'Swedish'				=> 'Swedish',
						'Swiss'					=> 'Swiss',
						'Sybian'				=> 'Sybian',
						'Thai'					=> 'Thai',
						'Tunisian'				=> 'Tunisian',
						'Turkish'				=> 'Turkish',
						'Ukrainian'				=> 'Ukrainian',
						'Venezuelan'			=> 'Venezuelan',
						'Vietnamese'			=> 'Vietnamese',
						'Slovenian'				=> 'Slovenian',
						'Spanish'				=> 'Spanish',
						'Sri Lankan'			=> 'Sri Lankan',
		);
	}
}