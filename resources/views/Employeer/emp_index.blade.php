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

    <title>Employeer | Home Page</title>
    
    <style>
        textarea {
            resize: none;
        }
        #voucher_details {
            visibility: hidden;
        }
    </style>
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
        <h1 class="mt-5 text-center">Hello, there!!</h1>
        <button type="button" id="gen_voucher" class="btn btn-primary mb-5">Generate Voucher</button>
        <a href="history-voucher" class="btn btn-primary mb-5">History</a>
        <div id="voucher_details" class="col-md-12 col-md-offset-4">
            <div class="mb-3 mt-3 row">
                <div class="d-flex mb-3">
                    <label for="voucher_description" class="form-label col-md-2">Voucher Description</label>
                    <textarea class="form-control" name="voucher_description" id="voucher_description" rows="4"></textarea>
                </div>
            </div>
            <a id="expense" class="btn btn-primary col-md-2"><i class="fa fa-plus" aria-hidden="true"></i>Add
                Expense</a>
        </div>
    </div>


        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script>
            $('#gen_voucher').on('click', function () {
                $('#voucher_details').css('visibility', 'visible');
            });
            $('#expense').on('click', function (e) { 
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "api/generate_voucher",
                    data: {
                        voucher_description : $('#voucher_description').val()
                    },
                    // dataType: "dataType",
                    success: function (response) {
                        if (response.validation_error) {
                            alert("Please fill all the fields!");
                        } else if (response.navigate == true) {
                            location.href = 'expense';
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
