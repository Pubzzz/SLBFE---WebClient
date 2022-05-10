<?php

$title = "Make a Compliant";
include 'include/header.php';

?>


<div class="row my-5 g-0">
    <div class="col-md-6 col-sm-12 mx-auto bg-white rounded-3 shadow px-5">
        <h2 class="fw-bolder text-center my-4">Make a Compliant</h2>
        <form id="compliantForm">
            <div class="row my-4 g-1">
                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="firstName" placeholder="John" required>
                        <label for="firstName">First Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="lastName" placeholder="Doe" required>
                        <label for="lastName">Last Name</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-2">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="nic" placeholder="123456789V" required>
                        <label for="nic">NIC</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="contactNo" placeholder="07771234567" required>
                        <label for="contactNo">Contact No</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-2">
                        <input type="text" class="form-control" id="reason" placeholder="Lorem Ipsum" required>
                        <label for="reason">Reason</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-2">
                        <textarea class="form-control" placeholder="Leave a comment here" id="message" style="height: 120px" required></textarea>
                        <label for="message">Message</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-dark" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row p-4" id="complaintSuccess">

            <div class="col-12 mx-auto text-center">
                <h3 class="text-success">Your complaint has been received</h3>
                <p>You can track your complaint using your complaint id <span class="fs-5 fw-bold" id="complaintId"></span></p>
            </div>
        </div>
    </div>
</div>

<script>
    $("#complaintSuccess").hide();

    var base_path = "http://127.0.0.1:8000/";
    var url = base_path + "api/v1/compliant";

    $(document).ready(function() {
        $("form").submit(function(event) {
            var formData = {
                firstName: $("#firstName").val(),
                lastName: $("#lastName").val(),
                email: $("#email").val(),
                nic: $("#nic").val(),
                contactNo: $("#contactNo").val(),
                reason: $("#reason").val(),
                message: $("#message").val(),
            };

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                encode: true,

            }).done(function(data) {
                $("#compliantForm").hide();
                $("#complaintId").append(data.complaint_id);
                $("#complaintSuccess").show();
            });

            event.preventDefault();
        });
    });
</script>

<?php include 'include/footer.php'; ?>