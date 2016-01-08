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
		                   	  "User-Agent"            => "Jodel/65000 Dalvik/2.1.0 (Linux; U; Android 5.1.1; D6503 Build/23.4.A.1.232)"
		                        );
		

                private $colors = array('06A3CB', 'DD5F5F', '8ABDB0', 'FF9908', 'FFBA00', '9EC41C');
                private $udid = '';

                private $accessToken, $country, $city, $lat, $lng;


                function __construct( $udid = '', $position = array(50.1183, 8.7011, 'Frankfurt am Main', 'DE')) {
                        // SetUp
                        $this->setUdid($udid);
                        $this->setPos($position[0], $position[1], $position[2], $position[3]);
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
                	
                    $this->accessToken = $response->access_token;
                    $this->header['Authorization'] = 'Bearer '.$this->accessToken;
                }

               
                function getPosts() {
                	return $this->doGet("/posts/");
                }

                function getKarma() {
                        $response = $this->doGet("/users/karma/");
                        return $response->karma;
                }

                function getMyPosts() {
                        return $this->doGet("/posts/mine/");
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
                                "color" => $this->getColor(),
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
                        return $this->doPut("/posts/" . $postId . "/downvote/");
                }


                // Helper Functions
                function doPost($url, $payload) {
                	$response = Requests::post( $this->apiUrl.$url, $this->header, $payload );
                        return json_decode($response->body);
                }

                function doGet($url) {
                	$response = Requests::get($this->apiUrl.$url, $this->header);
                        return json_decode($response->body);
                }

                function doPut($url, $payload = "") {
                        $response = Requests::put($this->apiUrl.$url, $this->header, $payload);
                        return json_decode($response->body);
                }

                function doDelete($url) {
                        $response = Requests::delete($this->apiUrl.$url, $this->header);
                        return json_decode($response->body);
                }

	}

?>
