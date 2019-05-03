<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CustomersSignature;

class Customer extends Model
{
    public $timestamps = false;
	protected $table = 'customers';
	
	public static function authenticateCustomer($customer_key,$nonce,$signature){
		$customer = Customer::where(['customer_key'=>$customer_key])->first();
		
		if ($customer){
			$customer_id = $customer->id;
			$customer_secret = $customer->customer_secret;
			$customer_signature = hash_hmac('sha256', $customer_key.$nonce, $customer_secret);
			if ($customer_signature == $signature){
				if (!CustomersSignature::checkExists($customer_signature)){
					$uniqToken = CustomersSignature::generateUniqAccessToken($customer_id,$customer_signature);
					if (!$uniqToken){
						throw new \Exception('Error on creating Customer Access Token');
					}
					return $uniqToken;
				} else {
					throw new \Exception('Expired Customer Credentials');
				}
			} else {
				throw new \Exception('Invalid Customer Credentials');
			}
		} else {
			throw new \Exception('Invalid Customer Credentials');
		}
	}
	
	public static function findCustomerByAccessToken($access_token){
		$now = time();
		
		$customer = Customer::join('customers_signatures', 'customers_signatures.customer_id', '=', 'customers.id')
								->where(['customers_signatures.customer_access_token'=>$access_token])
								->where('customers_signatures.customer_access_token_expire_at','>=',$now)
								->first();

		return $customer;
	}
}
