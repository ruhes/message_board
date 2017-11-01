<?php

    //流程控制
    class MessageAction {

        private $tpl;
        private $model;

        //构造初始化
        function __construct(&$tpl){
            $this->tpl = $tpl;
            $this->model = new MessageModel();
        }

        function add(){
            if(isset($_POST['send'])){
                if(Validate::isNull($_POST['name'])) Tool::alertBack('昵称不能为空');
                if(Validate::isNull($_POST['text'])) Tool::alertBack('留言内容不能为空');

                //如果没有选择颜色则随机
                if(empty($_POST['color'])){
                    $colorArr = array('sandybrown','deepskyblue','greenyellow','salmon','blanchedalmond','white','springgreen','coral','palevioletred');
                    $this->model->color = $colorArr[mt_rand(0,8)];
                } else {
                    $this->model->color = $_POST['color'];
                }
                $this->model->name = $_POST['name'];
                $this->model->email = $_POST['email'];
                $this->model->cont = $_POST['text'];

                if($this->model->add()) Tool::alertLocation('留言成功','index.php');
            }
        }

        function show(){
            $page = new Page($this->model->getCount());
            $this->model->limit = $page->getLimit();
            if($this->model->get()){
                $this->tpl->_add('allMessage',$this->model->get());
            }
            $this->tpl->_add('page',$page->showPage());
        }
    }