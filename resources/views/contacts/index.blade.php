@extends('base')
@section('main')

    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Contacts</h1>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>First Name</td>
                        <td>Last Name</td>
                        <td>Email</td>
                        <td>Job Title</td>
                        <td>City</td>
                        <td>Country</td>
                        <td colspan="3" style="text-align: center;">Action</td>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $row)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $row->first_name }}</td>
                            <td>{{ $row->last_name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->job_title }}</td>
                            <td>{{ $row->city }}</td>
                            <td>{{ $row->country }}</td>
                            <td white-space: pre;>
                                <a href="{{ route('contact.show', Crypt::encryptString($row->id)) }}"
                                    class="btn btn-warning">Show</a>
                            </td>

                            <td>
                                <a href="{{ route('contact.edit', Crypt::encryptString($row->id)) }}"
                                    class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                {{-- <form method="post" action="{{ route('contact.destroy', Crypt::encryptString
                                ($row->id)) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form> --}}

                                {{ Form::open(['route' => ['contact.destroy', Crypt::encryptString($row->id)], 'method' => 'delete']) }}
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>

                                {{ Form::close() }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
            </div>
        @endsection
        <div class="col-sm-12">

            @if (session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
        <div>
            <a style="margin: 19px;" href="{{ route('contact.create') }}" class="btn btn-primary">New contact</a>
        </div>
