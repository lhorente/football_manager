<?php

namespace App\Http\Middleware;

use Closure;
use App\Customer;

class ApiCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
		$CustomerAccessToken = $request->header('Customer-Access-Token');
		if (!$CustomerAccessToken){
			return \Response::json([
				'msg' => 'Empty Customer-Access-Token'
			],401);
		}
		
		$customer = Customer::findCustomerByAccessToken($CustomerAccessToken);
		if (!$customer){
			return \Response::json([
				'msg' => 'Invalid Customer-Access-Token'
			],401);
		}
		
        return $next($request);
    }
}
