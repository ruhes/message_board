<?php

    class Replace {


        private $_str;
        //接收将要替换的文件
        public function __construct($str) {
            $this->_str = $str;
        }

        //替换普通变量
        private function _repVar() {
            $rule = '/\{\$([\w]+)\}/';
            if(preg_match($rule,$this->_str)){
                $this->_str = preg_replace($rule,"<?php echo \$this->_arr['$1'] ?>",$this->_str);
            }
        }

        //替换foreach
        private function _repForeach(){
            $ruleStart = '/\{foreach\s+\$([\w]+)\(([\w]+),([\w]+)\)\}/';
            $ruleEnd = '/\{\/foreach\}/';
            $rule = '/\{\@([\w]+)([\w\-\>]+)\}/';
            if(preg_match_all($ruleStart,$this->_str)){
                if(preg_match_all($ruleEnd,$this->_str)){
                    $this->_str = preg_replace($ruleStart,"<?php foreach (\$this->_arr['$1'] as \$key => \$value) { ?>",$this->_str);
                    $this->_str = preg_replace($ruleEnd,'<?php } ?>',$this->_str);
                    if(preg_match_all($rule,$this->_str)){
                        $this->_str = preg_replace($rule,'<?php echo htmlspecialchars($$1$2) ?>',$this->_str);
                    }
                } else {
                    exit('foreach没有结尾');
                }
            }
        }

        //替换if
        private function _repIf(){
            $ruleStart = '/\{if\s+\(\$([\w]+)\)\}/';
            $ruleEnd = '/\{\/if\}/';
            $ruleElse = '/\{else\}/';
            if(preg_match_all($ruleStart,$this->_str)){
                if(preg_match_all($ruleEnd,$this->_str)){
                    $this->_str = preg_replace($ruleStart,'<?php if ($this->_arr[\'$1\']) { ?>',$this->_str);
                    $this->_str = preg_replace($ruleEnd,'<?php } ?>',$this->_str);
                    if(preg_match_all($ruleElse,$this->_str)){
                        $this->_str = preg_replace($ruleElse,'<?php } else { ?>',$this->_str);
                    }
                } else {
                    exit('if语句没有结尾');
                }
            }
        }

        //替换include
        private function _repInclude(){
            $rule = '/\{include\s+file=\"([\w\.\_]+)\"\}/';
            if(preg_match_all($rule,$this->_str)){
                $this->_str = preg_replace($rule,'<?php $this->_read(\'$1\'); ?>',$this->_str);
//                if(!file_exists($file[1][0])){
//                    exit('include文件不存在');
//                }
/*                $this->_str = preg_replace($rule,'<?php include "$1" ?>',$this->_str);*/
            }
        }

        public function _create($fileName) {
            $this->_repVar();
            $this->_repIf();
            $this->_repInclude();
            $this->_repForeach();
            file_put_contents($fileName,$this->_str);
        }
    }