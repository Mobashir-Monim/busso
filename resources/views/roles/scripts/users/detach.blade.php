<script>
    const detachmentMessages = document.getElementById('detachment-messages');
    const singleDetachBtn = '<button class="btn btn-dark" type="button" onclick="singleDetachUser()"><i class="fas fa-user-plus"></i></button>';
    const singleDetachBtnCont = document.getElementById('detach-single-btn-cont');
    const batchDetachBtn = '<button class="btn btn-dark" type="button" onclick="batchDetachUsers()"><i class="fas fa-user-plus"></i></button>';
    const batchDetachBtnCont = document.getElementById('detach-batch-button-cont');
    const singleDetachUserEmail= document.getElementById('detach-user-email');
    const batchDetachFile = document.getElementById('detach-batch-file');

    const singleDetachUser = () => {
        transitStatus(singleDetachBtnCont);
        setTransitionVariables(singleDetachBtnCont, singleDetachBtn);
        setContinueTo('single', 'detach');
        removeUser(singleDetachUserEmail.value);
    }

    const batchDetachUsers = () => {
        transitStatus(batchDetachBtnCont);
        setTransitionVariables(batchDetachBtnCont, batchDetachBtn);
        setContinueTo('batch', 'detach');
        readFile(batchDetachFile);
    }

    const removeUser = (email, direct = false) => {
        fetch("{{ route('roles.attachment.user.detach', ['role' => $role['id']]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    user: email,
                })
            }).then(response => {
                console.log(response)
                return response.json();
            }).then(data => {
                if (direct) {
                    if (data.success) {
                        userCount.innerHTML = parseInt(userCount.innerHTML) - 1;
                        document.getElementById(email).remove();
                    } else {
                        alert(data.message);
                    }
                } else {
                    if (data.hasOwnProperty('success') && data.hasOwnProperty('message')) {
                        addDetachmentMessage(data.success, data.message);
                        continueToNext();
                    } else {
                        throw 'Error!!';
                    }
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const clearDetachmentMessages = () => {
        detachmentMessages.innerHTML = '';
    }

    const addDetachmentMessage = (success, message) => {
        let id = `detachment-${ success ? 'success' : 'failure' }-${ parseInt(userCount.innerHTML) }`;
        let timeout = success ? 10000 : 30000;

        if (success) {
            userCount.innerHTML = parseInt(userCount.innerHTML) - 1;
            detachmentMessages.innerHTML += `<div class="alert alert-primary" role="alert" id="${ id }">${ message }</div>`;
        } else {
            detachmentMessages.innerHTML += `<div class="alert alert-danger alert-important" role="alert" id="${ id }">${ message }</div>`;
        }

        setTimeout(() => {
            document.getElementById(id).remove();
        }, timeout);
    }
</script>