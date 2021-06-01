<script>
    const roleCont = document.getElementById('roles-cont');
    const displayName = document.getElementById('display_name');
    const systemName = document.getElementById('system_name');
    const roleDescription = document.getElementById('description');
    const isSystemRole = document.getElementById('is_system_role');
    let roleCount = {{ $role_count }};
    let existingRoles = {!! json_encode($existing_roles) !!}

    const createRole = () => {
        if (validateCreateInputs()) {
            fetch("{{ route('roles.create') }}", {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        display_name: displayName.value,
                        system_name: systemName.value,
                        description: roleDescription.value,
                        @if (!auth()->user()->hasSystemRole('super-admin'))
                        is_system_role: isSystemRole.checked
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

    const validateCreateInputs = () => {
        if (displayName.value != "") {
            if (systemName.value != "") {
                if (roleDescription.value != "") {
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

    const appendRole = (id) => {
        let role = `
            <div class="card my-3 card-rounded" id="${ id }">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="border-bottom mb-0">${ displayName.value }</h4>
                            <i class="d-block text-right">${ systemName.value } (0)</i>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md">
                            <p class="border role-description border-primary p-4 mb-0">
                                ${ roleDescription.value }
                            </p>
                        </div>
                        <div class="col-md-3 mt-auto text-right">
                            <button class="btn btn-dark">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        if (roleCount == 0) {
            roleCont.innerHTML = role;
        } else {
            roleCont.innerHTML += role;
        }

        roleCount++;
    }
</script>