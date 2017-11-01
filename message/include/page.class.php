<?php


    class Page {
        private $count;         //总记录数
        private $pageSize = 6; //每页显示的个数
        private $pages;         //总页数
        private $page;          //当前的页

        //构造函数 需要传入共有多少条记录
        function  __construct($count){
            $this->count = $count;
            $this->pages = ceil($this->count/$this->pageSize);//得到总页数
            $_GET['page']<2 ? $this->page=1 : $this->page = $_GET['page'];
        }

        function getLimit(){
            if($this->page==1){
                $num = 0;
            } else {
                $num = ($this->page*$this->pageSize)-$this->pageSize;
            }
            return $limit = "LIMIT $num,$this->pageSize";
        }

        private function pageList(){
            $list = null;
            //如果当前页小于6
            if($this->page<=6){
                for($i=1;$i<=10;$i++){  //循环10个标签
                    if($i>$this->pages) continue;//如果i<小于总页数则跳出
                    if($i==$this->page){  //如果i等于当前页则加上class标签
                        $list .= "<a href='?page=$i' class='thisPage'>$i</a>";
                        continue;
                    }
                    $list .= "<a href='?page=$i'>$i</a>";
                }
                //如果当前页大于6 或者小于总标签-4 (因为总共要显示10个标签)
            } else if($this->page>6 && $this->page<($this->pages-4)){
                //显示前面的4页
                for($i=5;$i>=1;$i--){
                    $page = $this->page-$i;
                    if($page<1) continue;
                    $list .= "<a href='?page=$page'>$page</a>";
                }
                $list .= "<a href='?page=$this->page' class='thisPage'>$this->page</a>";
                //显示当前页后面的4页
                for($i=1;$i<5;$i++){
                    $page = $this->page+$i;
                    if($page>$this->pages) continue;
                    $list .= "<a href='?page=$page'>$page</a>";
                }
                //又如果当前页大于总标签-4
            } else if($this->page>=$this->pages-4){
                for($i=$this->pages-9;$i<=$this->pages;$i++){//从小到大循环10次 必须要小于或等于总标签否则如果当前是最后一页则不显示
                    if($i<1) continue;      //小于1的标签跳过
                    if($i==$this->page){    //为当前页加上class
                        $list .= "<a href='?page=$i' class='thisPage'>$i</a>";
                        continue;
                    }
                    $list .= "<a href='?page=$i'>$i</a>";
                }
            }
            return $list;
        }

        //首页
        private function first(){
            return "<a href='?page=1'>首页</a>";
        }

        //尾页
        private function last(){
            return "<a href='?page=$this->pages'>尾页</a>";
        }

        function showPage(){
            return "共 $this->pages 页　".
                $this->first().
                $this->pageList().
                $this->last();
        }
    }