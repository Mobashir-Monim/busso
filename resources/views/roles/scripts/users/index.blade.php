<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>

<script>
    const spinner = '<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>';
    const usersBody = document.getElementById('users');
    const userLoadBtn = document.getElementById('user-load-btn');
    let userCount = document.getElementById('role-user-count');
    let attachable = [];
    let continueTo = {
        type: null,
        action: null,
    };
    let transitionVariables = {
        container: null,
        element: null
    };
    const pages = [
        @for ($i = 1; $i <= json_decode($users->toJson())->last_page; $i++)
        {'number': {{ $i }}, 'visited': {{ $i == 1 ? 'true' : 'false' }}},
        @endfor
    ];
    let actionMessages = [];

    const loadMore = () => {
        let page = pages.find(x => !x.visited);

        fetch(`{{ route('roles.attachment.user', ['role' => $role['id']]) }}?page=${ page.number }&mode=api`, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                method: 'get',
                credentials: "same-origin",
            }).then(response => {
                console.log(response)
                return response.json();
            }).then(data => {
                if (data.success) {
                    appendUsers(data.users);
                    alterLoadable();
                }
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const appendUsers = (users) => {
        let rows = '';

        for (let u in users) {
            rows = `${ rows }
                <tr id="${ users[u].email }">
                    <td class="py-4">${ users[u].name }</td>
                    <td class="py-4">${ users[u].email }</td>
                    <td class="text-right">
                        <button class="btn btn-dark" onclick="removeUser('${ users[u].email }', true)" type="button"><i class="fas fa-user-times"></i></button>
                    </td>
                </tr>
            `;
        }

        usersBody.innerHTML += rows;
    }

    const alterLoadable = () => {
        let page = pages.find(x => !x.visited);
        page.visited = true;

        if (pages.filter(x => !x.visited).length == 0) {
            userLoadBtn.classList.add('hidden');
        }
    }

    const readFile = (fileInput) => {
        setTimeout(() => {
            let reader = new FileReader();

            reader.onload = function () {
                exelToJSON(reader.result);
            };

            reader.readAsBinaryString(fileInput.files[0]);
        }, 100);
    };

    const exelToJSON = (data) => {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {   
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {defval: ""});
            let results = [];
            
            if (oJS.length > 0) {
                for (let index = 0; index < oJS.length; index++) {
                    attachable.push(undefined ? oJS[index]['email'].toString().replace(/\s+/g,' ').trim() : oJS[index]['email']);
                }
            }
        });

        continueToNext();
    }

    const setTransitionVariables = (container, element = spinner) => {
        transitionVariables.container = container;
        transitionVariables.element = element;
    }

    const setContinueTo = (type, action) => {
        continueTo.type = type;
        continueTo.action = action;
    }

    const transitStatus = (container, element = spinner) => {
        container.innerHTML = element;
    }

    const continueToNext = () => {
        if (continueTo.type == 'single' || attachable.length == 0) {
            transitStatus(transitionVariables.container, transitionVariables.element);
        } else {
            if (continueTo.action == 'attach') {
                addUser(attachable.shift());
            } else {
                removeUser(attachable.shift());
            }
        }
    }
</script>