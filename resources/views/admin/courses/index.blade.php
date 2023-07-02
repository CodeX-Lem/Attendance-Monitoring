@extends('admin.layouts.layout')
@section('title','Courses')
@section('content')
<div class="table-responsive h-100">
    <x-search searchRoute="{{ route('admin.courses.index') }}" addRoute="{{ route('admin.courses.create') }}"
        searchMessage='Search course or trainor'></x-search>

    <table class="table align-middle" style="font-size: 14px;">
        <thead class="sticky-top">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Course</th>
                <th scope="col">Trainor</th>
                <th scole="col" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(count($courses) == 0)
            <tr>
                <td colspan="4" class="text-center">No results found</td>
            </tr>
            @endif
            @php
            $counter = 1;
            @endphp
            @foreach($courses as $course)
            <tr class="row-item" onclick="makeActive(this)">
                <th scope="row">{{ $counter++ }}</th>
                <td>{{ $course->course }}</td>
                <td>{{ $course->trainor->fullname }}</td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.courses.show', ['id' => $course->id]) }}"
                        class="btn btn-sm btn-warning rounded-0">
                        Edit
                    </a>
                    <a href="{{ route('admin.courses.destroy', ['id' => $course->id]) }}"
                        class="btn btn-sm btn-danger  rounded-0" data-confirm-delete="true">
                        Delete
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <x-pagination :pageData="$courses" route="{{ route('admin.courses.index') }}"></x-pagination>
</div>
@endsection