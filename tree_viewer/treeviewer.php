<?php
// access wp functions externally
require_once('../bootstrap.php');

if( empty($_GET['private_key']) || empty($_GET['user_id']) ) {
	echo "ERROR: No private key and/or user id";
	exit();
}

	include_once(dirname(__FILE__) . '/lib/groupdocs-php/api/APIClient.php');
    include_once(dirname(__FILE__) . '/lib/groupdocs-php/api/StorageAPI.php');

    $path = $_POST['dir'];
    if ($path == NULL || $path == "/") {
        $path = "";
    } 

    $private_key = $_GET['private_key'];
    $user_id = $_GET['user_id'];
    $api_client = new APIClient($private_key, "https://api.groupdocs.com/v2.0");

    $api = new StorageAPI($api_client);

    $cur_p = new StorageStorageInputFoldersInput();
    $cur_p->userId = $user_id;
    $cur_p->path = substr($path, 0, strlen($path)-1);
        
    $cur_p->pageIndex = '0';
    $cur_p->pageSize = '10';
    $cur_p->orderBy = '';
    $cur_p->orderAsc = 'false';
    $cur_p->filter = '';
    $cur_p->fileTypes = '';
    $cur_p->extended = 'false'; 
    
    try {
		$result = $api->ListEntities($cur_p);
		
		$files = $result->result->files;
		$folders = $result->result->folders;
	} catch (Exception $e) {
		echo "<script>show_server_error(jQuery)</script>";
	}
    
    print("<ul class=\"jqueryFileTree\" style=\"display: ;\">");
    if(!empty($folders)){
		foreach ($folders as $item) {
				print("<li class=\"directory collapsed\"><a href=\"#\" rel=\"" .
						  $path . $item->name . "/\">" . $item->name . "</a></li>");
		}
	}
	if(!empty($files)){
		foreach ($files as $item) {
				$href = $item->guid;
				print("<li class=\"file ext_" . strtolower($item->file_type) . "\"><a class='iframe' href='" . $href . "' rel=\"" .
							$item->guid . "\">" . $item->name . "</a></li>");
		}
	}
    print("</ul>");
