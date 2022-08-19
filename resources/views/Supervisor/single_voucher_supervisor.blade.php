<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <title>Single Voucher Details</title>
</head>

<body>
    <nav class="navbar bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../sup_index"><i class="fa fa-home" aria-hidden="true"></i> Home Page</a>
            <div class="d-flex">
                <a class="btn btn-light" href="../../api/logout">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center">Single Voucher Details</h1>

        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Expense Date</th>
                    <th>Expense Description</th>
                    <th>Currency</th>
                    <th>Cost Center</th>
                    <th>Amount</th>
                    <th>Bill</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody id="expense_detail"></tbody>
        </table>
        <button type="button" id="approve" class="btn btn-primary">Approve</button>
        <button type="button" id="reject" class="btn btn-danger">Reject</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(window).on('load', function(e) {
            e.preventDefault();
            var url = $(location).attr("href");
            var voucher_number = url.substring(url.lastIndexOf('/') + 1);
            // alert(voucher_number);
                $.ajax({
                type: "GET",
                url: "/api/single-voucher-data/" + voucher_number,
                success: function (response) {
                    // console.log(response);
                    if (response.success) {
                        // console.log(response.data);

                        let details = '';
                        
                        let curr_name = [];

                        for (let i = 0; i < response.cost_currency.length; i++) {
                            curr_name[i] = response.cost_currency[i]['currency_name'];
                        }

                        let cc_name = [];

                        for (let i = 0; i < response.cost_center.length; i++) {
                            cc_name[i] = response.cost_center[i]['center_name'];
                        }

                        for (let i = 0; i < response.data.length; i++) {
                            details += '<tr>'
                                + '<td> ' + response.data[i]['expense_date'] + ' </td>'
                                + '<td> ' + response.data[i]['expense_description'] + ' </td>'
                                + '<td> ' + curr_name[i] + ' </td>'
                                + '<td> ' + cc_name[i] + ' </td>'
                                + '<td> ' + response.data[i]['amount'] + ' </td>'
                                + '<td> ' + response.data[i]['bill'] + ' </td>'
                                + '<td> ' + response.data[i]['comments'] + ' </td>'
                                + '</tr>';
                        }

                        $('#expense_detail').html(details);
                    }
                },
                error: function (err) { 
                    console.log(err);
                }
            });
        });
        $('#approve').on('click', function (e) {
            e.preventDefault();
            var url = $(location).attr("href");
            var voucher_number = url.substring(url.lastIndexOf('/') + 1);
            $.ajax({
                type: "PUT",
                url: "/api/approve-voucher/" + voucher_number,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        alert('Voucher approved!');
                        location.href = '../view_vouchers';
                    }
                },
                error: function (err) { 
                    console.log(err);
                }
            });
        });
        $('#reject').on('click', function (e) {
            e.preventDefault();
            var url = $(location).attr("href");
            var voucher_number = url.substring(url.lastIndexOf('/') + 1);
            $.ajax({
                type: "PUT",
                url: "/api/reject-voucher/" + voucher_number,
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        alert('Voucher rejected!');
                        location.href = '../view_vouchers';
                    }
                },
                error: function (err) { 
                    console.log(err);
                }
            });
        });
    </script>
</body>

</html>
