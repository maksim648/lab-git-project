<?php include 'header.php'; ?>

<div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
    <h2 class="text-xl font-bold text-slate-900 mb-4">Редагувати подію</h2>
    <form action="edit.php?id=<?= $event['id'] ?>" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $event['id'] ?>">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Назва *</label>
            <input type="text" name="title" value="<?= $event['title'] ?>" required class="w-full px-4 py-2 border rounded-xl">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Опис</label>
            <textarea name="description" rows="2" class="w-full px-4 py-2 border rounded-xl"><?= $event['description'] ?></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Дата *</label>
            <input type="date" name="event_date" value="<?= $event['event_date'] ?>" required class="w-full px-4 py-2 border rounded-xl">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Тип *</label>
            <select name="event_type" class="w-full px-4 py-2 border rounded-xl bg-white">
                <option value="Конференція" <?= $event['event_type'] == 'Конференція' ? 'selected' : '' ?>>Конференція</option>
                <option value="Вебінар" <?= $event['event_type'] == 'Вебінар' ? 'selected' : '' ?>>Вебінар</option>
                <option value="Майстер-клас" <?= $event['event_type'] == 'Майстер-клас' ? 'selected' : '' ?>>Майстер-клас</option>
                <option value="Зустріч" <?= $event['event_type'] == 'Зустріч' ? 'selected' : '' ?>>Зустріч</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Ціна (грн) *</label>
            <input type="number" step="0.01" name="price" value="<?= $event['price'] ?>" required class="w-full px-4 py-2 border rounded-xl">
        </div>
        <div class="flex space-x-4">
            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-2.5 rounded-xl hover:bg-indigo-700 transition">Оновити</button>
            <a href="index.php" class="w-full text-center bg-slate-200 text-slate-700 font-semibold py-2.5 rounded-xl hover:bg-slate-300 transition">Скасувати</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>