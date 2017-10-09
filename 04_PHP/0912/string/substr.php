<?php
	$str = 'hello,我 want a job for frontend';
	echo substr($str, 6);
	echo '<br>';
	echo substr($str, 6, 13);
	echo '<br>';
	echo mb_substr($str,6);
	echo '<br>';
	echo mb_substr($str, 6, 13);