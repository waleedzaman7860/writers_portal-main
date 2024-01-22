@extends('layouts.admin')
@section('content')

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
                    <th class="p-1" scope="col">Referral User</th>
                    <th class="p-1" scope="col">User</th>
                    <th class="p-1" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($referral as $item)
                    <tr>
                        <td>{{ $item->referralRelation->email }}</td>
                        <td>{{ $item->userRelation->email }}</td>
                        <td></td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
    {{-- <div style="text-align:right; ">
        {{ $article->links() }}

    </div> --}}



    {{-- DELETE_REQ_SCRIPT_START --}}
    <script type="text/javascript">
        $('.delete_article_show_confirm').click(function(event) {
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




    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                sort: false,
            });
        });
    </script>
@endsection
