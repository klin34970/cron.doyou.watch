<?php

namespace DoyouWatch\Import;

Use DoyouWatch\Html\Minimizer;
Use DoyouWatch\Database\Database;
USe PDO;

/**
 * Rss class.
 */
Class Rss
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
     * dev
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
			self::$_instance = new Rss();
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
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			$data = curl_exec($ch);
			curl_close($ch);	
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
		
		//echo '<pre>',print_r($xml, 1),'</pre>';
		
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
		//echo '<pre>',print_r($datas->title, 1),'</pre>';
		if(!empty($datas))
		{
			switch($this->domain)
			{
				case 'vporn.com':
						foreach($datas->channel->item as $data)
						{
							preg_match_all('/(?<!_)src=([\'"])?(.*?)\\1/', $data->description, $srcs);
							
							$result = array();
							$array = explode(' ', $data->title);
							foreach($array as $word)
							{
								if(strlen($word) >= 4)
								{
									$result[] = $word;
								}	
							}
							
							/* check images 404 */
							$thumbnail = '';
							$thumb = $srcs[2][1];
							
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $thumb);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
							curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
							curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
							curl_setopt($ch, CURLOPT_TIMEOUT, 20);
							$rt = curl_exec($ch);
							$info = curl_getinfo($ch);
							//print_r($info);
							
							if($info["http_code"] == 200) 
							{
								$thumbnail = $thumb;
							}
							
							curl_close($ch);
							/* check images 404 */
							
							/* duration */
							$lastduration = 0;
							preg_match('/Duration : (.+)Url/', strip_tags($data->description), $duration);
							
							if(strpos($duration[1], 'min'))
							{
								$duration2 = str_replace(' min', '', $duration[1]);
								$duration2 = explode('.', $duration2);
								$lastduration = ($duration2[0] * 60) + $duration2[1];
								
							}
							else if(strpos($duration[1], 'hrs'))
							{
								$duration2 = str_replace(' hrs', '', $duration[1]);
								$duration2 = explode('.', $duration2);
								$lastduration = ($duration2[0] * 60 * 60) + ($duration2[1] * 60);
								
							}
							
							/* duration */
							
							
							$video['id']			= str_replace('video', '', $data->guid);
							$video['url']			= 'http://www.vporn.com/embed/'.str_replace('video', '', $data->guid); 
							$video['categories']	= $result;
							$video['title']			= $data->title;
							$video['tags']			= $result;
							$video['duration']		= $lastduration;
							$video['thumbnail']		= $thumbnail;
							$video['domain']		= 'vporn.com';
							
							
							echo '<pre>',print_r($video, 1),'</pre>';
							
							$this->storeVideoData($video);
						}
					break;
					
				case 'porndig.com':
					foreach($datas->channel->item as $data)
					{
						//search img src
						preg_match_all('/(?<!_)src=([\'"])?(.*?)\\1/', $data->description, $srcs);
						
						/* search words int title for categories and tags */
						$parts = parse_url($data->link);
						$parts = explode('/', $parts['path']);
						
						$result = array();
						$array = explode(' ', $data->title);
						foreach($array as $word)
						{
							if(strlen($word) >= 4)
							{
								$result[] = $word;
							}	
						}
						/* search words int title for categories and tags */
						
						/* check images 404 */
						$thumbnail = '';
						$thumb = str_replace('http://', 'https://', $srcs[2][0]);
						
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $thumb);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
						curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
						curl_setopt($ch, CURLOPT_TIMEOUT, 20);
						$rt = curl_exec($ch);
						$info = curl_getinfo($ch);
						//print_r($info);
						
						if($info["http_code"] == 200) 
						{
							$thumbnail = $thumb;
						}
						
						curl_close($ch);
						/* check images 404 */
						
						
						$video['id']			= $parts[2];
						$video['url']			= $srcs[2][1];
						$video['categories']	= $result;
						$video['title']			= $data->title;
						$video['tags']			= $result;
						$video['duration']		= 1;
						$video['thumbnail']		= $thumbnail;
						$video['domain']		= 'porndig.com';
						
						//echo '<pre>',print_r($video, 1),'</pre>';
						
						//Insert
						$this->storeVideoData($video);
					}
					break;
				case 'xvideos.com':
					foreach($datas->channel->item as $data)
					{
						$result = array();
						$array = explode(' ', $data->title);
						foreach($array as $word)
						{
							if(strlen($word) >= 4)
							{
								$result[] = $word;
							}	
						}
						
						preg_match('/Duration : (.+) min<br>/', $data->description, $duration);
						
						$hour = 0;
						$min = 0;
						if(strpos($duration[1], 'h'))
						{
							$time = explode('h ', $duration[1]);
							$hour = $time[0] * 60 * 60;
							$min = $time[0] * 60;
						}
						else
						{
							$min = $duration[1] * 60;
						}
						
						$duration = $hour + $min;
						
						preg_match('/(?<!_)src=([\'"])?(.*?)\\1/', $data->description, $thumbnail);
						
						$video['id']			= $data->guid;
						$video['url']			= 'http://flashservice.xvideos.com/embedframe/' . $video['id'];
						$video['categories']	= $result;
						$video['title']			= $data->title;
						$video['tags']			= $result;
						$video['duration']		= $duration;
						$video['thumbnail']		= $thumbnail[2];
						$video['domain']		= 'xvideos.com';
						//echo '<pre>',print_r($video, 1),'</pre>';
						
						$this->storeVideoData($video);
					}
					break;
				case 'pornhub.com':
					
					foreach($datas->channel->item as $data)
					{
						$parts_url				= parse_url($data->link);
						$id						= str_replace('viewkey=', '', $parts_url['query']);
						$video['id']			= $id;
						$video['url']			= 'http://www.pornhub.com/embed/' . $video['id'];
						$video['categories']	= explode(',', $data->keywords);
						$video['title']			= $data->title;
						$video['tags']			= explode(',', $data->keywords);
						$video['duration']		= $data->duration;
						$video['thumbnail']		= $data->thumb_large;
						$video['domain']		= 'pornhub.com';
						//echo '<pre>',print_r($video, 1),'</pre>';
						
						$this->storeVideoData($video);
					}
					break;
					
				case 'feeds.redtube.com':
				
					foreach($datas->entry as $data)
					{	
						$parts_url				= parse_url($data->id);
						$id						= str_replace('/', '', $parts_url['path']);
						
						$regex = "/Duration:+\\s+[0-9]+:+[0-9]+/";  
						preg_match($regex, $data->summary, $matches);
						$duration				= str_replace('Duration: ', '', $matches[0]);
						
						$duration_parts			= explode(':', $duration);
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
						
						$regex = "/(\"+.+\")/";
						preg_match($regex, $data->summary, $matches2);
						$catandtag				= str_replace('": ', '', $matches2[0]);
						$catandtag				= explode(' ', $catandtag);
						
						$video['id']			= $id;
						$video['url']			= 'http://embed.redtube.com/?id=' . $video['id'] . '&bgcolor=000000';
						$video['categories']	= $catandtag;
						$video['title']			= $data->title;
						$video['tags']			= $catandtag;
						$video['duration']		= $seconds;
						$video['thumbnail']		= $data->link[1]->attributes()['href'];
						$video['domain']		= 'redtube.com';
						//echo '<pre>',print_r($video, 1),'</pre>';
						
						$this->storeVideoData($video);
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
				
				$query->bindValue('domain', 		$video['domain'], 					PDO::PARAM_STR);
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