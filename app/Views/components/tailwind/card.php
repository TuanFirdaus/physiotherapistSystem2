<div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
    <?php if (!empty($title)): ?>
        <h2 class="text-2xl font-bold text-gray-900 mb-4"><?= esc($title) ?></h2>
    <?php endif; ?>

    <div class="text-gray-700">
        <?= $content ?? '' ?>
    </div>
</div>