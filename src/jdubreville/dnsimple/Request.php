<?php
namespace jdubreville\dnsimple;

class Request
{
	/**
	* Setup an endpoint URL
	*
	* @param string $endPoint
	*
	* @return string
	*/
    public static function prepare($endPoint) {
        $addParams = array();
        if(count($addParams)) {
            return $endPoint.(strpos($endPoint, '?') === false ? '?' : '&').http_build_query($addParams);
        } else {
            return $endPoint;
        }
    }
	
	public static function send(Client $client, $endPoint, $data = null, $method = "GET", $contentType = "application/json")
	{
		$url = $client->getApiUrl() . $endPoint;
		
		$method = strtoupper($method); 
		
		if($data == null)
		{
			$data = new \stdClass();
		}
		else if ($contentType == "application/json" && $method != "GET" && $method != "DELETE")
		{
			$data = json_encode($data);
		}
		
		switch($method)
		{
			case "POST":
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				if (is_array($data) && (isset($data["file"]))) 
				{
					$fileName = $data["file"];
					$file     = fopen($fileName, "r");
					$fileSize = filesize($fileName);
					$fileData = fread($file, $fileSize);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $fileData);
					curl_setopt($curl, CURLOPT_INFILE, $file);
					curl_setopt($curl, CURLOPT_INFILESIZE, $fileSize);
					curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/binary"));
				}
				break;
			case "PUT":
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			default:
				$curl = curl_init(
						$url . ($data != (object)null ? (strpos($url, "?") === false ? "?" : "&") . http_build_query($data) : "")
				);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, ($method ? $method : "GET"));
				break;
		}
		
		//curl_setopt($curl, CURLOPT_USERPWD, $client->getAuthText());
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: " . $contentType, "Accept: application/json","X-DNSimple-Token: ". $client->getAuthText() ));
	
		curl_setopt($curl, CURLINFO_HEADER_OUT, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
		$response = curl_exec($curl);
		if ($response === false) {
			throw new \Exception('No response from curl_exec in ' . __METHOD__);
		}
		$headerSize   = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$responseBody = substr($response, $headerSize);
		
		
		$client->setDebug(
			curl_getinfo($curl, CURLINFO_HEADER_OUT),
			curl_getinfo($curl, CURLINFO_HTTP_CODE),
			substr($response, 0, $headerSize)
		);
		
		$response = new Response();
		
		$response->code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$response->json = json_decode($responseBody);
		
		if(!$response->isSuccessful())
		{
			$response->errors = $response->json;
		}
		
		return $response;
	}
}