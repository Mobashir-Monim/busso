<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
<script>
    const token = 'Bearer {{ auth()->user()->createToken("BuSSO")->accessToken }}';
    const fileInput = document.getElementById('batch-file');
    const progressBar = document.getElementById('progress-bar');
    const batchProgress = document.getElementById('batch-progress');
    const batchFile = document.getElementById('batch-inp');
    const batchButton = document.getElementById('batch-button');
    let uploads = [];
    let current = 0;

    const readFile = () => {
        batchProgress.classList.remove('hidden');
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

                uploads.push(imm);
            }
        });

        createAccount();
    }

    const createAccount = () => {
        console.log(uploads[current].name)
        console.log(uploads[current].email)
        fetch("{{ route('api.users.create') }}", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Authorization": token,
                    },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    name: uploads[current].name,
                    email: uploads[current].email,
                    isApi: true,
                })
            }).then(response => {
                console.log(response)
                return response.json();
            }).then(data => {
                console.log(data);
                updateProgress();
            }).catch(error => {
                console.log(error);
                alert('Whoop! Something went wrong, please refresh the page and try again');
            });
    }

    const updateProgress = () => {
        let completed = `${ (current / uploads.length).toFixed(2) }%`;
        progressBar.style.width = completed;
        progressBar.innerText = completed;
        current++;

        if (current < uploads.length) {
            setTimeout(() => {
                createAccount();
            }, 100);
        } else {
            alert('All done!!');
            location.reload();
        }
    }
</script>