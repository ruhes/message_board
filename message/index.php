<?php

    require 'init.inc.php';

    $message = new MessageAction($tpl);
    $message->show();
    $tpl->_read('index.html');