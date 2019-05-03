<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Customer;

class CustomersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
	
	private function parseOauthHeader($header) {
		if ( substr( $header, 0, 6 ) !== 'OAuth ' ) {
			return false;
		}
		// From OAuth PHP library, used under MIT license
		$params = array();
		if ( preg_match_all( '/(oauth_[a-z_-]*)=(:?"([^"]*)"|([^,]*))/', $header, $matches ) ) {
			foreach ($matches[1] as $i => $h) {
				$params[$h] = urldecode( empty($matches[3][$i]) ? $matches[4][$i] : $matches[3][$i] );
			}
			if (isset($params['realm'])) {
				unset($params['realm']);
			}
		}
		return $params;
	}

    public function requestCustomerAccessToken(Request $request){
		$errors = [];

		$Authorization = $request->header('Authorization');
		if ($Authorization){
			$oauth_params = $this->parseOauthHeader($Authorization);
			if ($oauth_params){
				$oauth_consumer_key = isset($oauth_params['oauth_consumer_key']) ? $oauth_params['oauth_consumer_key'] : null;
				$oauth_nonce = isset($oauth_params['oauth_nonce']) ? $oauth_params['oauth_nonce'] : null;
				$oauth_signature = isset($oauth_params['oauth_signature']) ? $oauth_params['oauth_signature'] : null;
				
				if (!$oauth_consumer_key){
					$errors[] = 'oauth_consumer_key invalid or empty';
				}
				
				if (!$oauth_nonce){
					$errors[] = 'oauth_nonce invalid or empty';
				}
				
				if (!$oauth_signature){
					$errors[] = 'oauth_signature invalid or empty';
				}
				
				if (!$errors){
					try{
						$token = Customer::authenticateCustomer($oauth_consumer_key,$oauth_nonce,$oauth_signature);
						return \Response::json($token);
					} catch(\Exception $e){
						return \Response::json([
							'msg' => $e->getMessage()
						],401);
					}
				} else {
					return \Response::json([
						'msg' => implode(", ",$errors)
					],401);
				}
			}
		} else {
			return \Response::json([
				'msg' => "Authorization header invalid or empty"
			],401);
		}
	}
}
