<?php
if (getenv('MyHost')!=$_SERVER['HTTP_HOST']) {
  header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request');
  exit();
}
?>