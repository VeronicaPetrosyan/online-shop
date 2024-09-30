@extends('layouts.main')
@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Edit User</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">Users</a></li>
            <li class="breadcrumb-item active text-white">Edit - {{$user->name}}</li>
        </ol>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Edit</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="form-item w-100">
                            <label class="form-label my-3">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="form-item w-100">
                            <label class="form-label my-3">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="row g-4 text-center align-items-center pt-4" style="width: 200px">
                            <button type="submit" style="margin-left: 10px"
                                    class="btn border-secondary text-uppercase text-primary">Submit
                            </button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
@endsection
