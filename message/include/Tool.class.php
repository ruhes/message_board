<?php


    class Tool {

        static function alertBack($info){
            exit("<script>alert('$info');history.back()</script>");
        }

        static function alertLocation($info,$url){
            exit("<script>alert('$info');location.href='$url';</script>");
        }
    }