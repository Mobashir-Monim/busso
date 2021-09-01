<h4 class="border-bottom text-primary mb-0">{{ $log->change_data['role']['updated']['display_name'] }} (<b>{{ $log->change_data['role']['updated']['name'] }}</b>)</h4>
<p class="text-right text-muted">{{ $log->id }}</p>


<div class="row">
    <div class="col-md-12 d-md-flex justify-content-between">
        <div class="border border-primary rounded bg-light p-2 mw-45 my-2">
            <h5 class="border-bottom border-primary text-primary">Previous</h5>
            @foreach ($log->change_data['role']['previous'] as $key => $value)
                <p class="my-2">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
            @endforeach
        </div>
        <div class="border border-primary rounded bg-light p-2 mw-45 my-2">
            <h5 class="border-bottom border-primary text-primary">Updated</h5>
            @foreach ($log->change_data['role']['updated'] as $key => $value)
                <p class="my-2">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
            @endforeach
        </div>
    </div>
</div>