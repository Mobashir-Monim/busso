<script>
    const setConfirmationMessage = log => {
        confirmationMessage.innerHTML = `
            <p>You are about to revert the changes of a <b><span class="text-danger">User::create</span></b> with email address <b><span class="text-danger">${ log['change_data']['user']['updated']['email'] }</span></b>.</p>

            <p>Please confirm this action by typing in the following text: <b><span class="text-danger"><br />${ log['change_data']['user']['updated']['email'] }</span></b></p>
        `;
    }

    const setConfirmationText = log => {
        confirmTextInput.placeholder = log['change_data']['user']['updated']['email'];
        confirmText = log['change_data']['user']['updated']['email'];
    }
</script>