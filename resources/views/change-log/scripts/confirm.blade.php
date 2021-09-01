<script>
    const logs = {!! json_encode($logs) !!};
    const changeReverForm = document.getElementById('change-revert-form');
    const confirmationMessage = document.getElementById('confirmation-message');
    const confirmTextInput = document.getElementById('confirm_text');
    const revertButton = document.getElementById('revert-button');
    const confirmModalButton = document.getElementById('confirm-modal-button');
    let current
    let confirmText = '';

    const confirmRevert = id => {
        let log = logs.find(log => log['id'] == id);
        setConfirmationText(log);
        setConfirmationMessage(log);
        changeReverForm.action = "{{ route('change-log.revert', ['log' => 'log_id']) }}".replace('log_id', id);
        confirmModalButton.click();
    }

    const checkConfirmText = () => {
        if (confirmTextInput.value == confirmText) {
            revertButton.disabled = false;
        } else {
            revertButton.disabled = true;
        }
    }
</script>