<?php

class TestClass {
    public string $myVar = "Hello Art";

    public function testSumFunc($a, $b) {
        return $a+$b;
    }
}

$t = new TestClass();

echo $t->myVar.PHP_EOL;;

echo 'Hello, world!'.PHP_EOL;

$a = rand(1,1000);



if ($a < 10) {
    echo 'Менше 10'.PHP_EOL;
}
$string = 'hello'.PHP_EOL;

$r = $t->testSumFunc($a, 10);

print $r.PHP_EOL;;

