@extends('layouts.dashboard')

@section('content')
    {{-- <div id="editor" style="min-height: 65vh">{{ json_encode($config->configs, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) }}</div> --}}
    <form action="{{ route('debugger.create') }}" method="POST" id="debugger-create">
        @csrf
        <input type="hidden" name="config" id="config">
    </form>

    <div class="row">
        <div class="col-md-12">
            <div id="editor" style="min-height: 65vh"></div>
        </div>
        <div class="col-md-12 my-3 text-center">
            <button class="btn btn-dark w-50" onclick="saveConfig()">Create Debugger</button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
        let form = document.getElementById('debugger-create');
        let config = document.getElementById('config');
        let editor = ace.edit("editor");
        editor.setTheme("ace/theme/clouds_midnight");
        editor.session.setMode("ace/mode/json");
        editor.setValue(`{
    "name": "",
    "identifier": "",
    "is_active": false,
    "settings": {
        "functions": [],
        "debug_mode": "break",
        "call_sequence": []
    }
}`);

        const saveConfig = () => {
            config.value = editor.getValue();
            form.submit();
        }

        const setEditorTheme = (theme) => {
            editor.setTheme(`ace/theme/${ theme }`);
        }
    </script>
@endsection