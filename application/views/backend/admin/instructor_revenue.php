<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"><i
                            class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('instructor_revenue'); ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('instructor_revenue'); ?></h4>
                <div class="table-responsive-sm mt-4">
                    <table id="datatable-buttons" class="table table-striped table-centered mb-0 text-center">
                        <thead>
                        <tr>
                            <th>Payment Date</th>
                            <th>Payment Type</th>
                            <th>Detail</th>
                            <th>Total Amount</th>
                            <th>Percentage</th>
                            <th>Total Revenue</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        foreach ($payment_history as $key => $getPayment):
                            if ($getPayment['course_type'] !== "course") {
                                $revenue_percentage = $getPayment['revenue_percentage'];
                                $adminAmount = ($getPayment['amount'] * $revenue_percentage) / 100;

                            } else {
                                $adminAmount = $getPayment['amount'];
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
                                    <?php } elseif ($getPayment['course_type'] === "live") {
                                        echo "<b>Live Class Name : </b><br/>" . $this->db->get_where('live_class_time_new', array('live_id' => $getPayment['course_id']))->row('live_class_name');
                                    } else {
                                        echo "-----";
                                    } ?></td>
                                <td>₹ <?= $getPayment['amount'] ?></td>
                                <td>
                                    <?php
                                    echo $getPayment['revenue_percentage'] . '%';
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
                            <th>₹ <?= $total; ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
