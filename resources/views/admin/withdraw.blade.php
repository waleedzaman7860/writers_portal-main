@extends('layouts.admin')
@section('content')

    <head>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    </head>
    <div class="container pt-5 pb-5 text-white fw-bold">
        <h2 class="fs-4">All Profiles</h2>
    </div>
    <div class="container">
        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    {{-- <th class="p-1" scope="col">ID</th> --}}
                    <th class="p-1" scope="col">UserName</th>
                    <th class="p-1" scope="col">Email</th>
                    <th class="p-1" scope="col">Withdraw Ammount</th>
                    <th class="p-1" scope="col">BEP Wallet Address</th>
                    <th class="p-1" scope="col">Status</th>
                    <th class="p-1" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($withdraw as $item)
                    <tr>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->user->email }}</td>
                        <td>{{ $item->withdraw_amount }}</td>
                        <td>{{ $item->bep_wallet_address }}</td>
                        <td>{{ $item->status }}</td>
                        @if ($item->status == 'pending')
                            <td>
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                        <form method="GET"
                                            action="{{ route('admin.withdraw_change_status', $item->id) }}">
                                            @csrf
                                            <button class="btn btn-danger btn-sm rounded-0 withdraw_change_status"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                                InActive
                                            </button>
                                        </form>
                                    </li>

                                    <li class="list-inline-item">
                                        <form method="POST" action="{{ route('admin.delete_withdraw', $item->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">

                                            <button class="btn btn-danger btn-sm rounded-0 delete_withdraw_show_confirm"
                                                type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                    </li>
                                </ul>



                            </td>
                        @else
                            <td>
                                <li class="list-inline-item">


                                    <form method="GET" action="{{ route('admin.withdraw_change_status', $item->id) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm rounded-0 withdraw_change_status"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                            Active
                                        </button>
                                    </form>


                                </li>

                                <li class="list-inline-item">
                                    <form method="POST" action="{{ route('admin.delete_withdraw', $item->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">

                                        <button class="btn btn-danger btn-sm rounded-0 delete_withdraw_show_confirm"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i>
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
    <div style="text-align:right; ">
        {{-- {{ $article->links() }} --}}

    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

    {{-- DELETE_REQ_SCRIPT_START --}}
    <script type="text/javascript">
        $('.delete_withdraw_show_confirm').click(function(event) {
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
        $('.withdraw_change_status').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to change the status?`,
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
