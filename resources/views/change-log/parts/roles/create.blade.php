<h4 class="border-bottom text-primary mb-0">{{ $log->change_data['role']['display_name'] }} (<b>{{ $log->change_data['role']['name'] }}</b>)</h4>
<p class="text-right text-muted">{{ $log->change_data['role']['id'] }}</p>


<div class="border border-primary rounded bg-light p-2">
    <p class="my-2 text-truncate">Name: {{ $log->change_data['role']['name'] }}</p>
    <p class="my-2 text-truncate">Display Name: {{ $log->change_data['role']['display_name'] }}</p>
    <p class="my-2 text-truncate">Description: {{ $log->change_data['role']['description'] }}</p>
</div>