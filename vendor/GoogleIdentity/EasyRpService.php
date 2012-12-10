<?php
namespace vendor\GoogleIdentity;
require_once('vendor/GoogleIdentity/Exception_JSON.php');
use vendor\GoogleIdentity\Exception_JSON;
require_once('vendor/GoogleIdentity/Conf.php');
use vendor\GoogleIdentity\Conf;

class EasyRpService {
	
	const LAXIST = True;
	const PROXY = 'http://127.0.0.1:8080';
	public static function getCurrentUrl() {
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://'
				: 'http://';
		$url .= $_SERVER['SERVER_NAME'];
		if ($_SERVER['SERVER_PORT'] != '80') {
			$url .= ':' . $_SERVER['SERVER_PORT'];
		}
		$url .= $_SERVER['REQUEST_URI'];
		return $url;
	}

	private static function getServerUrl() {
		$url = 'https://www.googleapis.com/rpc?key='
				. GoogleIdentity_Conf::get('developerKey');
		error_log("url: $url");
		return $url;
	}

	private static function post($postData) {
		$url = self::getServerUrl();
		$ch = curl_init();
		if (self::LAXIST) {
			error_log(
					'!!!WARNING!!! Laxist SSL parameters .... buh! !!!WARNING!!!');
			//WARNING: this would prevent curl from detecting a 'man in the middle' attack
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		if (self::PROXY) {
			curl_setopt($ch, CURLOPT_PROXY, self::PROXY);
		}
		curl_setopt_array($ch,
				array(CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_HTTPHEADER => array(
								'Content-Type: application/json'),
						CURLOPT_POSTFIELDS => json_encode($postData)));
		error_log('server_url: ' . $url);

		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($http_code != '200') {
			error_log("$http_code $response");
			echo 'Curl error: ' . curl_error($ch);
			#TODO: Handle exception
			curl_close($ch);
			throw new Exception_JSON('gitk_post_error', $http_code,
					array("code" => 200, "http_response" => $response));
		}
		curl_close($ch);
		if ($http_code == '200' && !empty($response)) {
			return json_decode($response, true);
		}
		return NULL;
	}

	public static function verify($continueUri, $response) {
		$request = array();
		$request['method'] = 'identitytoolkit.relyingparty.verifyAssertion';
		$request['apiVersion'] = 'v1';
		$request['params'] = array();
		$request['params']['requestUri'] = $continueUri;
		$request['params']['postBody'] = $response;
		$request['params']['returnOauthToken'] = True;
		//$request['params']['client_id'] = '933111977942-ihta47n2lhn5qf55lu48dn27i5ruqsst.apps.googleusercontent.com';

		try {
			$result = EasyRpService::post($request);
		} catch (Exception $e) {
			throw new Exception_JSON('erp_cannot_post_verify');
		}
		if (!empty($result['result'])) {
			return $result['result'];
		}
		return NULL;
	}
}
