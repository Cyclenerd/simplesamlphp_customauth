<?php

class sspmod_velohero_Auth_Source_VeloHero extends sspmod_core_Auth_UserPassBase {
	protected function login($username, $password) {
		$curl = curl_init();
		
		// Set some curl options
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://app.velohero.com/sso',
			CURLOPT_USERAGENT => 'simpleSAMLphp Velo Hero Plugin',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				'view' => 'json',
				'user' => $username,
				'pass' => $password
			)
		));
		
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		
		// Check response
		if(!curl_errno($curl)) {
			$info = curl_getinfo($curl);
			// HTTP Status Code == 200
			if (isset($info['http_code']) && $info['http_code'] == '200') {
				$json = json_decode($resp, true);
				if (isset($json['user-id'])) {
					return array(
						'uid' => array($json['user-id']),
						'displayName' => array($json['user-nick']),
						'eduPersonAffiliation' => array('cyclist'),
					);
				} else {
					SimpleSAML_Logger::warning('Velo Hero: No user-id found');
					throw new SimpleSAML_Error_Error('WRONGUSERPASS');
				}
			} else {
				SimpleSAML_Logger::warning('Velo Hero: Wrong user or password');
				throw new SimpleSAML_Error_Error('WRONGUSERPASS');
			}
		} else {
			SimpleSAML_Logger::warning('Velo Hero: curl error');
			throw new Exception('Failed to connect to Velo Hero server!');
		}
		
		// Close request to clear up some resources
		curl_close($curl);
	}
}