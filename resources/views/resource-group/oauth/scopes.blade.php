@foreach (config('passport.scopes') as $scope => $description)
    <div class="row">
        <div class="col-9">
            <input type="text" class="form-control disabled" disabled value="{{ oauth2ScopeParser($scope) }}">
            <label for="" class="sso-inp-label mr-2 text-primary"><b>{{ $description }}</b></label>
        </div>
        <div class="col-3 text-right">
            <button type="button" class="btn btn-dark" onclick="toggleScope('{{ $scope }}', this)">{{ in_array($scope, $group->oauth->scopes) ? "Deauthorize" : " Authorize " }}</button>
        </div>
        <div class="col-md-12">
            <hr class="border-dark mt-0 mb-4">
        </div>
    </div>
@endforeach

@include('resource-group.scripts.oauth.scopes')