<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Print Voucher</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(window).on('load', function() {
            $.ajax({
                type: "GET",
                url: "api/review_details",
                success: function (response) {
                    let exp = ''

                    for (let i = 0; i < response.expense.length; i++) {
                        exp += '<tr> <td>'+ response.expense[i]['id'] +'</td> '
                            + '<td>'+ response.expense[i]['expense_description'] +'</td>  '
                            + '<td>'+ response.expense[i]['expense_date'] +'</td>  '
                            + '<td>'+ response.expense[i]['amount'] +'</td>  '
                            + '<td>'+ response.expense[i]['bill'] +'</td>  </tr>';
                    }

                    $('.container').append('<div class="row"> <p> <b>Voucher Number:</b> '+response.voucher_number+'</p>'
                    + '<p> <b>Employeer Name:</b> '+response.employee_name+'</p>'
                    + '<p> <b>Voucher Date:</b> '+response.voucher['voucher_date']+'</p>'
                    + '<table class="table table-striped"> <thead> <tr> <th>S.No</th> <th>Description</th> <th>Date</th> <th>Amount</th> <th>Billable / Non-billable</th> </tr> </thead>'
                    + '<tbody> ' + exp + '</tbody> </table>'
                    + '<p> <b>Advance Payment:</b> '+response.voucher['advance_payment']+'</p>'
                    + '<p> <b>Total Amount:</b> '+response.voucher['amount']+'</p>'
                    + '</div>'
                    + '');
                }, 
                error: function (err) { 
                    console.log(err);
                }
            });
        });
    </script>
    
</body>

</html>
