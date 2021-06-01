<script>
    const updateRole = () => {
        if (validateUpdateInputs()) {
            fetch("{{ route('roles.update', ['role' => 'role_id']) }}".replace('role_id', currentShown), {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        id: currentShown,
                        display_name: shownDisplayName.value,
                        system_name: shownSystemName.value,
                        description: shownRoleDescription.value,
                        @if (!auth()->user()->hasSystemRole('super-admin'))
                        is_system_role: shownIsSystemRole.checked
                        @endif
                    })
                }).then(response => {
                    console.log(response)
                    return response.json();
                }).then(data => {
                    console.log(data)
                    if (data.hasOwnProperty('success') && data.hasOwnProperty('message')) {
                        if (data.success) {
                            appendRole(data.role_id);
                        }

                        updateViewDetails(currentShown);
                        alert(data.message);
                    } else {
                        throw 'Error!!!';
                    }
                }).catch(error => {
                    console.log(error);
                    alert('Whoop! Something went wrong, please refresh the page and try again');
                });
        }
    }

    const validateUpdateInputs = () => {
        if (shownDisplayName.value != "") {
            if (shownSystemName.value != "") {
                if (shownRoleDescription.value != "") {
                    return true;
                } else {
                    alert('Please enter a description for the role so that it is easier to understand');
                }
            } else {
                alert('Please do not change the system role name input');
            }
        } else {
            alert('Please type in a name for the role');
            
            return false;
        }
    }

    const updateViewDetails = (id) => {
        document.getElementById(`display-${ id }`).innerHTML = shownDisplayName.value;
        document.getElementById(`name-${ id }`).innerHTML = shownSystemName.value;
        document.getElementById(`description-${ id }`).innerHTML = shownRoleDescription.value;
        shownRoleName.innerHTML = shownDisplayName.value;
    }
</script>