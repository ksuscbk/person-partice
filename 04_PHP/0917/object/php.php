<?php

	class Person1 {
		public $eye = 2;
		protected $arm = 2;
		private $leg = 2;
	}

	class Chinese extends Person1 {
		public function sayHi () {
			echo $this->name;
		}
	}
	$c = new Chinese();
	echo $c->eye;

	// class Parent1 {
	// 	public $name = '小明';
	// }

	// class Child extends Parent1 {
	// 	public function sayHi () {
	// 		echo $this->name;
	// 	}
	// }
	// $c = new Child();
	// echo $c->sayHi();