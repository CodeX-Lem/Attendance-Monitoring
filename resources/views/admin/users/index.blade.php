@extends('admin.layouts.layout')
@section('title','Courses')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-0 p-sm-3">
        <div class="container-fluid">
            <x-search searchRoute="" addRoute="{{ route('admin.users.create') }}" searchMessage='Search any account'>
            </x-search>
            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped align-middle" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Trainor Name</th>
                            <th scope="col">Role</th>
                            <th scole="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($users) == 0)
                        <tr>
                            <td colspan="6" class="text-center">No results found</td>
                        </tr>
                        @endif
                        @php
                        $counter = 1;
                        @endphp
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $counter++ }}</th>
                            <td>{{ $user->username}}</td>
                            <td>{{ $user->trainor->fullname ?? 'N/A' }}</td>
                            <td>{{ $user->role == 0 ? 'Trainor' : 'Admin'}}</td>
                            <td class="text-nowrap text-end">
                                <a href="{{ route('admin.users.changepassShow', ['id' => $user->id]) }}" class="btn btn-sm btn-warning rounded-0">
                                    Change Password
                                </a>

                                <a href="{{ route('admin.users.destroy', ['id' => $user->id]) }}" class="btn btn-sm btn-danger rounded-0" data-confirm-delete="true">
                                    Delete
                                </a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-pagination :pageData="$users" route="{{ route('admin.users.index') }}"></x-pagination>
            </div>
        </div>
    </div>
</div>
@endsection