<?php
    // 对象  在PHP中，创建对象要先创建类，根据类创建对象
    class Person {
        public $name = '小名';
        public $age = 18;

        public function sayHi () {
            echo '你好';
        }
    }
    $p1 = new person();
    echo $p1->name;
    echo $p1->sayHi();

    print_r($p1);