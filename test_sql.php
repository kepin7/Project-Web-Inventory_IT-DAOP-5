<?php
$c = file_get_contents('inventory_daop5.sql');
preg_match('/INSERT INTO `categories`.*?;/s', $c, $m);
echo $m[0];
