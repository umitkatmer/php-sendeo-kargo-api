# php-sendeo-kargo-api
Php Sendeo Kargo api
- Tam olarak bitmiş değildir, fırsat buldukça gerisini yazacağım.

<h3 id="isleyis">https://api.sendeo.com.tr/api/Token/Login bu adrese istek atıp token aldık.</h3>

```php
<?php

include("index.php");

$sendeo = new Sendeo("","");
$sendeo->getToken();

?>
```
