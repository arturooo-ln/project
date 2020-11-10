<?php
include('connect.php');
try {
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO categories (cat_title)
  VALUES ('Kids')";
  // use exec() because no results are returned
  $connect->exec($sql);
  echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$connect = null;
?>