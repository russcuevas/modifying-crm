<div class="container-fluid">
    <div class="row">
        <div class="col-4 border"><b>Ref. Code</b></div>
        <div class="col-8 border"><?= isset($code) ? $code : "" ?></div>
        <div class="col-12 border text-center"><b>Client Information</b></div>
        <div class="col-4 border"><b>Name</b></div>
        <div class="col-8 border"><?= isset($fullname) ? $fullname : "" ?></div>
        <div class="col-4 border"><b>Gender</b></div>
        <div class="col-8 border"><?= isset($gender) ? $gender : "" ?></div>
        <div class="col-4 border"><b>Birthday</b></div>
        <div class="col-8 border"><?= isset($dob) ? $dob : "" ?></div>
        <div class="col-4 border"><b>Contact #</b></div>
        <div class="col-8 border"><?= isset($contact) ? $contact : "" ?></div>
        <div class="col-4 border"><b>Email</b></div>
        <div class="col-8 border"><?= isset($email) ? $email : "" ?></div>
        <div class="col-4 border"><b>Address</b></div>
        <div class="col-8 border"><?= isset($address) ? $address : "" ?></div>
        <div class="col-4 border"><b>Other Information</b></div>
        <div class="col-8 border"><?= isset($other_info) ? $other_info : "" ?></div>
        <div class="col-12 border text-center"><b>Client Information</b></div>
        <div class="col-4 border"><b>Instersted In</b></div>
        <div class="col-8 border"><?= isset($interested_in) ? $interested_in : "" ?></div>
        <div class="col-4 border"><b>Lead Source</b></div>
        <div class="col-8 border"><?= isset($source) ? $source : "" ?></div>
        <div class="col-4 border"><b>Assigned To</b></div>
        <div class="col-8 border"><?= isset($user_arr[$assigned_to]) ? ucwords($user_arr[$assigned_to]) : "Not Assigned yet." ?></div>
        <div class="col-4 border"><b>Remarks</b></div>
        <div class="col-8 border"><?= isset($remarks) ? $remarks : "" ?></div>
        <div class="col-4 border"><b>Created By</b></div>
        <div class="col-8 border"><?= isset($user_arr[$user_id]) ? ucwords($user_arr[$user_id]) : "" ?></div>
        <div class="col-4 border"><b>Date Created</b></div>
        <div class="col-8 border"><?= isset($date_created) ? date("M d, Y h:i A",strtotime($date_created)) : "" ?></div>
        <div class="col-4 border"><b>Last Update</b></div>
        <div class="col-8 border"><?= isset($date_updated) ? date("M d, Y h:i A",strtotime($date_updated)) : "" ?></div>
        <div class="col-4 border"><b>Status</b></div>
        <div class="col-8 border">
            <?php 
            $status = isset($status) ? $status : '';
                switch($status){
                    case 0:
                        echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill">New/Prospect</span>';
                        break;
                    case 1:
                        echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">Open</span>';
                        break;
                    case 2:
                        echo '<span class="badge badge-primary bg-gradient-primary px-3 rounded-pill">Working</span>';
                        break;
                    case 3:
                        echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Not a Target</span>';
                        break;
                    case 4:
                        echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Disqualified</span>';
                        break;
                    case 5:
                        echo '<span class="badge badge-info bg-gradient-info px-3 rounded-pill">Nurture</span>';
                        break;
                    case 6:
                        echo '<span class="badge badge-success bg-gradient-success px-3 rounded-pill">Opportunity Created</span>';
                        break;
                    case 7:
                        echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Opportunity Lost</span>';
                        break;
                    case 8:
                        echo '<span class="badge badge-danger bg-gradient-danger px-3 rounded-pill">Inactive</span>';
                        break;
                    default:
                        echo '<span class="badge badge-light bg-gradient-light border px-3 rounded-pill">N/A</span>';
                            break;
                }
            ?>
            <span class="ml-3">
                <a href="javascript:void(0)" id="update_lead_status">Update Status</a>
            </span>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#update_lead_status').click(function(){
            uni_modal("Update Lead's Status","view_lead/update_lead_status.php?id=<?= isset($id) ? $id : '' ?>")
        })
    })
</script>