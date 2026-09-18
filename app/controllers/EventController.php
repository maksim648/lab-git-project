<?php
namespace App\Controllers;

use App\Models\Event;

class EventController {
    private Event $eventModel;

    public function __construct() {
        $this->eventModel = new Event();
    }

    public function index(): void {
        $sort = $_GET['sort'] ?? 'event_date';
        $events = $this->eventModel->getAll($sort);
        include __DIR__ . '/../views/list.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $event_date = trim($_POST['event_date'] ?? '');
            $event_type = trim($_POST['event_type'] ?? '');
            $price = trim($_POST['price'] ?? '');

            if (empty($title) || empty($event_date) || empty($event_type) || $price === '') {
                $_SESSION['error'] = "Заповніть усі обов'язкові поля!";
            } elseif (!is_numeric($price) || $price < 0) {
                $_SESSION['error'] = "Ціна має бути додатним числом!";
            } else {
                $this->eventModel->create([
                    'title' => htmlspecialchars($title),
                    'description' => htmlspecialchars($description),
                    'event_date' => $event_date,
                    'event_type' => htmlspecialchars($event_type),
                    'price' => $price
                ]);
                $_SESSION['success'] = "Подію успішно створено!";
            }
            header('Location: index.php');
            exit;
        }
    }

    public function edit(int $id): void {
        $event = $this->eventModel->getById($id);
        if (!$event) {
            header('Location: index.php');
            exit;
        }
        include __DIR__ . '/../views/edit.php';
    }

    public function update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $event_date = trim($_POST['event_date'] ?? '');
            $event_type = trim($_POST['event_type'] ?? '');
            $price = trim($_POST['price'] ?? '');

            if (!empty($title) && !empty($event_date)) {
                $this->eventModel->update($id, [
                    'title' => htmlspecialchars($title),
                    'description' => htmlspecialchars($description),
                    'event_date' => $event_date,
                    'event_type' => htmlspecialchars($event_type),
                    'price' => $price
                ]);
                $_SESSION['success'] = "Подію успішно оновлено!";
            }
            header('Location: index.php');
            exit;
        }
    }

    public function destroy(int $id): void {
        $this->eventModel->delete($id);
        $_SESSION['success'] = "Подію видалено!";
        header('Location: index.php');
        exit;
    }
}