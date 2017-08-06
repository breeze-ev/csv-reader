<?php 

namespace BreezeEV\CSV;

use Exception;

class Reader extends AbstractReader
{


    /**
     * file header for rule
     * @var
     */
    protected $headerRule;

    /**
     * file contents for rule
     * @var
     */
    protected $contentRule;

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
     * @param $headerRule
     * @param $contentRule
     * @return $this
     */
    public function setRule($headerRule, $contentRule){
        $this->headerRule = $headerRule;
        $this->contentRule = $contentRule;
        return $this;
    }

    /**
     * get file contents
     * @param $rule - if null, it will auto check contents
     * @return array
     */
    public function getContentData($rule = null){

        $this->headerRule = $rule;

        $originalData = $this->load();

        $header = $this->readSingleLine($originalData, $this->headerRule);
        $content = $this->readMultiLine($originalData, $this->contentRule);

        return ['header' => $header, 'content' => $content];
    }

    /**
     * get file name data
     */
    public function getFileNameData(){



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
                $d['header'] = $data;
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