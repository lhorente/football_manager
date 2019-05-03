<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomersSignature extends Model
{
    public $timestamps = false;
	protected $table = 'customers_signatures';
	
	public static function checkExists($signature){
		$count = CustomersSignature::where(['customer_signature' => $signature])->count();
		return $count;
	}
	
	private static function accessTokenExists($customer_access_token){
		$count = CustomersSignature::where('customer_access_token',$customer_access_token)->count();
		return $count;
	}
	
	public static function generateUniqAccessToken($customer_id,$customer_signature){
		$customer_access_token = bin2hex(openssl_random_pseudo_bytes(16));
		
		while(CustomersSignature::accessTokenExists($customer_access_token)){
			$customer_access_token = CustomersSignature::generateUniqAccessToken($customer_id);
			return false;
		}
		
		$customer_access_token_time = 12; // In Hours
		
		$now = new \DateTime();
		$now->add(new \DateInterval('PT'.$customer_access_token_time.'H'));
		$customer_access_token_expire_at = $now->getTimestamp();
		
		$customersSignature = new CustomersSignature;
		$customersSignature->customer_id = $customer_id;
		$customersSignature->customer_signature = $customer_signature;
		$customersSignature->customer_access_token = $customer_access_token;
		$customersSignature->customer_access_token_expire_at = $customer_access_token_expire_at;
		$customersSignature->created = date("Y-m-d H:i:s");
		$customersSignature->save();
		
		$ret = [
			'id' => $customer_id,
			'customer_access_token' => $customer_access_token,
			'customer_access_token_expire_at' => $customer_access_token_expire_at
		];
		return $ret;
	}
}
