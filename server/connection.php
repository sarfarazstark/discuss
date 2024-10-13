<?php
require './auth.php';
include './crud.php';
include './db.php';

$auth = new Auth($pdo);
$crud = new CRUD($pdo);

try {
    echo $crud->read('category');
} catch (\Throwable $th) {
    //throw $th;
}