--TEST--
Test posix_dup2() function
--DESCRIPTION--
checks that we can duplicate a temporary file as stdout
--CREDITS--
Wez Furlong
--SKIPIF--
<?php
if (!extension_loaded('posix')) {
    die('SKIP The posix extension is not loaded.');
}
?>
--FILE--
<?php
// Equivalent to dup(STDOUT_FILENO)
$output = fopen('php://fd/1', 'w');
$temp = tmpfile();
// Equivalent to dup2($temp, STDOUT_FILENO)
$res = posix_dup2($temp, STDOUT);
// The output stream now lands in $temp
echo "This should appear in tmpfile\n";
// Equivalent to dup'ing the original stdout fd back to STDOUT
posix_dup2($output, STDOUT);
// Now the output buffer renders to the EXPECTF section below
var_dump($res);
echo "And now the contents of tmpfile\n";
fseek($temp, 0);
echo stream_get_contents($temp);
?>
===DONE===
--EXPECTF--
bool(true)
And now the contents of tmpfile
This should appear in tmpfile
===DONE===
