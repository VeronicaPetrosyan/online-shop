@extends('layouts.main')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Users</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item active text-white">Users</li>
        </ol>
    </div>



    <div class="container-fluid py-5">
        <div class="container py-5">
            @if (session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">Actions</th>
                    </tr>

                     <form method="GET" action="{{ route('admin.users.index') }}">
                        <th>
                            <input type="text" name="username" class="form-control" value="{{ request('username') }}">
                        </th>
                         <th>
                            <input type="text" name="email" class="form-control" value="{{ request('email') }}">
                        </th>
                        <th>
                            <input type="date" name="created_at" class="form-control"
                                   value="{{ request('created_at') }}">
                        </th>
                        <th>
                            <input type="date" name="updated_at" class="form-control"
                                   value="{{ request('updated_at') }}">
                        </th>
                        <th>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </th>
                    </form>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <p class="mb-0 mt-4">{{ $user->name }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $user->email }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $user->created_at ? $user->created_at->format('F d, Y') : 'N/A'}}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $user->updated_at ? $user->updated_at->format('F d, Y') : 'N/A'}}</p>
                            </td>
                            <td style="display: flex; flex-direction: column; height: 97px">
                                <a href="{{ route('admin.users.edit', $user->id) }}" style="margin: 10px 0"> Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn"
                                            style="background: none; border: none; padding: 0; color: #81c408"
                                            onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-times text-danger"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $users->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
