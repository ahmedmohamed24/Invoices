<?php
namespace App\Http\Traits;

trait CustomResponse{
    public function customResponse($status,$msg,$data=null){
        return response()->json([
            'status'=>$status,
            'msg'=>$msg,
            'data'=>$data
        ]);
    }
}
