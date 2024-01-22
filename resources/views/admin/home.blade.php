@extends('layouts.admin')

@section('content')
    {{-- All Profiles --}}

    <head>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    </head>


    <div class="container pt-5 pb-5 text-white fw-bold">

        <h2>All Profiles</h2>


        <head>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        </head>
        <div class="container pt-5 pb-5 fw-bold">
            <h2 class="fs-4">All Profiles</h2>
        </div>
        <div class="container">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        {{-- <th class="p-1" scope="col">ID</th> --}}
                        <th class="p-1" scope="col">UserName</th>
                        <th class="p-1" scope="col">Email</th>
                        <th class="p-1" scope="col">Deposite Slip</th>
                        <th class="p-1" scope="col">Referral Code</th>
                        <th class="p-1" scope="col">Referral Earning</th>
                        <th class="p-1" scope="col">status</th>
                        <th class="p-1" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            {{-- <td scope="row">1</td> --}}
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href="{{ Storage::url($item->deposite_slip) }}" download="{{ $item->deposite_slip }}">
                                    <img src="{{ Storage::url($item->deposite_slip) }}" height="100px" alt="">
                                    <p>Download</p>
                                </a>
                            </td>
                            <td>{{ $item->writer_referal_code }}</td>
                            <td>{{ $item->referral_earning }}</td>

                            <td>{{ $item->status }}</td>
                            @if ($item->status == 'pending')
                                <td>
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <form method="GET" action="{{ route('admin.change_status', $item->id) }}">
                                                @csrf
                                                <button class="btn btn-danger btn-sm rounded-0 admin_change_status"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Edit">
                                                    InActive
                                                </button>
                                            </form>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="btn btn-success btn-sm rounded-0"
                                                href="{{ route('admin.update_profile', $item->id) }}" data-toggle="modal"
                                                data-target="#myModalUserUpdate" data-article-id="{{ $item->id }}"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i>
                                            </a>
                                        </li>

                                        <li class="list-inline-item">
                                            <form method="POST" action="{{ route('admin.delete', $item->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button class="btn btn-danger btn-sm rounded-0 show_confirm" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash fs-6"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            @else
                                <td>
                                    <li class="list-inline-item">


                                        {{-- <a href="{{ route('admin.change_status', $item->id) }}">Active</a> --}}
                                        <a href="#">
                                            <button class="btn btn-success btn-sm rounded-0" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit">
                                                Active
                                            </button>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="btn btn-success btn-sm rounded-0"
                                            href="{{ route('admin.update_profile', $item->id) }}" data-toggle="modal"
                                            data-target="#myModalUserUpdate" data-article-id="{{ $item->id }}"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <form method="POST" action="{{ route('admin.delete', $item->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">

                                            <button class="btn btn-danger btn-sm rounded-0 show_confirm" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash fs-6"></i>
                                            </button>
                                        </form>
                                    </li>
                                </td>
                            @endif
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>









        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

        {{-- DELETE_REQ_SCRIPT_START --}}
        <script type="text/javascript">
            $('.show_confirm').click(function(event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                swal({
                        title: `Are you sure you want to delete this record?`,
                        text: "If you delete this, it will be gone forever.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
        </script>
        {{-- DELETE_REQ_SCRIPT_END --}}



        {{-- Admin_Change_Status_SCRIPT_START --}}
        <script type="text/javascript">
            $('.admin_change_status').click(function(event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                swal({
                        title: `Are you sure you want to active this user?`,
                        //  text: "If you delete this, it will be gone forever.",
                        icon: "warning",
                        buttons: true,
                        successMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
        </script>
        {{-- Admin_Change_Status_SCRIPT_END --}}


        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    sort: false,
                });
            });
        </script>
    @endsection
