<?php

class Database
{
  public function connection()
  {
    return new PDO("mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8", USERNAME, PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
  }
}
