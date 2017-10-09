<?php

	// 通过类实现封装  
	// 继承
	class Parent1 {
		public $name = '焦';
		function sayHi () {
			echo '你好 ' . $this->name;
		}
	}
	class Child extends Parent1 {
		// public function sayHi () {
		// 	echo $this->name;
		// }
	}


	$c1 = new Child();
	echo $c1->sayhi();

	// 多态  第八行
	