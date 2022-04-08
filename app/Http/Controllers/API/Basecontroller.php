<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Basecontroller extends Controller
{
    /*
    Success Reponse Method
    */
    public function sendResponse($result,$message){
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /*
        Error Response Method
    */
    public function sendError($error,$errorMessages=[],$code=404){
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data']=$errorMessages;
        }
        return response()->json($response, $code);
    }
}
