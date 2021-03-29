<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- Styles -->
        <style>
          .btn-success.active{
              background-color : #87B87F! important;
              border-radius: 1px;
          }
          .container-header{
              padding-top: 50px;
              padding-left: 40px;
              padding-bottom: 20px;
          }

        </style>
    </head>
    <body>
    <div class="container-header">
    </br>
    </br>
        <div class="container-fluid" style="border:1px solid #cecece;">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nomor Urut</th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1">
                            <input type="text" size="15" id="search_date" placeholder="Search Tanggal">
                        </th> 
                        <th rowspan="1" colspan="1">
                            <input type="text" size="15" id="search_serialNumber" placeholder="Search Nomor urut">
                        </th> 
                    </tr>
                    
                </thead>
                <tbody>
                    @foreach ($data as $datas)
                    <tr>
                        <td>{{$datas->date}}</td>
                        <td>{{$datas->serial_number}}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </br>
    </br>

    <form id="modalFormData" name="modalFormData" class="form-horizontal"> 
        {{ csrf_field() }}   
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">Tanggal Transaksi</span>
        </div>
        <input type="text" class="form-control" name="date" id="datepicker" >
      </div>

      <button type="submit" class="btn btn-success btn-lg active" id="btn-save"><i class="fas fa-save"></i>Simpan Nomor</button>

      </form>
    </div>
        <!--Import jQuery before export.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>


        <!--Data Table-->
        <script type="text/javascript"  src=" https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript"  src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

        <script type="text/javascript">

            var table = $('#example').DataTable();

            $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            });

$('body').on('click', '#btn-save', function (event) {
event.preventDefault()

var date = $("#datepicker").val();

$.ajax({
    url: "{{ route('date.post') }}",
    type: "POST",
    data: {
        date: date,
    },
    dataType: 'json',

    success: function (data) {
    
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Data Tersimpan',
        showConfirmButton: true,
        timer: 2000
    })
    setTimeout(function () {
    location.reload(true);
    }, 1600);
    $('#modalFormData').trigger("reset");
    
    },
    error: function (data) {
        console.log('Error:', data);
        $('#btn-save').html('Tersimpan');
    }
});
});

$("#datepicker").datepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat: 'dd MM yy',
});

$("#search_date").keyup(function () {
    var value = this.value.toLowerCase().trim();

    $("table tr").each(function (index) {
        if (!index) return;
        $(this).find("td").each(function () {
            var id = $(this).text().toLowerCase().trim();
            var not_found = (id.indexOf(value) == -1);
            $(this).closest('tr').toggle(!not_found);
            return not_found;
        });
    });
});

$("#search_serialNumber").keyup(function () {
    var value = this.value.toLowerCase().trim();

    $("table tr").each(function (index) {
        if (!index) return;
        $(this).find("td").each(function () {
            var id = $(this).text().toLowerCase().trim();
            var not_found = (id.indexOf(value) == -1);
            $(this).closest('tr').toggle(!not_found);
            return not_found;
        });
    });
});

        </script>
    </body>
</html>


