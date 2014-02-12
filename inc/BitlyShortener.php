<?php
if( !class_exists( 'BitlyShortener' ) ) {
class BitlyShortener {

	private $_token = 'your API token';
	private $_apiURL = 'https://api-ssl.bitly.com/v3/shorten?';
	
	public $url;
	
	public function __construct( $uri ) {
		$this->url = $uri;
	}
	
	private function _buildURL() {
		$requestURL = $this->_apiURL . 'access_token=' . $this->_token . '&longUrl=' . urlencode( $this->url ) . '&format=json';
		return $requestURL;
	}
	
	public function shorten() {
		$requestURI = $this->_buildURL();
		$ci = curl_init();
		
		curl_setopt( $ci, CURLOPT_USERAGENT, 'Bit.ly Client' );
		curl_setopt( $ci, CURLOPT_CONNECTTIMEOUT, 30 );
		curl_setopt( $ci, CURLOPT_TIMEOUT, 30 );
		curl_setopt( $ci, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ci, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ci, CURLOPT_HEADER, false );
		curl_setopt( $ci, CURLOPT_URL, $requestURI );
		$response = curl_exec( $ci );
		
		
		
		curl_close( $ci );
		
		$data = json_decode( $response, true );
		
		return $data['data']['url'];
	}

}
}