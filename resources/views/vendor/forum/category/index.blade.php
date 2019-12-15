{{-- $category is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['category' => null])

@section ('content')

    @forelse($categories as $category)
        @include('forum::custom.category')
    @empty

        <div class="alert alert-info">
            Nothing here yet!<br>
            To edit the forum, you require the "admin" role. You can assign this role, via Admin tools -> Accounts -> {your account} -> role
        </div>
    @endforelse

    @can ('createCategories')
        <hr />
        @include ('forum::category.partials.form-create')
    @endcan
@stop
