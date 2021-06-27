<script>
    const detachGroup = (id) => {
        fetch("{{ route('roles.attachment.group.detach', ['role' => $role['id']]) }}", {
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
                        updateAttachables(id, 'detach');
                        rgCountCont.innerText = parseInt(rgCountCont.innerText) - 1;
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
</script>