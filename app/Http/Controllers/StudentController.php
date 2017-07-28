<?php
/**
 * Created by PhpStorm.
 * User: 18710
 * Date: 2017/7/27
 * Time: 17:36
 */
namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller {

    /**
     * 文件上传
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload(Request $request) {

        if ($request -> isMethod('POST')) {
//            var_dump($_FILES);
            $file = $request->file('source');
//            dd($file);

            if ($file->isValid()) {
                // 源文件名
                $originalName = $file->getClientOriginalName();
                // 扩展名
                $ext = $file->getClientOriginalExtension();
                // MimeType
                $type = $file->getClientMimeType();
                // 临时绝对路径
                $realPath = $file->getRealPath();

                // 文件名
                $fileName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;
                $bool = Storage::disk('uploads')->put($fileName, file_get_contents($realPath));
                var_dump($bool);
            }


        }

        return view('student.upload');
    }

    /**
     * 发送邮件
     */
    public function mail() {
        // 发送文本内容
//        Mail::raw('邮件内容', function ($message) {
//            $message->from('18710617839@163.com', 'zhengtaishuai');
//            $message->subject('邮件主题 测试');
//            $message->to('994303805@qq.com');
//        });

        // 发送html格式的内容
        Mail::send('student.mail', ['name'=>'sean'], function ($message) {
            $message->to('994303805@qq.com');
        });
    }

    /**
     * 存储cache
     */
    public function cache1() {
        // put()  缓存键值对和存在的时间为10min
//        Cache::put('key1', 'value1', 10);

        // add()  如果缓存不存在返回添加成功，如果存在返回失败
//        $bool = Cache::add('key2', 'value2', 10);
//        var_dump($bool);

        // forever()  永久存在
//        Cache::forever('key3', 'value3');

        // has() 判断是否存在某个缓存
//        if (Cache::has('key3')) {
//            var_dump(Cache::get('key3'));
//        } else {
//            echo 'No';
//        }

    }

    /**
     * 读取cache
     */
    public function cache2() {
        // get()
//        $val = Cache::get('key3');

        // pull()  拿到缓存数据并删除
//        $val = Cache::pull('key3');
//        var_dump($val);

        // forget()  删除某个缓存
        $val = Cache::forget('key2');
        var_dump($val);


    }

    public function error() {

//        $student = null;
//        if ($student == null) {
////            abort('503');
//            abort('500');
//        }

//        return view('student.error');

        Log::info('这是一个info级别的日志信息');
        Log::warning('这是一个warning级别的日志信息', ['name' => 'immooc', 'age' => 20]);
        Log::error('这是一个数组', ['name' => 'sean', 'age' => 18]);

    }

    public function queue() {
        $this->dispatch(new SendEmail('994303805@qq.com'));
    }

}