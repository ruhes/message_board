<?php

    require 'init.inc.php';

    $message = new MessageAction($tpl);
    $message->add();
    $tpl->_read('release.html');