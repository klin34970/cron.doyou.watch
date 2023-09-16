<?php

namespace DoyouWatch\Import;

Use DoyouWatch\Html\Minimizer;
Use DoyouWatch\Database\Database;
USe PDO;

/**
 * Xml class.
 */
Class Delete
{

	public function fetchAll()
	{
		$bdd = Database::getInstance()->connect();
		$query = $bdd->query(
								'
									SELECT 
										* 
									FROM 
										' . Database::getInstance()->get('sql_prefix') . 'videos
									ORDER BY
										id
											DESC
								');
		//$query->execute();
		
		foreach($query->fetchAll() as $data)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $data['url']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			$rt = curl_exec($ch);
			$info = curl_getinfo($ch);
			
			if($info["http_code"] == 404)
				echo '<pre>',print_r($info["http_code"], 1),'</pre>';
		}
		
		
	}
	
}
