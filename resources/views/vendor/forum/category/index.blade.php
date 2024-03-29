{{-- $category is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends('forum::master', ['category' => null])

@section('content')

    <div class="row">
        <div class="col-md-3">
            @can('createCategories')
                @include('forum::category.partials.form-create')
            @endcan
        </div>
        <div class="col-md-6 text-center">
            <h2>Forum</h2>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            @forelse($categories as $category)
                @include('forum::custom.category')
            @empty
                <div class="alert alert-info">
                    Nothing here yet!<br>
                    Follow instructions below to get started:<br>

                    <ol>
                        <li>
                            <a href="https://docs.gameserverapp.com/dashboard/admin_teams#manage-admins" target="_blank">Link Community website account to your GSA Dashboard account</a>
                        </li>
                        <li>
                            <a href="https://docs.gameserverapp.com/dashboard/admin_teams/#grant-forum-permissions" target="_blank">Grant forum permissions to Admin teams</a>
                        </li>
                    </ol>

                </div>
            @endforelse
        </div>
    </div>
@endsection
