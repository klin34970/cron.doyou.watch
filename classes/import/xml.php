<?php

namespace DoyouWatch\Import;

Use DoyouWatch\Html\Minimizer;
Use DoyouWatch\Database\Database;
USe PDO;

/**
 * Xml class.
 */
Class Xml
{
	
	/**
     * url
     * 
     * @var string
     * @access public
     */
	public $url;
	
	/**
     * domain
     * 
     * @var string
     * @access public
     */
	public $domain;
	
	/**
     * previous_url
     * 
     * @var string
     * @access public
     */
	public $previous_url;	
	
	/**
     * curl
     * 
     * @var bool
     * @access public
     */
	public $curl;	
	
	/**
     * clean
     * 
     * @var bool
     * @access public
     */
	public $clean;
	
	/**
     * clean
     * 
     * @var bool
     * @access public
     */
	public $dev;

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
			self::$_instance = new Xml();
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
     * run function.
     * 
     * @access public
     * @return void
     */
	public function run()
	{
		if($this->url && $this->url != $this->previous_url)
		{
			$this->getVideoData();
			$this->previous_url = $this->url;
		}
	}
	
	/**
     * getData function.
     * 
     * @access private
     * @return string
     */
	private function getData()
	{
		if($this->curl)
		{
			//setting the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->url);
			curl_setopt($ch, CURLOPT_HEADER,true);
			curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
			curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_COOKIESESSION,true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
			$data = curl_exec($ch);
			curl_close($ch);	
			
			//echo '<pre>',print_r($data, 1),'</pre>';
		}
		else
		{
			$data = file_get_contents($this->url);
		}

		if($this->clean)
		{
			$data = str_replace('sep=|', '', $data);
			$data = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $data);
			
			$xml = simplexml_load_string(Minimizer::minify_html($data), null, LIBXML_NOCDATA);
		}
		else
		{
			$xml = simplexml_load_string($data, null, LIBXML_NOCDATA);
		}
		
		$this->domain = str_replace('www.', '', parse_url($this->url, PHP_URL_HOST));
		
		return $xml;
	}
	
	/**
     * getVideoData function.
     * 
     * @access private
     * @return void
     */
	private function getVideoData()
	{
		$datas = $this->getData();
		//echo '<pre>',print_r($this->domain, 1),'</pre>';
		if(!empty($datas))
		{
			//echo '<pre>',print_r($datas, 1),'</pre>';
			
			switch($this->domain)
			{
					case 'partners.xhamster.com':
						foreach($datas as $data)
						{
							$hour = 0;
							$min = 0;
							$sec = 0;
							if(strpos($data->StreamRotatorDuration, 'm'))
							{
								$sec = explode('m', $data->StreamRotatorDuration);
								$sec = str_replace('s', '', $sec[1]);
								
								$min = explode('m', $data->StreamRotatorDuration);
								$min = $min[0] * 60;
							}
							if(strpos($data->StreamRotatorDuration, 'h'))
							{
								$hour = explode('h', $data->StreamRotatorDuration);
								$hour = $hour[0] * 60 * 60;
							}
							$duration = $hour + $min + $sec;
							
							//echo '<pre>',print_r($duration, 1),'</pre>';
							
							$re = '/(?<!_)src=([\'"])?(.*?)\\1/'; 
							preg_match($re, $data->description, $matches);
							
							$video['id']			= str_replace('video=', '', parse_url($data->StreamRotatorContent)['query']);
							$video['url']			= $data->StreamRotatorContent;
							$video['categories']	= explode(';', $data->StreamRotatorInfo);
							$video['title']			= $data->title;
							$video['tags']			= explode(';', $data->StreamRotatorInfo);
							$video['duration']		= $duration;
							$video['thumbnail']		= $matches[2];
							$video['domain']		= 'xhamster.com';
							
							echo '<pre>',print_r($video, 1),'</pre>';
							
							$this->storeVideoData($video);
						}
						
						break;
						
					case 'pornhub.com':
						
						foreach($datas as $data)
						{
							$video['id']			= $data->attributes()->id;
							$video['url']			= 'http://www.pornhub.com/embed/' . $video['id'];
							$video['categories']	= explode(';', $data->categories);
							$video['title']			= $data->title;
							$video['tags']			= explode(';', $data->tags);
							$video['duration']		= $data->duration;
							$video['thumbnail']		= $data->thumbnail;
							$video['domain']		= 'pornhub.com';
							
							echo '<pre>',print_r($video, 1),'</pre>';
							
							$this->storeVideoData($video);
						}
						
						break;
					
					case 'redtube.com':

						foreach($datas as $data)
						{
							$duration_parts			= explode(':', $data->duration);
							$count					= count($duration_parts);
							
							if($count == 2)
							{
								$duration_parts[0] 	= str_pad($duration_parts[0], 2, '0', STR_PAD_LEFT);
								$duration_parts[1] 	= str_pad($duration_parts[1], 2, '0', STR_PAD_RIGHT);
								$seconds 			= $duration_parts[0] * 60 + $duration_parts[1];
							}
							else if($count == 3)
							{
								$duration_parts[0] 	= str_pad($duration_parts[0], 2, '0', STR_PAD_LEFT);
								$duration_parts[1] 	= str_pad($duration_parts[1], 2, '0', STR_PAD_LEFT);
								$duration_parts[2] 	= str_pad($duration_parts[2], 2, '0', STR_PAD_RIGHT);
								$seconds 			= $duration_parts[0] * 3600 + $duration_parts[1] * 60 + $duration_parts[2];
							}
							
							$video['id']			= $data->id;
							$video['url']			= 'http://embed.redtube.com/?id=' . $data->id . '&bgcolor=000000';
							$video['categories']	= (array)$data->categories->category;
							$video['title']			= $data->title;
							$video['tags']			= (array)$data->tags->tag;
							$video['duration']		= $seconds;
							$video['thumbnail']		= explode(';', $data->thumbs->thumb)[0];
							$video['domain']		= 'redtube.com';
							
							echo '<pre>',print_r($video, 1),'</pre>';
							
							$this->storeVideoData($video);
						}
						
						break;
						
					case 'tube8.com':

						foreach($datas as $data)
						{
							$url_parts				= parse_url($data->url);
							$video['id']			= $data->attributes()->id;
							$video['url']			= $url_parts['scheme'] . '://' . $url_parts['host'] . '/embed' . $url_parts['path'];
							$video['categories']	= explode(';', $data->categories);
							$video['title']			= $data->title;
							$video['tags']			= explode(';', $data->tags);
							$video['duration']		= $data->duration;
							$video['thumbnail']		= $data->thumbnail;
							$video['domain']		= 'tube8.com';
							
							echo '<pre>',print_r($video, 1),'</pre>';
							
							$this->storeVideoData($video);
						}
						
						break;
						
					case 'youporn.com':
					
						foreach($datas as $data)
						{
							$video['id']			= $data->attributes()->id;
							$video['url']			= 'http://www.youporn.com/embed/' . $video['id'];
							$video['categories']	= explode(';', $data->categories);
							$video['title']			= $data->title;
							$video['tags']			= explode(';', $data->tags);
							$video['duration']		= $data->duration;
							$video['thumbnail']		= $data->thumbnail;
							$video['domain']		= 'youporn.com';
							
							echo '<pre>',print_r($video, 1),'</pre>';;
							
							$this->storeVideoData($video);
						}
						
						break;
						
					case 'xtube.com':
						
						foreach($datas as $data)
						{
							/* they change their xml
							$duration_parts			= explode(':', $data->duration);
							$count					= count($duration_parts);
							
							if($count == 2)
							{
								$duration_parts[0] 	= str_pad($duration_parts[0], 2, '0', STR_PAD_LEFT);
								$duration_parts[1] 	= str_pad($duration_parts[1], 2, '0', STR_PAD_RIGHT);
								$seconds 			= $duration_parts[0] * 60 + $duration_parts[1];
							}
							else if($count == 3)
							{
								$duration_parts[0] 	= str_pad($duration_parts[0], 2, '0', STR_PAD_LEFT);
								$duration_parts[1] 	= str_pad($duration_parts[1], 2, '0', STR_PAD_LEFT);
								$duration_parts[2] 	= str_pad($duration_parts[2], 2, '0', STR_PAD_RIGHT);
								$seconds 			= $duration_parts[0] * 3600 + $duration_parts[1] * 60 + $duration_parts[2];
							}
							*/
							
							$video['id']			= str_replace('v=', '', parse_url($data->embed)['query']);
							$video['url']			= 'http://www.xtube.com/embedded/user/play.php?v=' . $video['id'] . '&embedSize=big';
							$video['categories']	= explode(';', $data->categories);
							$video['title']			= $data->title;
							$video['tags']			= explode(';', $data->tags);
							$video['duration']		= $data->duration;
							$video['thumbnail']		= $data->thumbnail;
							$video['domain']		= 'xtube.com';
							
							echo '<pre>',print_r($video, 1),'</pre>';
							
							$this->storeVideoData($video);
						}
						
						
						break;
						
					case 'spankwire.com':
					
						foreach($datas as $data)
						{
							$duration_parts			= date_parse($data->attributes()['duration']);
							$seconds 				= $duration_parts['hour'] * 3600 + $duration_parts['minute'] * 60 + $duration_parts['second'];
							
							$video['id']			= $data->attributes()['video_id'];
							$video['url']			= 'http://www.spankwire.com/EmbedPlayer.aspx?ArticleId=' . $video['id'];
							$video['categories']	= (array)$data->tags->tag;
							$video['title']			= $data->title;
							$video['tags']			= (array)$data->tags->tag;
							$video['duration']		= $seconds;
							$video['thumbnail']		= $data->attributes()['thumb'];
							$video['domain']		= 'spankwire.com';
							
							//echo '<pre>',print_r($data, 1),'</pre>';
							
							//$this->storeVideoData($data);
						}
						
						break;
			}
			
		}
	}
	
	private function storeVideoData($video)
	{
		if(
			$video['id'] != "" 
			&& $video['url'] != "" 
			&& $video['categories'] != "" 
			&& $video['title'] != "" 
			&& $video['tags'] != "" 
			&& $video['duration'] != "" 
			&& $video['thumbnail'] != ""
			&& $video['domain'] != ""
		)
		{
			$bdd = Database::getInstance()->connect();
			
			$query = $bdd->prepare(
									'
									SELECT 
										* 
									FROM 
										' . Database::getInstance()->get('sql_prefix') . 'videos 
									WHERE 
										video_id = :video_id
									AND
										domain = :domain
									'
			);
			$query->bindValue('video_id', $video['id'], PDO::PARAM_STR);
			$query->bindValue('domain', $video['domain'], PDO::PARAM_STR);
			$query->execute();

			echo '<pre>',print_r($query->rowCount(), 1),'</pre>';
			
			
			if($query->rowCount() == 0)
			{
				
				$video['tags'] = implode(' ', $video['tags']);
				$categories = array();
				foreach($video['categories'] as $category)
				{
					if(array_key_exists(ucfirst($category), Database::getInstance()->getCategoriesVideos()))
					{
						
						$categories[] = Database::getInstance()->getCategoriesVideos()[ucfirst($category)];
					}
					else if(array_key_exists($category, Database::getInstance()->getCategoriesVideos()))
					{
						
						$categories[] = Database::getInstance()->getCategoriesVideos()[ucfirst($category)];
					}
				}
				
				if(empty($categories)) $categories[0] = 'Others';
				$query = $bdd->prepare(
										'
										INSERT INTO 
											' . Database::getInstance()->get('sql_prefix') . 'videos
										(
											domain, 
											video_id,
											url,
											categories,
											title,
											duration,
											thumbnail,
											tags,
											date
										) 
											VALUES
										(
											:domain, 
											:video_id,
											:url,
											:categories,
											:title,
											:duration,
											:thumbnail,
											:tags,
											:date
										)
										'
				);
				
				if($video['title'] == '') $video['title'] = 'No title';
				
				$query->bindValue('domain', 		$video['domain'], 				PDO::PARAM_STR);
				$query->bindValue('video_id', 		$video['id'], 					PDO::PARAM_INT);
				$query->bindValue('url', 			$video['url'], 					PDO::PARAM_STR);
				$query->bindValue('categories', 	implode(', ', $categories), 	PDO::PARAM_STR);
				$query->bindValue('title', 			$video['title'], 				PDO::PARAM_STR);
				$query->bindValue('duration', 		$video['duration'], 			PDO::PARAM_INT);
				$query->bindValue('thumbnail', 		$video['thumbnail'], 			PDO::PARAM_STR);
				$query->bindValue('tags', 			$video['tags'], 				PDO::PARAM_STR);
				$query->bindValue('date', 			date('Y-m-d H:i:s'),			PDO::PARAM_STR);
				
				if(!$this->dev)
				{
					$query->execute();
				}
				echo '<pre>',print_r($video, 1),'</pre>';

			}
		}
	}

}
