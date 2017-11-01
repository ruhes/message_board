<?php

    class Template {

        private $_arr = array();

        //构造函数接收模板文件
        public function __construct() {;

        }

        //注入变量的方法
        public function _add($key,$value) {
            foreach ($this->_arr as $_arrKey=>$_arrValue){
                if($_arrKey==$key){
                    exit('您所输入的key已经存在');
                }
            }
            $this->_arr[$key] = $value;
        }

        //读取模板文件的内容并且传给替换类
        public function _read($_tplFile) {
            //设置文件路径
            $_tplFile = TPL_DIR.$_tplFile;
            //生成编译文件名
            $_comFile = COMP_DIR.md5($_tplFile).substr(basename($_tplFile),0,-4).'.php';
            if(!file_exists($_tplFile)){
                echo $_tplFile;
                exit('ERROR:模板文件不存在');
            }
            //判断编译文件是否存在
            if(!file_exists($_comFile) || filemtime($_tplFile)>=filemtime($_comFile)){
                require_once 'replace.class.php';
                $_rep = new Replace(file_get_contents($_tplFile));
                $_rep->_create($_comFile);
            }
            include $_comFile;
        }
    }