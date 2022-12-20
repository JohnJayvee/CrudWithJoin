@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Contacts</h1>
            <table id="example" class="table table-striped table-bordered" style="width:100%">

                <thead>
                    <tr>
                        <td>Firstname:</td>
                        <td>Lastname</td>
                        <td>Email</td>
                        <td>City</td>
                        <td>Country </td>
                        <td>Job Title</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $contact->first_name }}</td>
                        <td>{{ $contact->last_name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->city }}</td>
                        <td>{{ $contact->country }}</td>
                        <td>{{ $contact->job_title }}</td>
                    </tr>






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
