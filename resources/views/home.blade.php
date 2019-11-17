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
                        <input type="text" name="query" placeholder="Example player" value="{{ !empty($query)?$query:'' }}">
                        <input type="submit" value="Submit">
                    </form>

                    @if(!empty($results))
                        <div class="row">

                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Url</th>
                                    <th>Owner</th>
                                    <th>Stargazers count</th>
                                    <th></th>
                                </tr>
                            @foreach($results as $result)
                                <tr>
                                    <td>{{ $result['name'] }}</td>
                                    <td><a href="{{ $result['html_url'] }}">{{ $result['html_url'] }}</a></td>
                                    <td>{{ $result['owner_login'] }}</td>
                                    <td>{{ $result['stargazers_count'] }}</td>
                                    <td>
                                        <button class="favorite search" repo_id="{{ $result['repo_id'] }}" name="{{ $result['name'] }}"  html_url="{{ $result['html_url'] }}"
                                        owner_login="{{ $result['owner_login'] }}" stargazers_count="{{ $result['stargazers_count'] }}">
                                            <i class="fa fa-heart{{ $result['is_favorite']!=true?'-o':'' }}" aria-hidden="true"></i>
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
