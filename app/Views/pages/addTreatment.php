<?= $this->extend('layout/adminTemplate') ?>
<?= $this->section('content') ?>

<?php $isEdit = isset($treatment); ?>

<div class="container mt-4">
    <h2><?= $isEdit ? 'Edit' : 'Add' ?> Treatment Record</h2>

    <form action="/treatment/save" method="post">
        <input type="hidden" name="record_id" value="<?= $isEdit ? esc($treatment['record_id']) : '' ?>">

        <!-- Patient ID -->
        <div class="mb-3">
            <label for="patient_id">Patient</label>
            <select name="patient_id" class="form-select" id="patient_id" required>
                <option value="">Select Patient</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?= $patient['id'] ?>"
                        <?= $isEdit && $treatment['patient_id'] == $patient['id'] ? 'selected' : '' ?>>
                        <?= $patient['id'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Loading indicator -->
        <div id="loadingIndicator" class="spinner-border text-primary d-none" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>

        <!-- Patient Name -->
        <div class="mb-3">
            <label for="patient_name">Patient Name</label>
            <input type="text" class="form-control" id="patient_name" readonly>
        </div>

        <!-- Treatment Prompt -->
        <div id="treatmentPrompt" class="alert alert-info d-none">
            This patient already has treatment records. Please review them before adding a new one.
        </div>

        <!-- Appointment ID -->
        <div class="mb-3">
            <label for="appointment_id">Appointment ID</label>
            <select name="appointment_id" class="form-select" id="appointment_id" required>
                <option value="">Select Appointment</option>
                <!-- Options will be populated dynamically -->
            </select>
        </div>

        <input type="hidden" name="therapist_id" id="therapist_id" value="<?= $isEdit ? esc($treatment['therapist_id']) : '' ?>">
        <input type="hidden" name="slot_id" id="slot_id" value="<?= $isEdit ? esc($treatment['slot_id']) : '' ?>">


        <!-- Treatment ID (read-only) -->
        <div class="mb-3">
            <label for="treatment_id">Treatment ID</label>
            <input type="text" name="treatment_id" class="form-control" id="treatment_id" readonly>
        </div>

        <!-- Session Date (read-only display) -->
        <div class="mb-3">
            <label for="session_date_display">Session Date</label>
            <input type="text" id="session_date_display" class="form-control" readonly>
        </div>

        <!-- Start Time (read-only display) -->
        <div class="mb-3">
            <label for="start_time_display">Start Time</label>
            <input type="text" id="start_time_display" class="form-control" readonly>
        </div>

        <!-- End Time (read-only display) -->
        <div class="mb-3">
            <label for="end_time_display">End Time</label>
            <input type="text" id="end_time_display" class="form-control" readonly>
        </div>

        <!-- Hidden actual value for form submission -->
        <input type="hidden" name="session_date" id="session_date">

        <!-- Status -->
        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-select" id="status" required>
                <option value="">Select Status</option>
                <option value="In Progress" <?= $isEdit && $treatment['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Completed" <?= $isEdit && $treatment['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                <option value="Missed" <?= $isEdit && $treatment['status'] === 'Missed' ? 'selected' : '' ?>>Missed</option>
            </select>
        </div>

        <!-- Treatment Notes -->
        <div class="mb-3">
            <label for="treatment_notes">Treatment Notes</label>
            <textarea name="treatment_notes" class="form-control" id="treatment_notes" rows="4" required><?= $isEdit ? esc($treatment['treatment_notes']) : '' ?></textarea>
        </div>

        <button type="submit" class="btn btn-success"><?= $isEdit ? 'Update' : 'Save' ?></button>
        <a href="/treatment" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.getElementById('patient_id').addEventListener('change', function() {
        const patientId = this.value;

        if (patientId) {
            document.getElementById('patient_name').value = 'Loading...';

            fetch(`/getPatientDetails/${patientId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('patient_name').value = data.patient.name;

                        const appointmentSelect = document.getElementById('appointment_id');
                        const treatmentInput = document.getElementById('treatment_id');
                        appointmentSelect.innerHTML = '<option value="">Select Appointment</option>';
                        treatmentInput.value = '';

                        // Populate appointments with treatmentId and treatmentName
                        if (data.appointments.length > 0) {
                            data.appointments.forEach((appointment) => {
                                const option = document.createElement('option');
                                option.value = appointment.appointmentId;
                                option.textContent = `${appointment.appointmentId}`;
                                option.dataset.treatmentId = appointment.treatmentId;
                                option.dataset.treatmentName = appointment.treatmentName;
                                option.dataset.therapistId = appointment.therapistId;
                                option.dataset.slotId = appointment.slotId;
                                option.dataset.sessionDate = appointment.session_date;
                                option.dataset.startTime = appointment.startTime;
                                option.dataset.endTime = appointment.endTime;
                                appointmentSelect.appendChild(option);
                            });
                        } else {
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'No appointments found';
                            appointmentSelect.appendChild(option);
                        }

                        // Show/hide treatment record warning
                        const treatmentPrompt = document.getElementById('treatmentPrompt');
                        if (data.hasTreatmentRecords) {
                            treatmentPrompt.classList.remove('d-none');
                        } else {
                            treatmentPrompt.classList.add('d-none');
                        }

                        // Update treatment, therapist, slot, and session info when appointment is selected
                        appointmentSelect.addEventListener('change', function() {
                            const selected = this.options[this.selectedIndex];

                            const treatmentId = selected.dataset.treatmentId || '';
                            const treatmentName = selected.dataset.treatmentName || '';
                            const therapistId = selected.dataset.therapistId || '';
                            const slotId = selected.dataset.slotId || '';
                            const sessionDate = selected.dataset.sessionDate || '';
                            const startTime = selected.dataset.startTime || '';
                            const endTime = selected.dataset.endTime || '';

                            document.getElementById('treatment_id').value = treatmentId && treatmentName ?
                                `${treatmentId} - ${treatmentName}` : '';

                            document.getElementById('therapist_id').value = therapistId;
                            document.getElementById('slot_id').value = slotId;
                            document.getElementById('session_date').value = sessionDate;
                            document.getElementById('session_date_display').value = sessionDate;
                            document.getElementById('start_time_display').value = startTime;
                            document.getElementById('end_time_display').value = endTime;

                            // Set session_date input if you want to auto-fill it
                            const sessionDateInput = document.getElementById('session_date');
                            if (sessionDateInput && sessionDate) {
                                sessionDateInput.value = sessionDate;
                            }

                            // Optionally show combined session info if you added #session_info input
                            const sessionInfo = document.getElementById('session_info');
                            if (sessionInfo) {
                                sessionInfo.value = sessionDate && startTime && endTime ?
                                    `Date: ${sessionDate} | Time:${startTime} - ${endTime}` : '';
                            }
                        });
                    } else {
                        document.getElementById('patient_name').value = 'Patient not found';
                        document.getElementById('treatment_id').value = '';
                        document.getElementById('treatmentPrompt').classList.add('d-none');
                    }
                })
                .catch(error => {
                    console.error('Error fetching patient details:', error);
                    document.getElementById('patient_name').value = 'Error loading';
                    document.getElementById('treatment_id').value = '';
                });


        } else {
            document.getElementById('patient_name').value = '';
            document.getElementById('appointment_id').value = '';
            document.getElementById('treatment_id').value = '';
            document.getElementById('treatmentPrompt').classList.add('d-none');
        }
    });
</script>

<?= $this->endSection() ?>