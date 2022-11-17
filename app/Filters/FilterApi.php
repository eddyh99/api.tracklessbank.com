<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Exception;

class FilterApi implements FilterInterface
{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments=null){
        $header=$request->getServer('HTTP_AUTHORIZATION');
        try{
            helper('preapi');
            $token=getToken($header);
            validateKey($token);
            return $request;            
        } catch(Exception $e){
            return \Config\Services::response()->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
        return $header;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments=null){

    }
}