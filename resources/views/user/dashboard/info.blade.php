<div class="col-md-8 my-2">
    <div class="card card-rounded">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @if (auth()->user()->hasSystemRole('super-admin') || auth()->user()->hasSystemRole('admin') || auth()->user()->hasSystemRole('user-admin'))
                        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                            @csrf
                            <input type="text" name="name" class="form-control mb-3 h4-input" value="{{ $user->name }}">
                        </form>
                    @else
                        <input type="text" name="name" class="form-control mb-3 h4-input" style="background-color: #fff;border-bottom: 1px solid #3490dc !important;" disabled value="{{ $user->name }}">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-1 text-center"><b><span class="material-icons-outlined text-dark font-icon-24">alternate_email</span></b></div>
                <div class="col-10 col-sm-11 my-auto">{{ $user->email }}</div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-1 mb-1 text-center"><b><i class="fas fa-user-tag text-dark font-icon-24"></i></b></div>
                <div class="col-10 col-sm-11 my-auto">{{ $user->roles->where('is_system_role', true)->first()->display_name }}</div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-1 mb-1 text-center"><b><i class="far fa-calendar-plus text-dark font-icon-24"></i></b></div>
                <div class="col-10 col-sm-11 my-auto">{{ Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-1 mb-1 text-center"><b><span class="material-icons-outlined font-icon-24 text-dark">lock_clock</span></b></div>
                <div class="col-10 col-sm-11 my-auto">{{ !is_null($user->pass_change_at) ? Carbon\Carbon::parse($user->pass_change_at)->format('d M, Y') : 'Not changed' }}</div>
            </div>
            
            @include('user.dashboard.actions.index')
        </div>
    </div>
</div>