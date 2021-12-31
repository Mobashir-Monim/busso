<script>
    let toggleScope = (scope, el) => {

        fetch("{{ route('resource-groups.oauth.toggle-scope', ['group' => $group, 'oauth' => $group->oauth]) }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    scope: scope,
                })
            }).then(response => {
                console.log(response)
                return response.json();
            }).then(data => {
                console.log(data)
                if (data.hasOwnProperty('success') && data.hasOwnProperty('message')) {
                    el.innerText = el.innerText == "Authorize" ? "Deauthorize" : "Authorize";
                } else {
                    throw 'Error!!!';
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }
</script>