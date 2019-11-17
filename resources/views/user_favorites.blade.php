@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search repositories</div>

                <div class="card-body">
                    @if(!empty($favorites))
                        <div class="row">

                            <table>
                                <tr>
                                    <th>Name</th>
                                    <th>Url</th>
                                    <th>Owner</th>
                                    <th>Stargazers count</th>
                                    <th></th>
                                </tr>
                            @foreach($favorites as $favorite)
                                <tr>
                                    <td>{{ $favorite['name'] }}</td>
                                    <td><a href="{{ $favorite['html_url'] }}">{{ $favorite['html_url'] }}</a></td>
                                    <td>{{ $favorite['owner_login'] }}</td>
                                    <td>{{ $favorite['stargazers_count'] }}</td>
                                    <td><a class="favorite user" repo_id="{{ $favorite['repo_id'] }}" action="remove">Remove</a></td>
                                    
                                </tr>
                            @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
