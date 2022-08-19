<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <title>Voucher History</title>
</head>

<body>
    <nav class="navbar bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="emp_index"><i class="fa fa-home" aria-hidden="true"></i> Home Page</a>
            <div class="d-flex">
                <a class="btn btn-light" href="api/logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center"> Voucher History</h1>

        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Voucher Number</th>
                    <th>Voucher Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="v_data"></tbody>
        </table>

        <a href="emp_index" class="btn btn-primary col-sm-1">Go Back</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(window).on('load', function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "api/voucher-details",
                success: function(response) {
                    if (response.success) {
                        let data = '';
                        for (let i = 0; i < response.voucher.length; i++) {
                            data += '<tr> <td> ' + response.voucher[i]['voucher_number'] +
                                ' </td> <td> ' + response.voucher[i]['voucher_date'] + ' </td> <td> ' +
                                response.voucher[i]['amount'] + ' </td> <td> ' + response.voucher[i]['status'] +
                                ' </td> <td> <a href="single-voucher/' +
                                response.voucher[i]['voucher_number'] +
                                '">View Details</a> </td> </tr>';
                        }
                        $('#v_data').append(data);
                    }
                }
            });
        });
    </script>

</body>

</html>
