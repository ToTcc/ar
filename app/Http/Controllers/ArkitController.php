<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arkit;
use App\Object;
use Illuminate\Support\Facades\Log;

class ArkitController extends Controller
{
    //

    public function createTarget(Request $request) {

        Log::debug('test debug');

        if (!$request->hasFile('file') || !$request->isMethod('POST'))
            return response()->json([
                'file' => [],
                'msg' => ['type' => 'err', 'content' => '没有获取到上传的文件'],
            ]);


        $target = new Arkit();

        $arr = [];

        $file = $request->file('file');

//        dd($file);
        $origin_name = $file->getClientOriginalName();  // 原始文件的全名
        $type = $file->getClientOriginalExtension();   // 原始文件的扩展名
        $size = $file->getClientSize();   // 原始文件大小(b)

        $saved_name = date('YmdHis') . str_random(4) . '.' . $type;

        $arr['origin_name'] = $origin_name;
        $arr['type'] = $type;
        $arr['size'] = $size;
        $arr['saved_name'] = $saved_name;

        $file->move(storage_path('app/public/'), $saved_name);

//        $target->name = $request->name;
        $target->name = 'target' . str_random(4);
        $target->url = $saved_name;
        $target->save();
        return response()->json([
            'file' => $arr,
            'msg' => ['type' => 'ok', 'content' => '上传文件成功'],
        ]);
    }

    public function targetList() {

        Log::debug('test debug');

        $imageList = Arkit::all();

//        dd($imageList);

        return $imageList;
    }

    public function getImage(Request $request) {

        $url = $request->url;

        $path = storage_path().'/app/public/'.$url;

        if(!file_exists($path)){
            //报404错误
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit;
        };

        header('Content-type: image/jpg');
        echo file_get_contents($path);
        exit;
    }

    public function objPosition(Request $request) {

        if ($request->isMethod('get')){
            $position = Object::all();

            return response($position);
        }
        else if ($request->isMethod('post')){
            $position = new Object();
            $position->x = $request->x;
            $position->y = $request->y;
            $position->z = $request->z;

            if($position->save()) {
                return response('success');
            };
        }
    }

    public function clear() {

        Schema::drop('target_image');
        Schema::drop('object_position');

    }

}
