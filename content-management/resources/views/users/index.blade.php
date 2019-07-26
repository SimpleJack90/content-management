@extends('layouts.app')


@section('content')



    <div class="card">
        <div class="card-header">
            Users
        </div>

        <div class="card-body">
            @if($users->count()>0)

                <table class="table">
                    <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)
                        <tr>
                            <td>
                                <img width="40px" height="40" style="border-radius: 50%;" src="{{Gravatar::src($user->email)}}">
                            </td>
                            <td>{{$user->name}}</td>

                            <td>{{$user->email}}</td>

                            <td>
                                @if(!$user->isAdmin())
                                    <form action="{{route('users.make-admin',$user->id)}}" method="post">
                                        @csrf

                                    <button type="submit" class="btn btn-success btn-sm">
                                        Make Admin
                                    </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-center">No Users Yet</h3>
            @endif
        </div>
    </div>
@endsection