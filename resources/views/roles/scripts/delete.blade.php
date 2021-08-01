<script>
    let currentDelete = null;
    const deleteForm = document.getElementById('role-delete-form')
    const deleteRoleName = document.getElementById('delete-role-name');
    const deleteRoleUsers = document.getElementById('delete-role-users');
    const deleteRoleGroups = document.getElementById('delete-role-groups');
    const deleteRoleInput = document.getElementById('delete-confirm');
    const deleteRoleButton = document.getElementById('delete-button');

    const prepareDeletePrompt = (id, name, users, groups) => {
        deleteForm.action = '{{ route('roles.delete', ['role' => 'REPLACE']) }}'.replace('REPLACE', id);
        console.log(deleteForm.action);
        deleteRoleName.innerText = name;
        deleteRoleUsers.innerText = users;
        deleteRoleGroups.innerText = groups;
        deleteRoleInput.placeholder = name;
        deleteRoleInput.value = '';
        currentDelete = name;
    }

    const confirmDelete = () => {
        if (currentDelete == deleteRoleInput.value) {
            deleteRoleButton.disabled = false;
        } else {
            deleteRoleButton.disabled = true;
        }
    }
</script>