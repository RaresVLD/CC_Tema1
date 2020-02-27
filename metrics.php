<?php
	/**
	 * Created by PhpStorm.
	 * User: Rares
	 * Date: 27-Feb-20
	 * Time: 5:11 PM
	 */

	$raw_data = file_get_contents('apiData.txt');
	$data = explode("&break&", $raw_data);
	
	$responseHtml = '';
	foreach ( $data as $response ) {
		$responseHtml .= '<span>' . $response . "</span>";
	}
	
	echo json_encode(['html' => $responseHtml]);
	
?>
