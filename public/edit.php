<?php
session_start();
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/models/Event.php';
require_once __DIR__ . '/../app/controllers/EventController.php';

use App\Controllers\EventController;

$controller = new EventController();
$id = (int)($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->update($id);
} else {
    $controller->edit($id);
}