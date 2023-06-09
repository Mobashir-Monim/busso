@if (auth()->user()->hasSystemRole('super-admin') || auth()->user()->hasSystemRole('admin') || auth()->user()->hasSystemRole('user-admin'))
    <form action="{{ route('users.alter-status', ['user' => $user->id]) }}" method="POST" id="status-alter">
        @csrf
    </form>
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