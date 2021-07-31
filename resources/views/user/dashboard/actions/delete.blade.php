@if (auth()->user()->hasSystemRole('super-admin') || auth()->user()->hasSystemRole('admin') || auth()->user()->hasSystemRole('user-admin'))
    <form action="{{ route('users.delete', ['user' => $user->id]) }}" method="POST" id="user-delete">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
    </form>
    <button class="btn btn-danger user-delete-button" type="button" onclick="document.getElementById('user-delete').submit()">
        <i class="fas fa-user-times"></i>
    </button>
@endif