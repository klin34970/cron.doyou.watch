<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Delete;

if(!file_exists(dirname(__FILE__) . "/.process_import_delete"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_delete", "w");
	fclose($process);
	
	$delete = new Delete();
	$delete->fetchAll();

	unlink(dirname(__FILE__) . "/.process_import_delete");
}