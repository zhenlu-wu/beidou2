<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    //
    public function export()
    {
        $cellData = [
            ['id','区域','风速','雨量'],
            ['1','霞山','4','37'],
            ['2','开发区','5','80'],
            ['3','赤坎','6','100'],
        ];
        Excel::create(iconv('UTF-8','GBK','区域风速'),function($excel) use ($cellData){//定义文件名
            $excel->sheet('风速',function($sheet) use ($cellData){//定义表名
                $sheet->rows($cellData);//输出内容
            });
        })->store('xls')->export('xls');//存储并导出xls输出格式
    }

    //从服务器指定位置导入
    public function import()
    {
        $filePath = 'storage/exports/'.iconv('UTF-8','GBK','区域风速').'.xls';
        Excel::load($filePath, function($reader){
            $data = $reader->get();
            dd($data);
        });
    }
}
