@extends('layouts.admin')

@section('content')
    {{-- All Profiles --}}
    @if (Session::get('success'))
        <div class="alert alert-success text-cennter ">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="container pt-5 pb-5 text-white fw-bold">
        <h2 class="fs-4">All Profiles</h2>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th class="p-1" scope="col">ID</th>
                    <th class="p-1" scope="col">UserName</th>
                    <th class="p-1" scope="col">Email</th>
                    {{-- class="p-1"  <th scope="col">Password</th> --}}
                    <th class="p-1" scope="col">Action</th>


                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">1</td>
                    <td>Mark</td>
                    <td>Otto@gmail.com</td>
                    {{-- <td>3424!#1</td> --}}
                    <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <a href="" target="_blank"> <button class="btn btn-success btn-sm rounded-0"
                                        type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></button></a>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip"
                                    data-placement="top" title="Delete"><i class="fa fa-trash fs-6"></i></button>
                            </li>
                        </ul>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
@endsection
