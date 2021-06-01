<!-- henlo -->
<script>
    const attachmentMessages = document.getElementById('attachment-messages');
    const singleAttachBtn = '<button class="btn btn-dark" type="button" onclick="singleAttachUser()"><i class="fas fa-user-plus"></i></button>';
    const singleAttachBtnCont = document.getElementById('attach-single-btn-cont');
    const batchAttachBtn = '<button class="btn btn-dark" type="button" onclick="batchAttachUsers()"><i class="fas fa-user-plus"></i></button>';
    const batchAttachBtnCont = document.getElementById('attach-batch-button-cont');
    const singleAttachUserEmail= document.getElementById('attach-user-email');
    const batchAttachFile = document.getElementById('attach-batch-file');

    const singleAttachUser = () => {
        transitStatus(singleAttachBtnCont);
        setTransitionVariables(singleAttachBtnCont, singleAttachBtn);
        setContinueTo('single', 'attach');
        addUser(singleAttachUserEmail.value);
    }

    const batchAttachUsers = () => {
        transitStatus(batchAttachBtnCont);
        setTransitionVariables(batchAttachBtnCont, batchAttachBtn);
        setContinueTo('batch', 'attach');
        readFile(batchAttachFile);
    }

    const addUser = (email) => {
        fetch("{{ route('roles.attachment.user.attach', ['role' => $role['id']]) }}", {
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
                if (data.hasOwnProperty('success') && data.hasOwnProperty('message')) {
                    addAttachmentMessage(data.success, data.message);
                    continueToNext();
                } else {
                    throw 'Error!!';
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const clearAttachmentMessages = () => {
        attachmentMessages.innerHTML = '';
    }

    const addAttachmentMessage = (success, message) => {
        let id = `detachment-${ success ? 'success' : 'failure' }-${ parseInt(userCount.innerHTML) }`;
        let timeout = success ? 10000 : 30000;

        if (success) {
            userCount.innerHTML = parseInt(userCount.innerHTML) + 1;
            attachmentMessages.innerHTML += `<div class="alert alert-primary" role="alert" id="${ id }">${ message }</div>`;
        } else {
            attachmentMessages.innerHTML += `<div class="alert alert-danger alert-important" role="alert" id="${ id }">${ message }</div>`;
        }

        setTimeout(() => {
            document.getElementById(id).remove();
        }, timeout);
    }
</script>