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
                <a class="btn btn-light" href="/api/logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container text-center">
        <p class="m-auto" id="emp-email"><b>Employee Email Address: </b></p>
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Voucher Number</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody id="single-emp"></tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(window).on('load', function (e) {
            e.preventDefault();
            var url = $(location).attr("href");
            var email = url.substring(url.lastIndexOf('/') + 1);
            $.ajax({
                type: "GET",
                url: "/api/single-emp-voucher-details/" + email,
                success: function (response) {
                    // console.log(response);
                    if (response.success) {

                        $('#emp-email').append(email);

                        let single_emp = '';
                        
                        for (let i = 0; i < response.data.length; i++) {
                            single_emp += '<tr>'
                                        + '<td> ' + response.data[i]['voucher_number'] + '</td>'
                                        + '<td> ' + response.data[i]['amount'] + '</td>'
                                        + '<td> ' + response.data[i]['status'] + '</td>'
                                        + '</tr>';
                        }

                        $('#single-emp').html(single_emp);

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