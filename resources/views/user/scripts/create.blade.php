<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
<script>
    let userRole = null;
    const systemRole = document.getElementById('system_role');
    const userName = document.getElementById('user-name');
    const userEmail = document.getElementById('user-email');
    const fileInput = document.getElementById('batch-file');
    const progressBar = document.getElementById('progress-bar');
    const batchProgress = document.getElementById('batch-progress');
    const batchFile = document.getElementById('batch-inp');
    const batchButton = document.getElementById('batch-button');
    const statusCont = document.getElementById('status-cont');
    let uploads = [];
    let current = 0;

    const readFile = () => {
        // batchProgress.classList.remove('hidden');
        batchFile.classList.add('hidden');
        batchButton.classList.add('hidden');
        
        setTimeout(() => {
            let reader = new FileReader();

            reader.onload = function () {
                exelToJSON(reader.result);
            };

            reader.readAsBinaryString(fileInput.files[0]);
        }, 100);
    };

    const exelToJSON = data => {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {   
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {defval: ""});
            let headers = Object.keys(oJS[0]);

            for (let index = 0; index < oJS.length; index++) {
                let imm = {};

                headers.forEach(key => {
                    imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString().replace(/\s+/g,' ').trim() : oJS[index][key];
                });

                imm.role = 'system-user';

                uploads.push(imm);
            }
        });

        createAccount();
    }

    const createAccount = () => {
        fetch("{{ route('users.create') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    name: uploads[current].name,
                    email: uploads[current].email,
                    system_role: uploads[current].role,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                setStatus(data);
                updateProgress();
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const updateProgress = () => {
        current += 1;
        let completed = `${ (current / uploads.length).toFixed(1) }%`;
        progressBar.style.width = completed;
        progressBar.innerText = completed;

        if (current < uploads.length) {
            setTimeout(() => {
                createAccount();
            }, 100);
        } else {
            alert('All done!!');
            location.reload();
        }
    }

    const createUser = () => {
        current = 0;
        uploads = [{
            name: userName.value,
            email: userEmail.value,
            role: systemRole.value
        }];
        createAccount();
    }

    const setStatus = (status) => {
        let timeout = 2000;

        if (status.success) {
            statusCont.innerHTML += `<div class="alert alert-primary" role="alert" id="status-${ current }">${ status.message }</div>`;
        } else {
            statusCont.innerHTML += `<div class="alert alert-danger alert-important" role="alert" id="status-${ current }">${ status.message }</div>`;
            timeout = 5000;
        }

        setTimeout(() => {
            document.getElementById(id).remove();
        }, timeout);
    }
</script>