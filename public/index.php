<?php
session_start();
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/Event.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

use App\Controllers\EventController;

$controller = new EventController();
$action = $_GET['action'] ?? 'index';

if ($action === 'store') {
    $controller->store();
} else {
    $controller->index();
}