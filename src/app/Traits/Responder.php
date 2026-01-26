<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait Responder{


    public function response(array $data) {

        if(request()->expectsJson()){
            if(Arr::has($data,'apiResponse')){
                return $data['apiResponse'];
            }else{
                return response()->json($data['data'],Arr::has($data,'response_code')?$data['response_code']:200);
            }

        }else{

            if(Arr::has($data,'redirectBack')&&$data['redirectBack']){
                return back()->with($data['data']);
            }else if(Arr::has($data,'redirectTo')){
                return redirect()->route($data['redirectTo']['route'],Arr::has($data['redirectTo'],'args')?$data['redirectTo']['args']:[])->with($data['data']);
            }else{
                return view($data['view'],$data['data']);
            }
        }
    }
}
