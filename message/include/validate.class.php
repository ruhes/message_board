<?php


    class Validate {

        //是否为空
        static function isNull($date){
            return empty($date) ? true : false;
        }

        //是否小于
        static function isMin($date,$num){
            return $date < $num ? true : false;
        }

        //是否大于
        static function isMax($date,$num){
            return $date > $num ? true : false;
        }
    }