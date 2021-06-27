<script>
    const attachGroup = (id) => {
        fetch("{{ route('roles.attachment.group.attach', ['role' => $role['id']]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    group: id,
                })
            }).then(response => {
                console.log(response)
                return response.json();
            }).then(data => {
                console.log(data)

                if (data.hasOwnProperty('success') && data.hasOwnProperty('message')) {
                    if (data.success) {
                        appendToAttached(id);
                        updateAttachables(id);
                        rgCountCont.innerText = parseInt(rgCountCont.innerText) + 1;
                    }

                    alert(data.message);
                } else {
                    throw 'Error!!';
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const appendToAttached = (id) => {
        let group = attachableGroups.find(g => g.id == id);
        let content = `
            <div class="card card-rounded mb-3" style="max-width: 540px;" id="detachable-${ group.id }">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="${ group.image }" class="img-fluid" style="border-top-left-radius: 25px; border-bottom-left-radius: 25px" alt="${ group.name }">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body pb-0 pr-2">
                            <h5 class="card-title">${ group.name }</h5>
                            <p class="card-text mb-1 text-truncate">
                                ${ group.description == null ? 'No Description' : group.description }
                            </p>
                            <p class="mb-0 mt-3 text-right">
                                <span class="material-icons-outlined text-muted role-rg-add" onclick="detachGroup('${ group.id }')">remove</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        if (attachedGroups.length == 0) {
            rgAttached.innerHTML = content;
        } else {
            rgAttached.innerHTML += content;
        }
    }

    
</script>