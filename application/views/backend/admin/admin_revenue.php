<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"><i
                            class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('admin_revenue'); ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('admin_revenue'); ?></h4>
                <div class="row justify-content-md-center">
                    <div class="col-xl-6">
                        <form class="form-inline"
                              action="<?php echo site_url('admin/admin_revenue/filter_by_date_range') ?>" method="get">
                            <div class="col-xl-10">
                                <div class="form-group">
                                    <div id="reportrange" class="form-control" data-toggle="date-picker-range"
                                         data-target-display="#selectedValue" data-cancel-class="btn-light"
                                         style="width: 100%;">
                                        <i class="mdi mdi-calendar"></i>&nbsp;
                                        <span id="selectedValue"><?php echo date("F d, Y", $timestamp_start) . " - " . date("F d, Y", $timestamp_end); ?></span>
                                        <i class="mdi mdi-menu-down"></i>
                                    </div>
                                    <input id="date_range" type="hidden" name="date_range"
                                           value="<?php echo date("d F, Y", $timestamp_start) . " - " . date("d F, Y", $timestamp_end); ?>">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <button type="submit" class="btn btn-info" id="submit-button"
                                        onclick="update_date_range();"> <?php echo get_phrase('filter'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive-sm mt-4">
                    <table id="datatable-buttons" class="table table-striped table-centered mb-0 text-center">
                        <thead>
                        <tr>
                            <th>Payment Date</th>
                            <th>Payment Type</th>
                            <th>Detail</th>
                            <th>Total Amount</th>
                            <th>Discount Price</th>
                            <th>Admin Percentage</th>
                            <th>Total Admin Revenue</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        foreach ($payment_history as $key => $getPayment):
                            if ($getPayment['course_type'] !== "course") {
                                $revenue_percentage = $getPayment['revenue_percentage'];
                                $admin_percentage = 100 - $revenue_percentage;
                                $adminAmount = ($getPayment['amount'] * $admin_percentage) / 100;

                            } else {
                                $adminAmount = $getPayment['admin_revenue'];
                            }
                            $total += $adminAmount;
                            ?>
                            <tr>
                                <td><?= date("d-m-Y", $getPayment['date_added']) ?></td>
                                <td><?= $getPayment['course_type'] ?></td>
                                <td><?php if ($getPayment['course_type'] === "counselling") {
                                        $d = getUserData($getPayment['instructor_id']); ?>
                                        <b>Instructor Name : </b><br/>
                                        <a href="<?php echo site_url('uploads/user_image/' . $d->image . '.jpg') ?>"
                                           target="_blank">
                                            <img src="<?php echo site_url('uploads/user_image/' . $d->image . '.jpg') ?>"
                                                 alt="" height="50" width="50"
                                                 class="img-fluid rounded-circle img-thumbnail">
                                        </a>
                                        <br>
                                        <?php echo $d->first_name . ' ' . $d->last_name ?>
                                    <?php } elseif ($getPayment['course_type'] === "course") {
                                        echo "<b>Course Name : </b><br/>". $this->db->get_where('course', array('id' => $getPayment['course_id']))->row('title');
                                    } elseif ($getPayment['course_type'] === "live") {
                                        echo "<b>Live Class Name : </b><br/>". $this->db->get_where('live_class_time_new', array('live_id' => $getPayment['course_id']))->row('live_class_name');
                                    } else {
                                        echo "-----";
                                    } ?></td>
                                <td>₹ <?= $getPayment['amount'] ?></td>
                                <td>₹ <?= $getPayment['discounted_price'] ?></td>
                                <td>
                                    <?php
                                    if ($getPayment['course_type'] !== "course") {
                                        echo 100 - $getPayment['revenue_percentage'] . '%';
                                    } else {
                                        echo "-----";
                                    }
                                    ?>
                                </td>
                                <td>₹
                                    <?php
                                    echo $adminAmount;
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Grand Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>₹ <?= $total; ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function update_date_range() {
        var x = $("#selectedValue").html();
        $("#date_range").val(x);
    }
</script>
