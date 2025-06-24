<?= $this->extend('layout/therapistTemp') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3 class="mb-4">My Patients & Appointments</h3>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Treatment Outcome</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($appointments)): ?>
                        <?php foreach ($appointments as $i => $app): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($app['patient_name']) ?></td>
                                <td><?= esc($app['email']) ?></td>
                                <td><?= esc($app['phoneNo']) ?></td>
                                <td><?= esc($app['appointment_date'] ?? '-') ?></td>
                                <td><?= esc($app['status']) ?></td>
                                <td>
                                    <?php
                                    $db = \Config\Database::connect();
                                    $record = $db->table('patienttreatmentrecord')
                                        ->where('appointmentId', $app['appointmentId'])
                                        ->where('therapistId', session()->get('therapistId'))
                                        ->get()
                                        ->getRowArray();
                                    echo $record ? esc($record['treatmentNotes']) : '<span class="text-muted">Not added</span>';
                                    ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm view-record-btn"
                                        data-appointment-id="<?= $app['appointmentId'] ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#treatmentModal">
                                        View Record
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No appointments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- Modal -->
            <div class="modal fade" id="treatmentModal" tabindex="-1" aria-labelledby="treatmentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="treatmentModalLabel">Treatment Record</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="treatmentRecordContent">
                            <!-- Treatment record content will load here -->
                            <div class="text-center text-muted">Loading...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.view-record-btn').forEach(button => {
            button.addEventListener('click', function() {
                const appointmentId = this.getAttribute('data-appointment-id');
                const contentDiv = document.getElementById('treatmentRecordContent');

                contentDiv.innerHTML = '<div class="text-center text-muted">Loading...</div>';

                fetch(`<?= base_url('therapist/getTreatmentRecord/') ?>${appointmentId}`)
                    .then(response => response.text())
                    .then(html => {
                        contentDiv.innerHTML = html;
                    })
                    .catch(error => {
                        contentDiv.innerHTML = '<div class="text-danger">Failed to load treatment record.</div>';
                    });
            });
        });
    });
</script>

<?= $this->endSection() ?>