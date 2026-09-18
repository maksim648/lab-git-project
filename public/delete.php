<?php
session_start();
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/Event.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

use App\Controllers\EventController;

$controller = new EventController();
$id = (int)($_GET['id'] ?? 0);
$controller->destroy($id);