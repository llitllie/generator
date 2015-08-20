# generator
a php code generator  for remote php service's client,arvg validate,defafult result and so on .<br/>
USEAGE : gen.php [option] service <br/>
optoin<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-i&nbsp;&nbsp;generate input validator<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-o&nbsp;&nbsp;generate output validator<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-c&nbsp;&nbsp;generate client file<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-d&nbsp;&nbsp;generate default result<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-t&nbsp;&nbsp;generate test case(phpunit)<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-f&nbsp;&nbsp;forece generate<br/>
eg. gen.php -f -a \\Cloud\\KSongMatch\\Prize\\Service<br/>
<br/>
It depends on <a href="http://php.net/manual/zh/book.reflection.php" target="_blank">PHP Reflection</a>.
