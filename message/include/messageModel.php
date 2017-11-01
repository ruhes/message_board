<?php

    //数据模型类
    class MessageModel {

        private $name;
        private $email;
        private $color;
        private $cont;
        private $limit;

        function __set($name, $value) {
            $this->$name = $value;
        }

        function __get($name){
            return $this->$name;
        }

        function add(){
            $mysql = DB::getDB();
            $sql = "INSERT INTO message (name,email,color,cont,date)
VALUE ('$this->name','$this->email','$this->color','$this->cont',NOW())";
            $mysql->query($sql);
            $affect = $mysql->affected_rows;
            DB::unDB($mysql);
            return $affect;
        }

        function get(){
            $mysql = DB::getDB();
            $sql = "SELECT * FROM message ORDER BY id DESC $this->limit ";
            $result = $mysql->query($sql);
            while ($data = $result->fetch_object()) {
                $object[] = $data;
            }
            DB::unDB($mysql,$result);
            return $object;
        }

        function getCount(){
            $mysql = DB::getDB();
            $sql = "SELECT id FROM message";
            $result = $mysql->query($sql);
            $count = $result->num_rows;
            DB::unDB($mysql,$result);
            return $count;
        }
    }