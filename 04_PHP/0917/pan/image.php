<?php

	$path = iconv('utf-8', 'gbk', $_GET['path']);

	readfile($path);