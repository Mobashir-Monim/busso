<h4 class="border-bottom text-primary mb-0">{{ $log->change_data['user']['name'] }} (<b>{{ $log->change_data['user']['email'] }}</b>)</h4>
<p class="text-right text-muted">{{ $log->id }}</p>


<div class="row">
    <div class="col-md-12">
        <div class="border border-primary rounded bg-light p-2 my-2">
            <p class="my-2 text-truncate">Name: {{ $log->change_data['user']['name'] }}</p>
            <p class="my-2 text-truncate">Email: {{ $log->change_data['user']['email'] }}</p>
            <p class="my-2 text-truncate">Password: *********</p>
            <p class="my-2 text-truncate">Is Active: {{ $log->change_data['user']['is_active'] ? 'Active' : 'Inactive' }}</p>
            <p class="my-2 text-truncate">Force Reset Pasasword: {{ $log->change_data['user']['force_reset'] ? 'Yes' : 'No' }}</p>
            <p class="my-2 text-truncate">Last Password Change: {{ is_null($log->change_data['user']['pass_change_at']) ? 'Not changed' : Carbon\Carbon::parse($log->change_data['user']['pass_change_at'])->toRssString() }}</p>
        </div>
    </div>
</div>