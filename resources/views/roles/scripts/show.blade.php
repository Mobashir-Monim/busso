<script>
    let currentShown = null;
    const roleShowBtn = document.getElementById('role-show-btn');
    const shownRoleName = document.getElementById('role-show-name');
    const shownRoleUserCount = document.getElementById('role-user-count');
    const shownRoleRGCoung = document.getElementById('role-group-count')
    const shownDisplayName = document.getElementById('display_name_show');
    const shownSystemName = document.getElementById('system_name_show');
    const shownRoleDescription = document.getElementById('description_show');
    const shownIsSystemRole = document.getElementById('is_system_role_show');

    const showRole = (id) => {
        fetch("{{ route('roles.show', ['role' => 'role_id']) }}".replace('role_id', id), {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                method: 'get',
                credentials: "same-origin",
            }).then(response => {
                return response.json();
            }).then(data => {
                if (data.hasOwnProperty('success') && data.hasOwnProperty('role_data')) {
                    if (data.success) {
                        currentShown = id;
                        shownRoleName.innerHTML = data.role_data.details.display_name;
                        shownDisplayName.value = data.role_data.details.display_name;
                        shownSystemName.value = data.role_data.details.name;
                        shownRoleDescription.value = data.role_data.details.description;
                        shownRoleUserCount.innerHTML = data.role_data.details.users;
                        shownRoleRGCoung.innerHTML = data.role_data.details.resource_groups;
                        roleShowBtn.click();
                    }
                } else {
                    console.log('erroring')
                    throw 'Error!!!';
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const showUsers = () => {
        window.open("{{ route('roles.attachment.user', ['role' => 'role_id']) }}".replace('role_id', currentShown), '_blank');
    }

    const setRoleSystemName = (type = 'create') => {
        let targetSource = type == 'show' ? shownDisplayName : displayName;
        let targetDestination = type == 'show' ? shownSystemName : systemName;
        let value = targetSource.value.toLowerCase().replaceAll(' ', '-');

        if (existingRoles.includes(value)) {
            let count = 0
            
            while (true) {
                if (existingRoles.includes(`${ value }-${ count }`)) {
                    count += 1;
                } else {
                    break;
                }
            }

            value = `${ value }-${ count }`;
        }

        targetDestination.value = value;
    }
</script>