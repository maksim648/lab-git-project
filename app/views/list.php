<?php include 'header.php'; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-600 rounded-xl text-sm">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-xl text-sm">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 lg:col-span-1 h-fit">
        <h2 class="text-xl font-bold text-slate-900 mb-4">Створити подію</h2>
        <form action="index.php?action=store" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Назва *</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Опис</label>
                <textarea name="description" rows="2" class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Дата *</label>
                <input type="date" name="event_date" required class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Тип *</label>
                <select name="event_type" class="w-full px-4 py-2 border rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="Конференція">Конференція</option>
                    <option value="Вебінар">Вебінар</option>
                    <option value="Майстер-клас">Майстер-клас</option>
                    <option value="Зустріч">Зустріч</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ціна (грн) *</label>
                <input type="number" step="0.01" name="price" required class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-2.5 rounded-xl hover:bg-indigo-700 transition">Зберегти</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 lg:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-900">Список подій</h2>
            <div class="flex space-x-2 text-xs">
                <a href="index.php?sort=event_date" class="px-3 py-1.5 rounded-lg border <?= ($sort ?? '') === 'event_date' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-slate-50' ?>">Датою</a>
                <a href="index.php?sort=title" class="px-3 py-1.5 rounded-lg border <?= ($sort ?? '') === 'title' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-slate-50' ?>">Назвою</a>
                <a href="index.php?sort=price" class="px-3 py-1.5 rounded-lg border <?= ($sort ?? '') === 'price' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-slate-50' ?>">Ціною</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b">
                        <th class="p-3">ID</th>
                        <th class="p-3">Назва</th>
                        <th class="p-3">Тип</th>
                        <th class="p-3">Дата</th>
                        <th class="p-3">Ціна</th>
                        <th class="p-3 text-right">Дії</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $row): ?>
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 text-slate-500"><?= $row['id'] ?></td>
                                <td class="p-3 font-medium text-slate-900"><?= $row['title'] ?></td>
                                <td class="p-3"><span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs"><?= $row['event_type'] ?></span></td>
                                <td class="p-3 text-slate-600"><?= $row['event_date'] ?></td>
                                <td class="p-3 font-semibold text-emerald-600"><?= number_format($row['price'], 2) ?> грн</td>
                                <td class="p-3 text-right space-x-2">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="text-indigo-600 hover:underline text-xs font-semibold">Редагувати</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Видалити подію?');" class="text-rose-600 hover:underline text-xs font-semibold">Видалити</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="p-6 text-center text-slate-400">Подій немає.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>