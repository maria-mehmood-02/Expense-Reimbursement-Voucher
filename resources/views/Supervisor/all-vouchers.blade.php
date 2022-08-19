<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <title>Generate Report</title>
</head>

<body>
    <nav class="navbar bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="sup_index"><i class="fa fa-home" aria-hidden="true"></i> Home Page</a>
            <div class="d-flex">
                <a class="btn btn-light" href="api/logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container text-center">
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Voucher Number</th>
                    <th>Employee Email</th>
                    <th>Voucher Date</th>
                    <th>Voucher Description</th>
                    <th>Amount</th>
                    <th>Advance Payment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="all-expenses-details" class="text-left"></tbody>
        </table>

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
                url: "/api/all-voucher-details",
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        // console.log(response.data);
                        let voucher_data = '';

                        for (let i = 0; i < response.data.length; i++) {
                            voucher_data += '<tr>' +
                                '<td> ' + response.data[i]['voucher_number'] + ' </td>' +
                                '<td> ' + response.data[i]['emp_email'] + ' </td>' +
                                '<td> ' + response.data[i]['voucher_date'] + ' </td>' +
                                '<td> ' + response.data[i]['voucher_description'] + ' </td>' +
                                '<td> ' + response.data[i]['amount'] + ' </td>' +
                                '<td> ' + response.data[i]['advance_payment'] + ' </td>' +
                                '<td> ' + response.data[i]['status'] + ' </td>' +
                                '</tr>';
                        }

                        $('#all-expenses-details').html(voucher_data);

                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
    </script>

</body>

</html>
