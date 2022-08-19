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
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Employee Name</th>
                    <th>Employee Email Address</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody id="emp-details"></tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(window).on('load', function (e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "/api/list-emps",
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        let details = '';

                        for (let i = 0; i < response.data.length; i++) {
                            details += '<tr>'
                                    + '<td> ' + response.data[i]['Name'] + ' </td>'
                                    + '<td> <a href="single-emp/'+response.data[i]['Email Address']+'">' + response.data[i]['Email Address'] + '</a> </td>'
                                    + '<td> ' + response.data[i]['Amount'] + ' </td>'
                                    + '</tr>';
                        }

                        $('#emp-details').html(details);

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