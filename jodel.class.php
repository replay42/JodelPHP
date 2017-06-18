<?php
        // replay42 // Dec. 2nd, 2015
        //
        // a Jodel-Class
        //

	include('library/Requests.php');
	Requests::register_autoloader();

	class Jodel {

		private $apiUrl = 'https://api.go-tellm.com/api/v2';
		private $header = array(  "Connection"            => "keep-alive",
		                   	  "Accept-Encoding"       => "gzip",
		                   	  "Content-Type"          => "application/json; charset=UTF-8",
		                        );
		

                private $colors = array('06A3CB', 'DD5F5F', '8ABDB0', 'FF9908', 'FFBA00', '9EC41C');
                private $udid = '';
                private $iSkip = 0;

                private $accessToken, $country, $city, $lat, $lng, $versionString, $secret;


                function __construct( $udid = '', $position = array(50.1183, 8.7011, 'Frankfurt am Main', 'DE')) {
                        // SetUp
                        $this->setUdid($udid);
                        $this->setPos($position[0], $position[1], $position[2], $position[3]);
						require 'config.php';
						$this->secret=$secret;
						$this->versionString=$versionString;
						$this->header['User-Agent']=$userAgentString;
                        $this->getAccessToken();
                }

                function setPos($lat, $lng, $city, $country = "DE") {
                        $this->city = $city;
                        $this->lat = $lat;
                        $this->lng = $lng;
                        $this->country = $country;
                }

                function setUdid( $udid = "" ) {
                        $this->udid = $udid;
                }

                function getUdid() {
                        // generte random udid each time program starts if no udid was set
                        if($this->udid != "")
                                return $this->udid;
                        else
                        	return hash('sha256', microtime());
                }

                function getColor() {
                        return array_rand($this->colors, 1);
                }

                function getAccessToken() {
                	$payload = array(
                		"client_id" => "81e8a76e-1e02-4d17-9ba0-8a7020261b26",
                		"device_uid" => $this->getUdid(),
                		"location" => array(
                			"loc_accuracy" => 19.0,
                			"city" => $this->city,
                			"loc_coordinates" => array(
                				"lat" => $this->lat,
                				"lng" => $this->lng
                			),
                			"country" => $this->country,
                		        "loc_accuracy" => 10.0
                		)
                	);

                	$response = $this->doPost('/users/', json_encode($payload));
                	if(empty($response))
						throw new Exception('Unable to get access token');
                    $this->accessToken = $response->access_token;
                    $this->header['Authorization'] = 'Bearer '.$this->accessToken;
                }
		//Copied from https://github.com/LauertBernd/JodelClientPHP/blob/master/src/JodelApi/Requests/AbstractRequest.php
		public function getSignHeaders($url,$method,$payload='')
		{
			$headers = $this->header;
			$timestamp = new DateTime();
			$timestamp = $timestamp->format(DateTime::ATOM);
			$timestamp = substr($timestamp, 0, -6);
			$timestamp .= "Z";
			$urlParts = parse_url($url);
			$url2 = "";
			$req = [$method,
				$urlParts['host'],
				"443",
				$urlParts['path'],
				"",
				$timestamp,
				$url2,
				$payload];
			$reqString = implode("%", $req);
			$secret = $this->secret;
			$signature = hash_hmac('sha1', $reqString, $secret);
			$signature = strtoupper($signature);
			$headers['X-Authorization'] = 'HMAC ' . $signature;
			$headers['X-Client-Type'] = 'android_'.$this->versionString;
			$headers['X-Timestamp'] = $timestamp;
			$headers['X-Api-Version'] = '0.2';
			return $headers;
		}

                function skip( $int = 0 ) {
                    if(is_int($int)) 
                        $this->iSkip = $int;
                    else
                        $this->iSkip = 0;
                }

               
                function getPosts($skip = NULL) {
                        return $this->doGet("/posts/");
                }

                function getLoudestPosts() {
                    return $this->doGet("/posts/location/popular/");
                }

                function getNewestPosts() {
                    return $this->doGet("/posts/location/");
                }

                function getMostDiscussed() {
                    return $this->doGet("/posts/location/discussed");
                }

                function getMyPosts() {
                        return $this->doGet("/posts/mine/");
                }

                function getMyLoudestPosts() {
                    return $this->doGet("/posts/mine/votes");
                }

                function getMyAnswers() {
                    return $this->doGet("/posts/mine/replies");
                }

                function getKarma() {
                        $response = $this->doGet("/users/karma/");
                        return $response->karma;
                }

                function post($text, $country = "DE") {
                        $payload = array(
                                "color" => $this->colors[$this->getColor()],
                                "location" => array(
                                        "loc_accuracy" => 10.0,
                                        "city" => $this->city,
                                        "loc_coordinates" => array(
                                                "lat" => $this->lat,
                                                "lng" => $this->lng
                                        ),
                                        "country" => $country,
                                        "name" => "41"           
                                ),
                                "message" => $text
                        );
                        return $this->doPost('/posts/', json_encode($payload));
                }

                function postImage($pathToFile, $country = "DE") {
                        $b64image = base64_encode(file_get_contents($pathToFile));
                        $payload = array(
                                "image" => $b64image,
                                "color" => $this->colors[$this->getColor()],
                                "location" => array(
                                        "loc_accuracy" => 10.0,
                                        "city" => $this->city,
                                        "loc_coordinates" => array(
                                                "lat" => $this->lat,
                                                "lng" => $this->lng
                                        ),
                                        "country" => $country,
                                        "name" => "41"           
                                ),
                                "message" => "photo"
                        );
                        return $this->doPost('/posts/', json_encode($payload));
                }

                function postComment($ancestor, $text, $country = "DE") {
                        $payload = array(
                                "ancestor" => $ancestor,
                                "color" => $this->colors[$this->getColor()],
                                "location" => array(
                                        "loc_accuracy" => 10.0,
                                        "city" => $this->city,
                                        "loc_coordinates" => array(
                                                "lat" => $this->lat,
                                                "lng" => $this->lng
                                        ),
                                        "country" => $country,
                                        "name" => "41"           
                                ),
                                "message" => $text
                        );
                        return $this->doPost('/posts/', json_encode($payload));
                }

                function deletePost($postid) {
                        return $this->doDelete('/posts/'.$postid.'/');
                }

                function upVote( $postId ) {
                        return $this->doPut("/posts/".$postId."/upvote/");
                }

                function downVote( $postId ) {
                        return $this->doPut("/posts/".$postId."/downvote/");
                }
				
                // Helper Functions
                function doPost($url, $payload) {
                	$header = $this->getSignHeaders($this->apiUrl.$url,'POST',$payload );
                	$response = Requests::post( $this->apiUrl.$url, $header, $payload );
                        return json_decode($response->body);
                }

                function doGet($url) {
                    if($this->iSkip > 0) $ext = '?skip='.$this->iSkip; else $ext = '';
                	$header = $this->getSignHeaders($this->apiUrl.$url,'GET' );
                	$response = Requests::get($this->apiUrl.$url.$ext, $header);
                        return json_decode($response->body);
                }

                function doPut($url, $payload = "") {
                        $header = $this->getSignHeaders($this->apiUrl.$url,'PUT',$payload );
                        $response = Requests::put($this->apiUrl.$url, $header, $payload);
                        return json_decode($response->body);
                }

                function doDelete($url) {
                        $header = $this->getSignHeaders($this->apiUrl.$url,'DELETE' );
                        $response = Requests::delete($this->apiUrl.$url, $header);
                        return json_decode($response->body);
                }
	}

?>
