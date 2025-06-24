<div>
    <h5 class="mb-3">Treatment Notes</h5>
    <p><?= esc($record['treatmentNotes']) ?></p>

    <hr>

    <p><strong>Duration:</strong> <?= esc($record['duration'] ?? '-') ?> mins</p>
    <p><strong>Techniques Used:</strong> <?= esc($record['techniques'] ?? 'N/A') ?></p>
    <p><strong>Outcome:</strong> <?= esc($record['outcome'] ?? 'N/A') ?></p>
    <p><strong>Date Recorded:</strong> <?= esc($record['created_at'] ?? '-') ?></p>
</div>