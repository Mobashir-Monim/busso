<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/jszip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
<script>
    const fileInput = document.getElementById('batch-file');
    const batchProgress = document.getElementById('batch-progress');

    const readFile = () => {
        batchProgress.innerHTML = '<div class="mt-2 spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
        setTimeout(() => {
            let reader = new FileReader();

            reader.onload = function () {
                exelToJSON(reader.result, out, file);
            };

            reader.readAsBinaryString(fileInput.files[0]);
        }, 100);
    };

    function exelToJSON(data, out, file) {
        let cfb = XLSX.read(data, {type: 'binary'});
            
        cfb.SheetNames.forEach(function(sheetName) {   
            let oJS = XLS.utils.sheet_to_json(cfb.Sheets[sheetName], {defval: ""});
            let result = [];
            let headers = Object.keys(oJS[0]);

            for (let index = 0; index < oJS.length; index++) {
                let imm = {};

                if (file == "usis-registrations") {
                    headers.forEach(key => {
                        if (key == "section") {
                            imm[key] = oJS[index][key] != undefined ? parseInt(oJS[index][key].toString().replace(/\s+/g,' ').trim().replace(/\D/g,'')) : oJS[index][key];
                        } else {
                            imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString().replace(/\s+/g,' ').trim() : oJS[index][key];
                        }
                    });
                } else {
                    headers.forEach(key => {
                        if (file == "eval-response" && key == "Course") {
                            imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString().replace(/\s+/g,' ').trim().replaceAll(/\s/g, '').replaceAll('-', '.') : oJS[index][key];
                        } else {
                            imm[key] = oJS[index][key] != undefined ? oJS[index][key].toString().replace(/\s+/g,' ').trim() : oJS[index][key];
                        }
                    });
                }

                if (file == "eval-response") {
                    imm['timed-identifier'] = `${ imm["Identifier"] }-${ imm["Timestamp"] }`;
                }

                result.push(imm);
            }

            if (file == "eval-response") {
                evalsHeader = headers;
                evals = result;
            } else if (file == "usis-registrations") {
                usisRegHeader = headers;
                usisReg = result;
            } else if (file == "gsuite") {
                gsuiteHeader = headers;
                gsuite = result;
            } else {
                parts = result;
                storeResults();
            }

            if (usisRegHeader != null && gsuiteHeader != null && file != 'backup') { console.log('Generating ID Map'); generateIDMap(); }
            if (usisRegHeader != null && evalsHeader != null && gsuiteHeader != null && file != 'backup') {
                document.getElementById('evaluator').classList.remove('hidden');
            }


            out.innerHTML = "";
        });
    }
</script>