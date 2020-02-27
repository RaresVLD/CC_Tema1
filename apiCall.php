<?php
	/**
	 * Created by PhpStorm.
	 * User: Rares
	 * Date: 26-Feb-20
	 * Time: 8:40 PM
	 */
	if(!$_GET['url']){
		echo false;
	}
	
	$ch = curl_init();
	
	curl_setopt( $ch, CURLOPT_URL, urldecode($_GET['url']) );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	$output = curl_exec( $ch );
	
	file_put_contents('apiData.txt', $output . "&break&", FILE_APPEND);
	
	curl_close( $ch );
	
	echo $output;
