<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="border-primary">
<?php if($_settings->userdata('type') == 1): ?>
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-th-list"></i></span>
            <div class="info-box-content">
            <span class="info-box-text">Total Lead Sources</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `source_list` where delete_flag= 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-stream"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Leads</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `lead_list` where `in_opportunity` = 0 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-maroon elevation-1"><i class="fas fa-circle"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Opportunities</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `lead_list` where `in_opportunity` = 1 ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-users-cog"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Sysetm Users</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `users` ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>

<?php else: ?>
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-stream"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Assigned Leads</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `lead_list` where `in_opportunity` = 0 and assigned_to = '{$_settings->userdata('id')}' ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-maroon elevation-1"><i class="fas fa-circle"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Assigned Opportunities</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `lead_list` where `in_opportunity` = 1 and assigned_to = '{$_settings->userdata('id')}' ")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<?php endif; ?>

