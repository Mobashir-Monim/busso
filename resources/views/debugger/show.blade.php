@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('debugger.update', ['item' => $item->id]) }}" method="POST" id="debugger-update">
        <input type="hidden" name="_method" value="PATCH">
        @csrf
        <input type="hidden" name="config" id="config">
    </form>

    <div class="row">
        <div class="col-md-12">
            <div id="editor" style="min-height: 65vh">{{ json_encode($item->content, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) }}</div>
        </div>
        <div class="col-md-6 my-3 text-center">
            <button class="btn btn-dark w-100" onclick="saveConfig()">Update Debugger</button>
        </div>
        <div class="col-md-6 my-3 text-center">
            <form action="{{ route('debugger.delete', ['item' => $item->id]) }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                @csrf
                <button class="btn btn-danger w-100">Delete Debugger</button>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
        let form = document.getElementById('debugger-update');
        let config = document.getElementById('config');
        let editor = ace.edit("editor");
        editor.setTheme("ace/theme/clouds_midnight");
        editor.session.setMode("ace/mode/json");

        const saveConfig = () => {
            config.value = editor.getValue();
            form.submit();
        }

        const setEditorTheme = (theme) => {
            editor.setTheme(`ace/theme/${ theme }`);
        }
    </script>
@endsection