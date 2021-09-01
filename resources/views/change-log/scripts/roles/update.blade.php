<script>
    const setConfirmationMessage = log => {
        confirmationMessage.innerHTML = `
            <p>You are about to revert the changes of a <b><span class="text-danger">Role::update</span></b> with role name <b><span class="text-danger">${ log['change_data']['role']['updated']['name'] }</span></b>.</p>

            <p>Please confirm this action by typing in the following text: <b><span class="text-danger"><br />${ log['change_data']['role']['updated']['name'] }</span></b></p>
        `;
    }

    const setConfirmationText = log => {
        confirmTextInput.placeholder = log['change_data']['role']['updated']['name'];
        confirmText = log['change_data']['role']['updated']['name'];
    }
</script>