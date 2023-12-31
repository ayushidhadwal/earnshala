<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"><i
                            class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('instructor_payouts'); ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('list_of_payouts'); ?></h4>
                <ul class="nav nav-tabs nav-bordered mb-3">
                    <li class="nav-item">
                        <a href="<?php echo site_url('admin/instructor_payout'); ?>" class="nav-link">
                            <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block"><?php echo get_phrase('completed_payouts'); ?></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo site_url('admin/pending_payout'); ?>" class="nav-link active">
                            <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block"><?php echo get_phrase('pending_payouts'); ?></span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="completed-b1">
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="<?php echo site_url('admin/pending_payout'); ?>" class="nav-link active">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Counselling</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo site_url('admin/pending_payout_live_class'); ?>" class="nav-link">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Live Class</span>
                            </a>
                        </li>
                    </ul>
                        <div class="row justify-content-md-center  float-right">
                            
                            <div class="col-xl-12">
                                
                                <form class="form-inline"
                                      action="<?php echo site_url('admin/pending_payout/filter_by_date_range') ?>"
                                      method="get">
                                    <div class="col-xl-12">
                                        <select name="month" id="" class="form-control" required>
                                            <option value="" selected disabled>Select Month</option>
                                            <?php for ($i = 1; $i <= 12; $i++):
                                                if (empty($this->input->get('month'))):
                                                    ?>
                                                    <option value=<?= $i; ?> <?php if ($i == date('m')) {
                                                        echo "selected";
                                                    }; ?>><?= $i ?></option>
                                                <?php else : ?>
                                                    <option value=<?= $i; ?> <?php if ($i == $this->input->get('month')) {
                                                        echo "selected";
                                                    }; ?>><?= $i ?></option>
                                                <?php endif; endfor; ?>
                                        </select>
                                        <select name="year" id="" class="form-control" required>
                                            <option value="" selected disabled>Select Year</option>
                                            <?php
                                            $year = date('Y');
                                            $add = $year - 2012;
                                            $min = 2010 + $add;
                                            $max = $min + 20;
                                            for ($i = $min; $i <= $max; $i++):
                                                if (empty($this->input->get('year'))):
                                                    ?>
                                                    <option value=<?= $i; ?> <?php if ($i == date('Y')) {
                                                        echo "selected";
                                                    }; ?>><?= $i ?></option>
                                                <?php else : ?>
                                                    <option value=<?= $i; ?> <?php if ($i == $this->input->get('year')) {
                                                        echo "selected";
                                                    }; ?>><?= $i ?></option>
                                                <?php endif; endfor; ?>
                                        </select>
                                        <button type="submit" class="btn btn-info" id="submit-button"
                                                onclick="update_date_range();"> <?php echo get_phrase('filter'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive-sm mt-4">
                            <table id="completed-payout" class="table table-striped table-centered mb-0 text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo get_phrase('image'); ?></th>
                                    <th><?php echo get_phrase('instructor'); ?></th>
                                    <th><?php echo get_phrase('payment_type'); ?></th>
                                    <th><?php echo get_phrase('payout_date'); ?></th>
                                    <th><?php echo get_phrase('payout_amount'); ?></th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $totalAmt = 0;
                                foreach ($pending_counselling_payouts as $key => $getData) :
                                    $userData = getUserPaymentData($getData['instructor_id'], 'counselling');

                                    $instructorSum = $this->db->get_where('payment', ['instructor_id' => $getData['instructor_id'], 'course_type' => 'counselling', 'isPaid' => 0])->result();
                                    $total = 0;
                                    foreach ($instructorSum as $getSum) {
                                        $revenue_percentage = $getSum->revenue_percentage;
                                        $adminAmount = ($getSum->amount * $revenue_percentage) / 100;
                                        $total += $adminAmount;
                                    }

                                    $totalAmt += $total;

                                    if ($userData) {
                                        ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('uploads/user_image/' . $userData->image . '.jpg') ?>"
                                                   target="_blank">
                                                    <img src="<?php echo site_url('uploads/user_image/' . $userData->image . '.jpg') ?>"
                                                         alt="" height="50" width="50"
                                                         class="img-fluid rounded-circle img-thumbnail">
                                                </a>
                                            </td>
                                            <td><?= $userData->first_name . ' ' . $userData->last_name ?></td>

                                            <td><?= $userData->payment_type; ?></td>
                                            <td><?= date('d-m-Y', $userData->pdate); ?></td>
                                            <td><?php
                                                echo '₹ ' . $total;
                                                ?>
                                            </td>
                                            <td>
                                                <form action="<?php echo site_url('admin/settlement') ?>" method="post">
                                                    <div>
                                                        <input type="hidden" value="<?= $getData['instructor_id'] ?>"
                                                               name="teacherId">
                                                        <input type="hidden" value="counselling"
                                                                   name="type">
                                                        <input type="hidden" value="<?php
                                                        if (isset($_GET['month'])) {
                                                            echo $_GET['month'];
                                                        } else {
                                                            echo date('m');
                                                        }
                                                        ?>" name="month">
                                                        <input type="hidden" value="<?php
                                                        if (isset($_GET['year'])) {
                                                            echo $_GET['year'];
                                                        } else {
                                                            echo date('Y');
                                                        }
                                                        ?>" name="year">
                                                        <button class="btn nav-link text-white" type="submit">Proceed to
                                                            pay
                                                            amount <?php echo '₹ ' . $total; ?></button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } endforeach; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Grand Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><?php echo '₹ ' . $totalAmt; ?></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        initDataTable(['#pending-payout', '#completed-payout']);
    });

    function update_date_range() {
        var x = $("#selectedValue").html();
        $("#date_range").val(x);
    }
</script>
