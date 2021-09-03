<h5 class="border-bottom text-primary mb-0">{{ $log->change_data['user']['email'] }}::<b>{{ $log->change_data['role']['name'] }}</b></h5>
<p class="text-right text-muted">{{ $log->change_data['role']['id'] }}</p>


<div class="row">
    <div class="col-md-12 d-md-flex justify-content-between">
        <div class="border border-primary rounded bg-light p-2 mw-45 my-2">
            <h5 class="border-bottom border-primary text-primary">User</h5>
            <p class="my-2 text-truncate">Name: {{ $log->change_data['user']['name'] }}</p>
            <p class="my-2 text-truncate">Email: {{ $log->change_data['user']['email'] }}</p>
        </div>
        <div class="border border-primary rounded bg-light p-2 mw-45 my-2">
            <h5 class="border-bottom border-primary text-primary">Role</h5>
            <p class="my-2 text-truncate">Name: {{ $log->change_data['role']['name'] }}</p>
            <p class="my-2 text-truncate">Display Name:{{ $log->change_data['role']['display_name'] }}</p>
            <p class="my-2 text-truncate">Description{{ $log->change_data['role']['description'] }}</p>
        </div>
    </div>
</div>