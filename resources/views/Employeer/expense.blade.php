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

    <title>Generate Voucher</title>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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

    <div class="container-fluid">
        <form id="add_exp_tb">
            @csrf
            <div class="d-flex mb-3 mt-3 row">
                <label for="date" class="col-sm-2 col-form-label">Expense Date</label>
                <div class="col-sm-4">
                    <input class="form-control datepicker" type="date" name="date" id="date">
                </div>
                <label for="description" class="col-sm-2 col-form-label">Expense Description</label>
                <div class="col-sm-4">
                    <input type="text" name="description" id="description" class="form-control">
                </div>
            </div>
            <div class="d-flex mb-3 mt-3 row">
                <label for="currency" class="col-sm-2 col-form-label">Currency Type</label>
                <div class="col-sm-4">
                    <select class="form-select" name="currency" id="currency" aria-label="Default select example">
                    </select>
                </div>
                <label for="dd_cost_center" class="col-sm-2 col-form-label">Cost Center</label>
                <div class="col-sm-4">
                    <select class="form-select" name="dd_cost_center" id="dd_cost_center"
                        aria-label="Default select example">
                    </select>
                </div>
            </div>
            <div class="d-flex mb-3 mt-3 row">
                <label for="exp_amount" class="col-sm-2 col-form-label">Amount</label>
                <div class="col-sm-4">
                    <input type="number" name="exp_amount" id="exp_amount" class="form-control">
                </div>
                <label for="bill" class="col-sm-2 col-form-label">Billable / Non-billable</label>
                <div class="col-sm-4">
                    <select class="form-select" name="bill" id="bill" aria-label="Default select example">
                        <option selected disabled hidden>Billable / Non-billable</option>
                        <option value="1">Billable</option>
                        <option value="0">Non-billable</option>
                    </select>
                </div>
            </div>
            <div class="d-flex mb-3 mt-3 row">
                <label for="comment" class="col-sm-2 col-form-label">Comments</label>
                <div class="col-sm-10">
                    <input type="text" name="comment" id="comment" class="form-control">
                </div>
            </div>
        </form>
        <button class="btn btn-primary" id="save" type="submit">Save</button>
        <a class="btn btn-primary" href="review-voucher" id="review" type="submit">Review Voucher</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        $(window).on('load', function() {
            $.ajax({
                type: "Get",
                url: "api/currency_cost_center",
                success: function(response) {

                    let supervisor_id = [];

                    let curr_name = [],
                        curr_id = [];

                    for (let i = 0; i < response.currencies.length; i++) {
                        let temp = response.currencies[i];
                        curr_name[i] = temp['currency_name'];
                        curr_id[i] = temp['id'];
                    }


                    let curr_dropdown = '<option selected disabled hidden>Select currency type</option> <option value=" ' + curr_id[0] + ' ">' + curr_name[0] +
                        '</option>';

                    for (let j = 1; j < curr_id.length; j++) {
                        curr_dropdown += '<option value=" ' + curr_id[j] + ' ">' + curr_name[j] +
                            '</option>';
                    }


                    let cc_name = [],
                        cc_id = [];

                    for (let i = 0; i < response.cost_center.length; i++) {
                        let temp = response.cost_center[i];
                        cc_name[i] = temp['center_name'];
                        cc_id[i] = temp['id'];
                    }

                    let cc_dropdown = '<option selected disabled hidden>Select cost center type</option> <option value=" ' + cc_id[0] + ' ">' + cc_name[0] + '</option>';

                    for (let j = 1; j < cc_id.length; j++) {
                        cc_dropdown += '<option value=" ' + cc_id[j] + ' ">' + cc_name[j] + '</option>';
                    }

                    $('#currency').html(curr_dropdown);
                    $('#dd_cost_center').html(cc_dropdown);

                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $('#save').on('click', function(e) {
            e.preventDefault();
            // console.log($('#comment').val());
            $.ajax({
                type: "POST",
                url: "api/save_data",
                data: {
                    date: $('#date').val(),
                    description: $('#description').val(),
                    currency: $('#currency').val(),
                    dd_cost_center: $('#dd_cost_center').val(),
                    exp_amount: $('#exp_amount').val(),
                    bill: $('#bill').val(),
                    comment: $('#comment').val()
                },
                success: function(response) {
                    if (response.validation_error) {
                        alert("Please fill all the fields!");
                    }
                    else if (response.success) {
                        alert("Saved!");
                        location.href = 'expense';
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
