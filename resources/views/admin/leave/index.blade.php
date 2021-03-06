@extends('admin.layout.master')

@section('content')

    <div id="main-wrapper">
    @include('admin.includes.sidebar')
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Manage Pengajuan Cuti</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><a href="{{route('leave')}}">Pengajuan Cuti</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{route('leave.search')}}" method="GET" class="form-horizontal">
                                <div class="card-body">
                                    <h4 class="card-title">Cari</h4>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">berdasarkan jenis cuti</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="search" class="form-control" id="fname" placeholder="Jenis Cuti">
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success">Cari</button>
                                        <a href="{{route('leave')}}" class="btn btn-md btn-danger">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        @can('isEmployee')
                        <a class="btn btn-lg btn-dark mb-4" href="{{route('leave.create')}}">Ajukan Cuti</a>
                        @endcan
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Daftar Cuti</h5>
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Nama Karyawan</th>
                                            <th>Catatan Cuti</th>
                                            <th>Tanggal Awal</th>
                                            <th>Tanggal Akhir</th>
                                            <th>Jumlah Cuti</th>
                                            <th>Keterangan Cuti</th>
                                            {{-- <th>Leave type offer</th> --}}
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($leaves as $leave)
                                            <tr>
                                                <td>{{$loop -> index+1 }}</td>
                                                <td>{{$leave->users->username }}</td>
                                                <td>{{$leave->leave_type}}</td>
                                                <td>{{$leave->date_from->isoFormat("dddd, MMMM Do YYYY")}}</td>
                                                <td>{{Carbon::parse($leave->date_to)->isoFormat("dddd, MMMM Do YYYY")}}</td>
                                                <td>{{$leave->days}}</td>
                                                <td>{{$leave->reason}}</td>
                                                {{-- <td> --}}
                                                    @if(Auth::user()->role=='admin')
                                                        {{--{{$leave->is_approved}}--}}
                                                        @if($leave->leave_type_offer==0)
                                                        {{-- <div class="card-body">
                                                            <div class="form-group row">
                                                                <div class="col-sm-5">
                                                                    <form id="{{$leave->id}}" action="{{route('leave.paid',$leave->id)}}" method="POST">
                                                                        @csrf
                                                                        {{--<button type="button" onclick="approveLeave({{$leave->id}})" class="btn btn-sm btn-cyan" name="approve" value="1">Approve</button>--}}
                                                                        {{-- <button type="submit" onclick="return confirm('Are you sure want to paid for leave?')" class="btn btn-sm btn-cyan" name="paid" value="1">Paid</button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <form id="{{$leave->id}}" action="{{route('leave.paid',$leave->id)}}" method="POST">
                                                                        @csrf
                                                                        {{--<button type="button" onclick="rejectLeave({{$leave->id}})" class="btn btn-sm btn-danger" name="approve" value="2">Reject</button>--}}
                                                                        {{-- <button type="submit" onclick="return confirm('Are you sure want to paid for leave?')" class="btn btn-sm btn-danger" name="paid" value="2">Unpaid</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        {{-- @elseif($leave->leave_type_offer==1)
                                                            <form action="{{route('leave.paid',$leave->id)}}" method="POST">
                                                                @csrf
                                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure want to unpaid for leave?')" type="submit" name="paid" value="2">Unpaid</button>
                                                            </form>
                                                        @else
                                                            <form action="{{route('leave.paid',$leave->id)}}" method="POST">
                                                                @csrf
                                                                <button class="btn btn-sm btn-cyan" onclick="return confirm('Are you sure want to piad for leave?')" type="submit" name="paid" value="1">Paid</button>
                                                            </form>
                                                        @endif --}}
                                                        @endif

                                                        {{--<a href="{{route('leave.approve',$leave->id)}}" class="btn btn-sm btn-cyan">Approve</a>--}}
                                                        {{--<a href="{{route('leave.pending',$leave->id)}}" class="btn btn-sm btn-warning">Pending</a>--}}
                                                        {{--<a href="{{route('leave.reject',$leave->id)}}" class="btn btn-sm btn-danger">Reject</a>--}}
                                                    @else
                                                        {{-- @if($leave->leave_type_offer==0)
                                                            <span class="badge badge-pill badge-warning">Pending</span>
                                                        @elseif($leave->leave_type_offer==1)
                                                            <span class="badge badge-pill badge-success">Paid</span>
                                                        @else
                                                            <span class="badge badge-pill badge-danger">Unpaid</span>
                                                        @endif --}}
                                                    @endif
                                                {{-- </td> --}}
                                                        <td>
                                                            @if(Auth::user()->role=='admin')
                                                            {{--{{$leave->is_approved}}--}}
                                                            @if($leave->is_approved==0)
                                                            <div class="card-body">
                                                                <div class="btn-group" role="group" aria-label="Basic example">

                                                                        <form id="approve-leave-{{$leave->id}}" action="{{route('leave.approve',$leave->id)}}" method="POST">
                                                                            @csrf
                                                                            {{--<button type="button" onclick="approveLeave({{$leave->id}})" class="btn btn-sm btn-cyan" name="approve" value="1">Approve</button>--}}
                                                                            <button type="submit" onclick="return confirm('Are you sure want to approve leave?')" class="btn btn-sm btn-cyan" name="approve" value="1">Approve</button>
                                                                        </form>
                                                                        <form id="reject-leave-{{$leave->id}}" action="{{route('leave.approve',$leave->id)}}" method="POST">
                                                                            @csrf
                                                                            {{--<button type="button" onclick="rejectLeave({{$leave->id}})" class="btn btn-sm btn-danger" name="approve" value="2">Reject</button>--}}
                                                                            <button type="submit" onclick="return confirm('Are you sure want to reject leave?')" class="btn btn-sm btn-danger" name="approve" value="2">Reject</button>
                                                                        </form>
                                                                </div>
                                                            </div>
                                                        @elseif($leave->is_approved==1)
                                                            {{-- <div class="card-body"> --}}
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                        <a href="{{ route('invoice.print', $leave->id) }}" class="btn btn-sm btn-warning">Print</a>
                                                                        {{-- <form action="{{route('leave.approve',$leave->id)}}" method="POST">
                                                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure want to reject leave?')" type="submit" name="approve" value="2">Reject</button>
                                                                            @csrf
                                                                        </form> --}}
                                                                </div>
                                                            {{-- </div> --}}
                                                            @else
                                                                <form action="{{route('leave.approve',$leave->id)}}" method="POST">
                                                                    @csrf
                                                                    <button class="btn btn-sm btn-cyan" onclick="return confirm('Are you sure want to approve leave?')" type="submit" name="approve" value="1">Approve</button>
                                                                </form>
                                                            @endif

                                                                {{--<a href="{{route('leave.approve',$leave->id)}}" class="btn btn-sm btn-cyan">Approve</a>--}}
                                                                {{--<a href="{{route('leave.pending',$leave->id)}}" class="btn btn-sm btn-warning">Pending</a>--}}
                                                                {{--<a href="{{route('leave.reject',$leave->id)}}" class="btn btn-sm btn-danger">Reject</a>--}}
                                                                @else
                                                                @if($leave->is_approved==0)
                                                                    <span class="badge badge-pill badge-warning">Pending</span>
                                                                @elseif($leave->is_approved==1)
                                                                    <span class="badge badge-pill badge-success">Approved</span>
                                                                @else
                                                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                                                @endif
                                                            @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                    {{ $leaves->links() }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <{{--sweetalert box for deleting start--}}
            {{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.8/dist/sweetalert2.all.min.js"></script>--}}

            {{--<script type="text/javascript">--}}
                {{--function rejectLeave(id)--}}

                {{--{--}}
                    {{--const swalWithBootstrapButtons = swal.mixin({--}}
                        {{--confirmButtonClass: 'btn btn-success',--}}
                        {{--cancelButtonClass: 'btn btn-danger',--}}
                        {{--buttonsStyling: false,--}}
                    {{--})--}}

                    {{--swalWithBootstrapButtons({--}}
                        {{--title: 'Are you sure?',--}}
                        {{--text: "You won't be able to do again this!",--}}
                        {{--type: 'warning',--}}
                        {{--showCancelButton: true,--}}
                        {{--confirmButtonText: 'Yes, reject it!',--}}
                        {{--cancelButtonText: 'No, cancel!',--}}
                        {{--reverseButtons: true--}}
                    {{--}).then((result) => {--}}
                        {{--if (result.value) {--}}
                            {{--event.preventDefault();--}}
                            {{--document.getElementById('reject-leave-'+id).submit();--}}
                        {{--} else if (--}}
                            {{--// Read more about handling dismissals--}}
                            {{--result.dismiss === swal.DismissReason.cancel--}}
                        {{--) {--}}
                            {{--swalWithBootstrapButtons(--}}
                                {{--'Cancelled',--}}
                                {{--'You have not cancel yet ! Your are safe :)',--}}
                                {{--'error'--}}
                            {{--)--}}
                        {{--}--}}
                    {{--})--}}
                {{--}--}}

            {{--</script>--}}
            {{--<script type="text/javascript">--}}
                {{--function approveLeave(id)--}}

                {{--{--}}
                    {{--const swalWithBootstrapButtons = swal.mixin({--}}
                        {{--confirmButtonClass: 'btn btn-success',--}}
                        {{--cancelButtonClass: 'btn btn-danger',--}}
                        {{--buttonsStyling: false,--}}
                    {{--})--}}

                    {{--swalWithBootstrapButtons({--}}
                        {{--title: 'Are you sure?',--}}
                        {{--text: "You want to approve leave!",--}}
                        {{--type: 'warning',--}}
                        {{--showCancelButton: true,--}}
                        {{--confirmButtonText: 'Yes, approve leave!',--}}
                        {{--cancelButtonText: 'No, cancel!',--}}
                        {{--reverseButtons: true--}}
                    {{--}).then((result) => {--}}
                        {{--if (result.value) {--}}
                            {{--event.preventDefault();--}}
                            {{--document.getElementById('approve-leave-'+id).submit();--}}
                        {{--} else if (--}}
                            {{--// Read more about handling dismissals--}}
                            {{--result.dismiss === swal.DismissReason.cancel--}}
                        {{--) {--}}
                            {{--swalWithBootstrapButtons(--}}
                                {{--'Cancelled',--}}
                                {{--'You are safe.You can approve later :)',--}}
                                {{--'error'--}}
                            {{--)--}}
                        {{--}--}}
                    {{--})--}}
                {{--}--}}

            {{--</script>--}}
            {{--sweetalert box for deleting end--}}
            <footer class="footer bg-white">
            All Rights Reserved by  <a href="#">Ahmad Aldi Alpian</a>.
            </footer>
        </div>
    </div>

@endsection