<?php
/**
 * Created by PhpStorm.
 * User: Breeze
 * Date: 2017/8/6
 * Time: 下午8:20
 */

namespace BreezeEV\CSV;

abstract class AbstractReader
{

    protected $file;
    protected $type;

    const type_with_head = 0;               // 带有文件头信息
    const type_with_total = 1;              // 带有文件汇总信息



    public function __construct($type)
    {
        $this->type = $type;
    }


    /**
     * 读取多行
     * @param $data
     * @param $format
     * @return array
     */
    protected function readMultiLine(array $data, $format){
        $d = [];
        foreach ($data as $key => $datum){
            $row = [];
            foreach ($datum as $k => $item){
                if(isset($format[$k])){
                    $row[$format[$k]] = $item;
                }
            }
            $d[$key] = $row;
        }
        return $d;
    }


    /**
     * 读取单行
     * @param array $data
     * @param $format
     * @return array
     */
    protected function readSingleLine(array $data, $format){
        $d = [];
        foreach ($data as $key => &$datum){
            if(isset($format[$key])){
                $d[$format[$key]] = $datum;
            }
        }
        return $d;
    }

}