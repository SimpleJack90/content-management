@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">My profile</div>

        <div class="card-body">
            @include('partials.error')
            <form action="{{route('users.update-profile')}}" method="post">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name
                    </label>
                    <input id="name" type="text" name="name" value="{{$user->name}}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="about">About me</label>
                    <textarea name="about" id="about" cols="5" rows="5" class="form-control">{{$user->about}}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update Profile</button>

            </form>



        </div>
    </div>
@endsection