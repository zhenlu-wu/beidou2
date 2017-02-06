<?php

namespace App\Http\Controllers\Admin;

require_once 'resources/org/code/Code.class.php';

use App\Http\Model\Device;
use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LoginController extends CommonController
{
    public function index()
    {
        return view('admin.index');

    }
    public function login()
    {
        //是否为post
        if ($input = Input::all()){
             //验证码、用户名、密码是否正确
            if (strtoupper($input['code'])!= $this->getcode())
            {
                return back()->with('msg','验证码错误');
            }
            //获取user表的第一条记录
            $user = User::first();
            //判断是否一致
            if ($user->user_name != $input['username'] || Crypt::decrypt($user->user_passwd) != $input['password']){
                return back()->with('msg','用户名不存在或者密码输入错误');
            }

            session(['user'=>$user]);
            return redirect('admin/index');

        }
        else{
            session(['user' => null]);

            return view('admin.login');
        }

    }
    //生成验证码，并打印
    public function code()
    {
        $code = new \Code();
        return $code->make();
    }

    public function getcode()
    {
        $code = new \Code();
        return $code->get();
    }
    //测试加密解密
    public function crypt()
    {
        $str = '123456';
        echo $str2 = Crypt::encrypt($str);
        echo "</br>";
        echo Crypt::decrypt($str2);

    }

    //退出后台首页
    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    //修改管理员密码
    public function pass()
    {
        if ($input = Input::all())
        {
            //创建规则
            $rules = [
                'password'=> 'required|between:6,20|confirmed',

            ];
            $message = [
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须在6-20位之间',
                'password.confirmed'=>'新密码和确认密码不一致',

            ];
            //生成规则
            $validator = Validator::make($input,$rules,$message);
            //验证规则
            if ($validator->passes()){
                $user = User::first();
                if ($input['password_o'] == Crypt::decrypt($user->user_passwd))
                {
                    $user->user_passwd = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','密码修改成功！');
                }
                else{
                    return back()->with('errors','原密码不匹配！');
                }
            }
            else{
                return back()->withErrors($validator);
//                dd($validator->errors()->all());
            }

        }
        return view('admin.pass');
    }
}


