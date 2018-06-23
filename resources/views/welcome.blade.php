<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Google Chart</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChartLine);
        google.charts.setOnLoadCallback(drawChartPie);
        function drawChartLine(date) {
            $.ajax({
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                type:'post',
                data: { 'tanggal': date },
                url:"{{url('getItemByDate')}}",
                success: function(data){
                    console.log(data)
                    var data = google.visualization.arrayToDataTable(data);
                    var options = {
                        title: 'Item Chart',
                        curveType: 'function',
                        legend: { position: 'bottom' }
                    };
                    var chart = new google.visualization.LineChart(document.getElementById('linechart'));
                    chart.draw(data, options);
                }
            })
        }
        function drawChartPie(date) {
            $.ajax({
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                type:'post',
                data: { 'tanggal': date },
                url:"{{url('getItemByDate')}}",
                success: function(data){
                    console.log(data)
                    var data = google.visualization.arrayToDataTable(data);
                    var options = {
                        title: 'Item Chart',
                        curveType: 'function',
                        legend: { position: 'bottom' }
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
                    chart.draw(data, options);
                }
            })
        }
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title" style="padding:12px 0px;font-size:25px;"><strong>Google Chart Example</strong></h3>
                    </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                    
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ Session::get('error') }}
                                    </div>
                                @endif
                                <form class="form-horizontal" action="{{url('item')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="import_file" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <table id="tableItem" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>No Resi</th>
                                        <th>Service</th>
                                        <th>Tujuan</th>
                                        <th>Pengirim</th>
                                        <th>Penerima</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemTable">
                                   
                                </tbody>
                            </table>
                            <form action="">
                                <label for="tanggal"> Masukan Tanggal Penjualan </label>
                                <div class="form-group">
                                    <input id="tanggal" type="date">
                                </div>
                            </form>
                            <div class="col-md-12">
                                <div id="linechart"></div>     
                                <div id="pieChart"></div>                                 
                            </div>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form class="form" id="form-edit-item" action="" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Edit</h4>
                                </div>
                                <div class="modal-body">
                                        <div class="form-group">
                                            <input type="date" name="tanggal" id="tanggal_edit" class="form-control" placeholder="Masukan Tanggal Service">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="service" id="service_edit" class="form-control" placeholder="Masukan Jenis Service">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>

        function editData(id)
        {
            $(".btnEdit").on('click', function(e){
                e.preventDefault();
                let idx = $(this).attr("id")
                var tanggal = $('#tableItem tr').eq(id).find('td').eq(1).html();
                var service = $('#tableItem tr').eq(id).find('td').eq(3).html();
                // console.log(idx, tanggal, service)
                var date = new Date(tanggal);
                var get_date = ''
                var get_month = ''
                var dates = date.getDate().toString();
                if(dates.length > 1){
                    get_date = date.getDate();
                }else{
                    get_date = '0'+date.getDate();
                }

                var months = (date.getMonth()+1).toString();
                console.log(months)
                if(months.length > 1){
                    get_month = date.getMonth()+1;
                }else{
                    get_month = '0'+(date.getMonth()+1);
                }
                var new_date = date.getFullYear()+'-'+get_month+'-'+get_date
                $('#form-edit-item').attr('action','{{url('item')}}'+'/'+idx)
                $('#tanggal_edit').val(new_date);
                $('#service_edit').val(service);
                $("#edit-modal").modal('show')
            })
        }

        function deleteData(id)
        {
            $(".btnDelete").on('click', function(e){
                e.preventDefault()
                // let id = $(this).attr("id")
                swal({
                    title: "Are you sure!",
                    type: "error",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                },
                function() {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "post",
                        url: "{{url('/item')}}"+'/'+id,
                        data: {_method: 'delete'},
                        success: function (data) {
                            fetchData()
                            drawChartLine() 
                            drawChartPie()   
                        }         
                    });
                });
            })
        }
        
        function fetchData()
        {
            $.ajax({
                type:'GET',
                url: "{{url('getitem')}}",
                success: function(data){
                    // var $i = 1;
                    var html = "";
                    // console.log(data)
                    for(let $i=0; $i<data.length ; $i++){
                        html+=
                        '<tr>'+
                            '<td>'+ ($i+1) +'</td>'+
                            '<td>'+ data[$i]['tanggal'] +'</td>'+
                            '<td>'+ data[$i]['no_resi'] +'</td>'+
                            '<td>'+ data[$i]['service'] +'</td>'+
                            '<td>'+ data[$i]['tujuan'] +'</td>'+
                            '<td>'+ data[$i]['pengirim'] +'</td>'+
                            '<td>'+ data[$i]['penerima'] +'</td>'+
                            '<td>'
                                +'<button  onclick=editData("'+ ($i+1) +'") id="'+ data[$i]['id'] +'" class="btnEdit btn btn-primary" style="margin-right: 5px!important">'+'EDIT'+'</button>'
                                +'<button  onclick=deleteData("'+ data[$i]['id'] +'")  class="btnDelete btn btn-warning">'+'DELETE'+'</button>'  
                            +'</td>'+
                        '</tr>';
                    }
                    $('#itemTable').html(html)
                    editData()
                    deleteData()
                }            
            })
        }
        $(document).ready(function(){
            fetchData()
            editData()
            deleteData()
            $('#tanggal').on('change', function (e){
                let date = $(this).val();
                drawChartLine(date) 
                drawChartPie(date)
            });
        })
        
    </script>
    </body>
</html>
