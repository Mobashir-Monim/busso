<h4 class="border-bottom text-primary mb-0">{{ $log->change_data['user']['updated']['name'] }} (<b>{{ $log->change_data['user']['updated']['email'] }}</b>)</h4>
<p class="text-right text-muted">{{ $log->id }}</p>


<div class="row">
    <div class="col-md-12 d-md-flex justify-content-between">
        <div class="border border-primary rounded bg-light p-2 mw-45 my-2">
            <h5 class="border-bottom border-primary text-primary">Previous</h5>
            @foreach ($log->change_data['user']['previous'] as $key => $value)
                @if ($key == 'is_active')
                    <p class="my-2 text-truncate">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value ? 'Active' : 'Inactive' }}</p>
                @elseif ($key == 'password')
                    <p class="my-2 text-truncate">{{ ucfirst(str_replace('_', ' ', $key)) }}: *********</p>
                @else
                    <p class="my-2 text-truncate">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
                @endif
            @endforeach
        </div>
        <div class="border border-primary rounded bg-light p-2 mw-45 my-2">
            <h5 class="border-bottom border-primary text-primary">Updated</h5>
            @foreach ($log->change_data['user']['updated'] as $key => $value)
                @if ($key == 'is_active')
                    <p class="my-2 text-truncate">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value ? 'Active' : 'Inactive' }}</p>
                @elseif ($key == 'password')
                    <p class="my-2 text-truncate">{{ ucfirst(str_replace('_', ' ', $key)) }}: *********</p>
                @else
                    <p class="my-2 text-truncate">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
                @endif
            @endforeach
        </div>
    </div>
</div>