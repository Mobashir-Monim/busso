<script>
    const searchBox = document.getElementById('search-box');
    const rgAttachable = document.getElementById('rg-attachable');
    const rgAttached = document.getElementById('rg-attached');
    const rgCountCont = document.getElementById('role-group-count');
    let attachedGroups = {!! json_encode($groups['attached']) !!};
    let attachableGroups = {!! json_encode($groups['detached']) !!};

    const searchAttachable = () => {
        let searched = '';

        if (searchBox.value != "") {
            getSearchResults().forEach(group => {
                searched = `${ searched }
                    <div class="card card-rounded mb-3" style="max-width: 540px;" id="attachable-${ group.id }">
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
                                        <span class="material-icons-outlined text-muted role-rg-add" onclick="attachGroup('${ group.id }')">add</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            searched = '<h5 class="border-bottom my-4 text-muted text-center">Search Groups to attach</h5>';
        }

        searched = searched == '' ? '<h5 class="border-bottom my-4 text-muted text-center">No resource groups found</h5>' : searched;
        rgAttachable.innerHTML = searched;
    }

    const getSearchResults = () => {
        return attachableGroups.filter(group => {
            if (group.description == null) {
                return group.name.toLowerCase().includes(searchBox.value.toLowerCase());
            } else {
                return group.name.toLowerCase().includes(searchBox.value.toLowerCase()) || group.description.toLowerCase().includes(searchBox.value.toLowerCase());
            }
        });
    }

    const updateAttachables = (id, mode = 'attach') => {
        destinationCont = attachedGroups;
        sourceCont = attachableGroups;

        if (mode == 'detach') {
            destinationCont = attachableGroups;
            sourceCont = attachedGroups;
            document.getElementById(`detachable-${ id }`).remove();
        } else {
            document.getElementById(`attachable-${ id }`).remove();
        }

        destinationCont.push(sourceCont.splice(sourceCont.indexOf(sourceCont.find(g => g.id == id)), 1)[0]);
        searchAttachable();
        if (attachedGroups.length == 0) {
            rgAttached.innerHTML = '<h5 class="border-bottom my-5 text-muted text-center">No Resouce Groups attached</h5>';
        }
    }
</script>