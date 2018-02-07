<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arkit;

class ArkitController extends Controller
{
    //

    public function createTarget(Request $request) {
        if (!$request->hasFile('file'))
            return response()->json([
                'file' => [],
                'msg' => ['type' => 'err', 'content' => '没有获取到上传的文件'],
            ]);

        $target = new Arkit();

        $arr = [];

        $file = $request->file('file');
        $origin_name = $file->getClientOriginalName();  // 原始文件的全名
        $type = $file->getClientOriginalExtension();   // 原始文件的扩展名
        $size = $file->getClientSize();   // 原始文件大小(b)

        $saved_name = date('YmdHis') . str_random(4) . '.' . $type;

        $arr['origin_name'] = $origin_name;
        $arr['type'] = $type;
        $arr['size'] = $size;
        $arr['saved_name'] = $saved_name;

        $file->move(public_path('storage/target_image'), $saved_name);

//        $target->name = $request->name;
        $target->name = 'target' . str_random(4);
        $target->url = $saved_name;

        return response()->json([
            'file' => $arr,
            'msg' => ['type' => 'ok', 'content' => '上传文件成功'],
        ]);
    }

    public function showImage() {


//        $realPath = "k7wwMpJduq.jpg";
        $path = storage_path().'/app/public/k7wwMpJduq.jpg';

//        dd($path);

//        dd(file_exists($path));
        if(!file_exists($path)){
            //报404错误
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit;
        }
        //输出图片
        header('Content-type: image/jpg');
        echo file_get_contents($path);
        exit;

    }

}
