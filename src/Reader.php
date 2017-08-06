<?php 

namespace BreezeEV\CSV;

use Exception;

class Reader extends AbstractReader
{


    /**
     * content rules
     * @var
     */
    protected $rules;


    /**
     * set file info
     * @param $fileName
     * @param $filePath
     * @throws Exception
     * @return $this
     */
    public function setFile($fileName, $filePath){

        if(!file_exists($filePath)){
            throw new Exception('the file not exist!');
        }

        $this->file['name'] = $fileName;
        $this->file['path'] = $filePath;
        return $this;
    }

    /**
     * define the rule of file
     * @param $rules
     * @return $this
     */
    public function setRules($rules){
        if(isset($rules['header'])){
            $this->rules['header'] = $rules['header'];
        }

        if(isset($rules['content'])){
            $this->rules['content'] = $rules['content'];
        }

        if(isset($rules['name'])){
            $this->rules['name'] = $rules['name'];
        }

        return $this;
    }

    /**
     * get file contents
     * @throws Exception
     * @return array
     */
    public function getContentData(){

        $originalData = $this->load();
        $header = [];
        $content = [];

        if($this->type === self::FIRST_LINE_TOTAL){
            if(isset($this->rules['header'])){
                $header = $this->readSingleLine($originalData['header'], $this->rules['header']);
            }else{
                throw new Exception('header rule not in rules');
            }
        }

        if(isset($this->rules['content'])){
            $content = $this->readMultiLine($originalData['content'], $this->rules['content']);
        }else{
            throw new Exception('content rule not in rules');
        }

        return ['header' => $header, 'content' => $content];
    }

    /**
     * get file name data
     * @param $separator
     * @throws Exception
     * @return array
     */
    public function getFileNameData($separator = '_'){

        if(isset($this->rules['name'])){
            $originalData = explode($separator, $this->file['name']);
            return $this->readSingleLine($originalData, $this->rules['name']);
        }else{
            throw new Exception('name rule not in rules');
        }

    }


    /**
     * file load
     */
    protected function load(){

        $file = $this->file['path'];

        $reader = fopen($file, 'r');

        $d = [
            'header' => [],
            'content' => [],
        ];

        $i = 0;
        while ($data = fgetcsv($reader)) {

            if ($i === 0) {
                if($this->type === self::FIRST_LINE_TOTAL || $this->type === self::FIRST_LINE_HEADER){
                    $d['header'] = $data;
                }else{
                    $d['content'][] = $data;
                }
            }

            if ($i > 0) {
                $d['content'][] = $data;
            }
            $i++;
        }

        fclose($reader);
        return $d;

    }

}