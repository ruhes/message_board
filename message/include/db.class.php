<?php


    class DB {


        static function getDB(){
            $mysql = new mysqli('localhost','root','zzh970721','message');
            return $mysql;
        }

        static function unDB(&$mysql,&$result=null){
            $mysql->close();
            $mysql=null;
            if($result!=null){
                $result->free();
                $result=null;
            }
        }
    }