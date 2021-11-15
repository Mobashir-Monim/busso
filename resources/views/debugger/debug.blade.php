@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="editor" style="min-height: 65vh">{{ json_encode(json_decode($debug_data), JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) }}</div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
        let editor = ace.edit("editor");
        editor.setTheme("ace/theme/clouds_midnight");
        editor.session.setMode("ace/mode/json");
    </script>
@endsection