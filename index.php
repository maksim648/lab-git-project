<?php
// Підключення бази даних та модульних компонентів
require_once 'db.php';

$successMessage = "";
$errorMessage = "";

// Обробка POST-запиту (додавання події)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $event_date = trim($_POST['event_date'] ?? '');
    $event_type = trim($_POST['event_type'] ?? '');
    $price = trim($_POST['price'] ?? '');

    // Валідація даних
    if (empty($title) || empty($event_date) || empty($event_type) || $price === '') {
        $errorMessage = "Будь ласка, заповніть усі обов'язкові поля!";
    } elseif (!is_numeric($price) || $price < 0) {
        $errorMessage = "Ціна повинна бути додатним числом!";
    } else {
        // Захист від XSS
        $titleSafe = htmlspecialchars($title);
        $descriptionSafe = htmlspecialchars($description);
        $typeSafe = htmlspecialchars($event_type);

        // Використання Prepared Statements для захисту від SQL-ін'єкцій
        $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, event_type, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssd", $titleSafe, $descriptionSafe, $event_date, $typeSafe, $price);

        if ($stmt->execute()) {
            $successMessage = "Подію успішно додано до бази даних!";
        } else {
            $errorMessage = "Поשлка при збереженні: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Отримання параметру сортування через $_GET (за замовчуванням за датою)
$sort = $_GET['sort'] ?? 'event_date';
$allowedSorts = ['event_date', 'title', 'price'];
if (!in_array($sort, $allowedSorts)) {
    $sort = 'event_date';
}

// Отримання списку подій з бази
$result = $conn->query("SELECT * FROM events ORDER BY $sort ASC");
?>

<?php include 'header.php'; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- ФОРМА ДОДАВАННЯ ПОДІЇ -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 lg:col-span-1 h-fit">
        <h2 class="text-xl font-bold text-slate-900 mb-4">Створити нову подію</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-600 text-sm rounded-xl">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm rounded-xl">
                <?= $successMessage ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Назва події *</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Опис</label>
                <textarea name="description" rows="2" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Дата проведення *</label>
                <input type="date" name="event_date" required class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Тип події *</label>
                <select name="event_type" class="w-full px-4 py-2 border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="Конференція">Конференція</option>
                    <option value="Вебінар">Вебінар</option>
                    <option value="Майстер-клас">Майстер-клас</option>
                    <option value="Зустріч">Зустріч</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ціна квитка (грн) *</label>
                <input type="number" step="0.01" name="price" required class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-2.5 rounded-xl hover:bg-indigo-700 transition shadow-md">
                Зберегти подію
            </button>
        </form>
    </div>

    <!-- ТАБЛИЦЯ ВИВЕДЕННЯ ДАНИХ З БАЗИ -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 lg:col-span-2">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-slate-900">Список подій у базі</h2>
            
            <!-- Кнопки сортування через $_GET -->
            <div class="flex items-center space-x-2 text-xs">
                <span class="text-slate-500 font-medium">Сортувати за:</span>
                <a href="index.php?sort=event_date" class="px-3 py-1.5 rounded-lg border <?= $sort === 'event_date' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' ?>">Датою</a>
                <a href="index.php?sort=title" class="px-3 py-1.5 rounded-lg border <?= $sort === 'title' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' ?>">Назвою</a>
                <a href="index.php?sort=price" class="px-3 py-1.5 rounded-lg border <?= $sort === 'price' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100' ?>">Ціною</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                        <th class="p-3 font-semibold">ID</th>
                        <th class="p-3 font-semibold">Назва</th>
                        <th class="p-3 font-semibold">Тип</th>
                        <th class="p-3 font-semibold">Дата</th>
                        <th class="p-3 font-semibold">Ціна</th>
                        <th class="p-3 font-semibold">Додано</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-3 text-slate-500"><?= $row['id'] ?></td>
                                <td class="p-3 font-medium text-slate-900"><?= $row['title'] ?></td>
                                <td class="p-3"><span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-semibold"><?= $row['event_type'] ?></span></td>
                                <td class="p-3 text-slate-600"><?= $row['event_date'] ?></td>
                                <td class="p-3 font-semibold text-emerald-600"><?= number_format($row['price'], 2) ?> грн</td>
                                <td class="p-3 text-xs text-slate-400"><?= $row['created_at'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-400">Подій поки немає в базі даних.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>