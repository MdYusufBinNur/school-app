@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @if(Session::get('success'))
                        <div class="alert alert-success">
                            <button type="button" aria-hidden="true" data-notify="dismiss" class="close">×</button>
                            <span><b> Success - </b> {{ Session::get('success') }}</span>
                        </div>
                    @endif

                    @if(Session::get('error'))
                        <div class="alert alert-warning">
                            <button type="button" aria-hidden="true" data-notify="dismiss" class="close">×</button>
                            <span><b> Success - </b> {{ Session::get('error') }}</span>
                        </div>
                    @endif

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="title">ADDRESS LIST</h4>
                    <br>

                    <div class="card">
                        <div class="card-content">
                            <div class="toolbar">
                                <!--Here you can write extra buttons/actions for the toolbar-->
                            </div>
                            <div class="fresh-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th> EIN NO</th>
                                        <th> SCHOOL CODE</th>
                                        <th> COLLEGE CODE</th>
                                        <th> PHONE</th>
                                        <th> ADDRESS</th>
                                        <th class="disabled-sorting">Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(!empty($all_addresses))
                                        @foreach($all_addresses as $all_address)
                                            <tr>
                                                <td>{!! $all_address->ein_no !!}</td>
                                                <td>{!! $all_address->school_code !!}</td>
                                                <td>{!! $all_address->college_code !!}</td>
                                                <td>{!! $all_address->phone !!}</td>
                                                <td>{!! $all_address->address !!}</td>

                                                <td>

                                                    <a href="#" class="btn btn-simple btn-warning btn-icon" data-toggle="modal" onclick="get_address_data({{$all_address->id}})" data-target="#BrandModal"><i class="ti-pencil-alt"></i></a>

                                                    <a href="" class="btn btn-simple btn-info btn-icon del_brand"  id="del_brand_item" onclick="deleteAddress({{ $all_address->id }})"><i class="ti-trash"></i></a>

                                                </td>
                                            </tr>

                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!--  end card  -->
                </div> <!-- end col-md-12 -->

            </div> <!-- end row -->

        </div>
    </div>

    <div class="modal fade" id="BrandModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Category Information</h4>
                </div>
                <form action="{{ url('/update_address_info') }}" method="post">

                    @csrf()
                    <div class="modal-body">
                        <div class="row" style="padding: 10px">

                            <input type="text" id="address_id" hidden name="address_id">

                            <div class="form-group">
                                <label class="control-label" for="category_info">
                                    EIN NO<star>*</star>
                                </label>
                                <label for="category_name"></label><input class="form-control" type="text" name="ein_no" id="ein_no" required/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="category_info">
                                    SCHOOL CODE
                                </label>
                                <label for="category_name"></label><input class="form-control" type="text" name="school_code" id="school_code" />
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="category_info">
                                    COLLEGE CODE
                                </label>
                                <label for="category_name"></label><input class="form-control" type="text" name="college_code" id="college_code" />
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="phone">PHONE</label>
                                <input class="form-control" name="phone" id="phone" type="text" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="address">ADDRESS</label>
                                <input class="form-control" type="text" value="" name="address" id="new_address" />
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" >Update</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>

    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#datatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                    class: 'navbar-form navbar-left navbar-search-form'
                }
            });


            var table = $('#datatables').DataTable();
            // Edit record
            table.on( 'click', '.edit', function () {
                $tr = $(this).closest('tr');

                var data = table.row($tr).data();
                alert( 'You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.' );
            } );

            // Delete a record
            table.on( 'click', '.remove', function (e) {
                $tr = $(this).closest('tr');
                table.row($tr).remove().draw();
                e.preventDefault();
            } );

            //Like record
            table.on( 'click', '.like', function () {
                alert('You clicked on Like button');
            });

        });
    </script>
    {{--<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>--}}
@endsection

