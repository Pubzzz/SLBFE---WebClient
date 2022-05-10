<?php

$title = "Track Compliant";
include 'include/header.php';

?>

<div class="row mt-4 mb-5 g-0">

    <!-- Check Complaint Status Form Starts -->
    <div class="compaint-form col-md-4 mx-auto bg-white rounded-3 shadow">
        <h2 class="fw-bolder text-center my-4">Check Complaint Status</h2>
        <form class="mb-5 mx-4">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="compliantId" placeholder="123365" required>
                <label for="compliantId">Complaint ID</label>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-dark" id="submit" type="button">Submit</button>
            </div>
        </form>
    </div>
    <!-- Check Complaint Status Form Ends -->

    <!-- Check Complaint Status Starts -->
    <div class="compliant-status">
        <div class="col-md-6 mx-auto bg-white rounded-3 shadow pt-2 pb-4 px-5">
            <h2 class="fw-bolder text-center my-4">Compliant <span class="font-monospace text-danger fs-3" id="compliantResponseId">#</span></h2>
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 fw-bold">
                            Name
                        </div>
                        <div class="col-md-8 col-sm-6" id="name">

                        </div>
                        <div class="col-md-4 col-sm-6 fw-bold">
                            Email
                        </div>
                        <div class="col-md-8 col-sm-6" id="email">
                        </div>
                        <div class="col-md-4 col-sm-6 fw-bold ">
                            Date
                        </div>
                        <div class="col-md-8 col-sm-6" id="createdDate">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 fw-bold">
                            NIC
                        </div>
                        <div class="col-md-8 col-sm-6" id="nic">
                        </div>
                        <div class="col-md-4 col-sm-6 fw-bold">
                            Contact
                        </div>
                        <div class="col-md-8 col-sm-6" id="contactNo">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-2 fw-bold">
                    Reason
                </div>
                <div class="col-md-10" id="reason">
                </div>
            </div>

            <div class="row mt-2">
                <h6 class="fw-bold">Description</h6>
                <p class="text-wrap" id="compliantDescription"></p>
            </div>

            <hr>
            <h5 class="fw-bold mb-2">Status</h5>
            <div class="row px-4" id="noStatus"></div>
            <div class="row px-4" id="statusTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Comments</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Check Complaint Status Starts -->

</div>

<script>
    $(".compliant-status").hide();
    var base_path = "http://127.0.0.1:8000/";


    $("#submit").click(function() {
        $(".compaint-form").hide();

        var compliantId = $("#compliantId").val();
        var url = base_path + "api/v1/compliant/" + compliantId;


        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(response) {
                let compliant = response.complaint;
                let compliantStatus = response.complaintStatus;

                let createdDate = new Date(compliant.created_at).toLocaleDateString();

                $("#compliantResponseId").append(compliant.id);
                $("#name").append(compliant.first_name + " " + compliant.last_name);
                $("#email").append(compliant.email);
                $("#createdDate").append(createdDate);
                $("#nic").append(compliant.nic);
                $("#contactNo").append(compliant.contact_no);
                $("#reason").append(compliant.reason);
                $("#compliantDescription").append(compliant.message);

                if (compliantStatus.length == 0) {
                    $("#statusTable").hide();
                    $("#noStatus").append("No Status");
                } else {
                    $.each(compliantStatus, function(key, val) {
                        let statusCreatedDate = new Date(val.created_at).toLocaleDateString();
                        var tableRow = `<tr>
                            <td>${statusCreatedDate}</td>
                            <td class="text-success">${val.status}</td>
                            <td>${val.comments}</td>
                        </tr>`;

                        $("#tableBody").append(tableRow);
                    })
                }

                $(".compliant-status").show();

            }
        });
    });
</script>

<?php include 'include/footer.php'; ?>