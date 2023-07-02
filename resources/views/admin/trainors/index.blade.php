@extends('admin.layouts.layout')
@section('title','Trainors')
@section('content')
<div class="table-responsive h-100">
    <x-search searchRoute="{{ route('admin.trainors.index') }}" addRoute="{{ route('admin.trainors.create') }}" searchMessage='Search any trainor here'></x-search>

    <table class="table align-middle" style="font-size: 14px;">
        <thead class="sticky-top">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Address</th>
                <th scope="col">Contact Number</th>
                <th scole="col" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(count($trainors) == 0)
            <tr>
                <td colspan="6" class="text-center">No results found</td>
            </tr>
            @endif
            @php
            $counter = 1;
            @endphp
            @foreach($trainors as $trainor)
            <tr class="row-item" onclick="makeActive(this)">
                <th scope="row">{{ $counter++ }}</th>
                <td>{{ $trainor->fullname}}</td>
                <td>{{ $trainor->gender}}</td>
                <td>{{ $trainor->address}}</td>
                <td>{{ $trainor->contact_no}}</td>
                <td class="text-nowrap text-end">
                    <a href="{{ route('admin.trainors.show', ['id' => $trainor->id]) }}" class="btn btn-sm btn-warning rounded-0">
                        Edit
                    </a>

                    <a href="{{ route('admin.trainors.destroy', ['id' => $trainor->id]) }}" class="btn btn-sm btn-danger rounded-0" data-confirm-delete="true">
                        Delete
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <x-pagination :pageData="$trainors" route="{{ route('admin.trainors.index') }}"></x-pagination>
</div>
@endsection