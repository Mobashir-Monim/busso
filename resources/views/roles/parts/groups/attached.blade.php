<div class="col-md-6">
    <div class="card card-rounded">
        <div class="card-body" style="min-height: 10vh">
            <h5 class="border-bottom">Attached Groups</h5>
            <div class="mt-3" id="rg-attached">
                @if (sizeof($groups['attached']) > 0)
                    @foreach ($groups['attached'] as $group)
                        <div class="card card-rounded mb-3" style="max-width: 540px;" id="detachable-{{ $group['id'] }}">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="{{ $group['image'] }}" class="img-fluid" style="border-top-left-radius: 25px; border-bottom-left-radius: 25px" alt="{{ $group['name'] }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body pb-0 pr-2">
                                        <h5 class="card-title">{{ $group['name'] }}</h5>
                                        <p class="card-text">
                                            @if (is_null($group['description']))
                                                No Description
                                            @else
                                                {{ $group['description'] }}
                                            @endif
                                        </p>
                                        <p class="mb-0 mt-3 text-right">
                                            <span class="material-icons-outlined text-muted role-rg-add" onclick="detachGroup('{{ $group['id'] }}')">remove</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h5 class="border-bottom my-5 text-muted text-center">No Resouce Groups attached</h5>
                @endif
            </div>
        </div>
    </div>
</div>