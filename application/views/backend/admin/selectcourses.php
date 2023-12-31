<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"><i class="mdi mdi-apple-keyboard-command title_icon"></i> Courses List</h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <?php if (count($courses) > 0) { ?>
        <div class="col-xl-12">
            <h3><?= $user->first_name . ' ' . $user->last_name ?></h3>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Courses List</h4>

                    <div class="table-responsive-sm mt-4">
                        <table id="datatable-buttons" class="table table-striped nowrap text-center"
                               data-page-length='25'>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo get_phrase('title'); ?></th>
                                <th>Payment</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($courses as $key => $getCourse) { ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td>
                                        <strong><a href="<?php echo site_url('admin/course_form/course_edit/' . $getCourse['id']); ?>"><?php echo($getCourse['title']); ?></a></strong>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success btn-sm btn-block payment"
                                           data-key="<?= $getCourse['id'] ?>" data-value="<?= $getCourse['price'] ?>">
                                            Make Manual Payment
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 d-none priceShow">
            <div class="card d-none paymentForm">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Payment</h4>
                    <div class="table-responsive-sm mt-4">
                        <form action="<?= site_url('admin/sendRazorpayInviteLink') ?>" method="post">
                            <table id="datatable-buttons" class="table text-center">
                                <tbody>
                                <tr>
                                    <input name="courseId" class="courseId form-control text-center d-none" readonly>
                                    <input name="userId" value="<?= base64_encode($userId) ?>"
                                           class="form-control text-center d-none" readonly>
                                    <input name="coursePrice" class="paymentPrice form-control text-center d-none"
                                           readonly>
                                    <td>Course Amount</td>
                                    <td class="coursePrice"></td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td><input name="discountedPrice" type="text"
                                               class="form-control typeDiscount text-center">
                                        <p class="errorMessage"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Net Amount</td>
                                    <td><span>₹</span><span class="finalPrice"></span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button style="background-color: #0acf97 !important;"
                                                class="btn btn-success btn-block btn-sm notAccess">Send Amount Link
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card d-none paymentDetail">
                <div class="card-body">
                    <h4 class="mb-3 header-title text-center">Payment Detail</h4>
                    <div class="table-responsive-sm mt-4">
                        <table class="table text-center table-striped">
                            <tbody>
                            <tr>
                                <td>Price</td>
                                <td><span>₹</span><span id="mrp"></span></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td><span>₹</span><span id="discount"></span></td>
                            </tr>
                            <tr>
                                <td>Net Amount</td>
                                <td><span>₹</span><span id="net"></span></td>
                            </tr>
                            <tr>
                                <td>Purchased Date</td>
                                <td><span id="purchasedDate"></span></td>
                            </tr>
                            <tr>
                                <td>Expired Date</td>
                                <td><span id="expiredDate"></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="img-fluid w-100 text-center">
            <img style="opacity: 1; width: 100px;"
                 src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
            <?php echo get_phrase('no_data_found'); ?>
        </div>
    <?php } ?>
</div>

<script>
    $(function () {
        $('.payment').click(function () {

            let id = window.btoa($(this).attr('data-key'))
            let price = $(this).attr('data-value')

            fetch(`<?= site_url('Admin/checkEnrolledCourse/' . $userId . '/')?>${$(this).attr('data-key')}`).then(response => response.json())
                .then(data => {
                        if (data.status) {
                            $('.paymentForm').addClass('d-none')
                            $('.priceShow').removeClass('d-none')
                            $('.paymentDetail').removeClass('d-none')
                            $('#mrp').html((data.data.amount)-(data.data.discounted_price))
                            $('#net').html(data.data.amount)
                            $('#discount').html(data.data.discounted_price)
                            $('#purchasedDate').html(data.data.courseAddDate)
                            $('#expiredDate').html(data.data.courseExpiredDate)
                        } else {
                            $('.paymentForm').removeClass('d-none')
                            $('.priceShow').removeClass('d-none')
                            $('.paymentDetail').addClass('d-none')
                            $('#mrp').html("")
                            $('#net').html("")
                            $('#discount').html("")
                            $('#purchasedDate').html("")
                            $('#expiredDate').html("")
                        }
                    }
                );

            $('.courseId').val(id)
            $('.coursePrice,.finalPrice').html(price)
            $('.paymentPrice').val(price)
        })

        $('.typeDiscount').keyup(function () {
            let actualPrice = $('.coursePrice').html()
            let enterPrice = $(this).val()

            if (Number(enterPrice) >= Number(actualPrice)) {
                $('.errorMessage').html("<span style='color:red'>The discount price should not exceed or same the actual price</span>")
                $('.notAccess').prop('disabled', true)
                $('.paymentPrice').val(actualPrice.replace('₹', ''))
                $('.finalPrice').html(actualPrice.replace('₹', ''))
            } else {
                $('.errorMessage').html("")
                $('.paymentPrice').val(Number(actualPrice) - Number(enterPrice))
                $('.finalPrice').html(Number(actualPrice) - Number(enterPrice))
                $('.notAccess').prop('disabled', false)
            }

        })

    })
</script>
