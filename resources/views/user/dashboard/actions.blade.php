@if (auth()->user()->hasSystemRole('super-admin') || auth()->user()->hasSystemRole('admin') || auth()->user()->hasSystemRole('user-admin'))
    <form action="{{ route('users.alter-status', ['user' => $user->id]) }}" method="POST" id="status-alter">
        @csrf
    </form>
    <form action="{{ route('users.delete', ['user' => $user->id]) }}" method="POST" id="user-delete">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
    </form>
    <button class="btn btn-danger user-delete-button" type="button" onclick="document.getElementById('user-delete').submit()">
        <i class="fas fa-user-times"></i>
    </button>
    @if ($user->is_active)
        <button class="btn btn-primary user-status-button" type="button" onclick="document.getElementById('status-alter').submit()">
            <span class="material-icons-outlined">lock_open</span>
        </button>
    @else
        <button class="btn btn-secondary user-status-button" type="button" onclick="document.getElementById('status-alter').submit()">
            <span class="material-icons-outlined">lock</span>
        </button>
    @endif
@else
    @if ($user->is_active)
        <button class="btn btn-primary user-status-button" type="button" disabled>
            <span class="material-icons-outlined">lock_open</span>
        </button>
    @else
        <button class="btn btn-secondary user-status-button" type="button" disabled>
            <span class="material-icons-outlined">lock</span>
        </button>
    @endif
@endif

<button class="btn btn-dark user-access-button" type="button" data-toggle="modal" data-target="#access-list">
    <span class="material-icons-outlined">accessibility_new</span>
</button>