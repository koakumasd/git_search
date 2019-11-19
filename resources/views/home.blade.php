@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search repositories</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ url('search_repo') }}">
                        <input type="text" name="query" placeholder="Example player" value="{{ !empty($query)?$query:'' }}" required>
                        <input type="submit" value="Submit">
                    </form>

                    @if(!empty($repositories))
                        <div class="row">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Url</th>
                                    <th>Owner</th>
                                    <th>Stargazers count</th>
                                    <th></th>
                                </tr>
                            @foreach($repositories->all() as $repository)
                                <tr>
                                    <td>{{ $repository['name'] }}</td>
                                    <td><a href="{{ $repository['html_url'] }}">{{ $repository['html_url'] }}</a></td>
                                    <td>{{ $repository['owner_login'] }}</td>
                                    <td>{{ $repository['stargazers_count'] }}</td>
                                    <td>
                                        <button class="favorite search {{ $repository['is_favorite']==true?'remove':'add' }}" repo_id="{{ $repository['repo_id'] }}" name="{{ $repository['name'] }}"  html_url="{{ $repository['html_url'] }}"
                                        owner_login="{{ $repository['owner_login'] }}" stargazers_count="{{ $repository['stargazers_count'] }}">
                                            <i class="fa fa-heart{{ $repository['is_favorite']!=true?'-o':'' }}" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                    
                                </tr>
                            @endforeach
                            </table>
                            {!! $paginate !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
