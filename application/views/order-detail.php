<?php
////////////////////////// Order Details //////////////////////////
$order_id = $order_info['order_id'];
$order_status = $order_info['order_status'];
$order_status_type = $order_info['order_status_type'];
$order_status_class = '';
if ($order_status == '1'):
    $order_status_class = 'label-warning';
elseif ($order_status == '2'):
    $order_status_class = 'label-primary';
elseif ($order_status == '3'):
    $order_status_class = 'label-success';
elseif ($order_status == '4'):
    $order_status_class = 'label-danger';
else:
    $payment_status = $order_info['checkout_status'];
endif;
$order_subtotal = $order_info['order_subtotal'];
$order_item = $order_info['order_item'];
$ship_cost = $order_info['ship_cost'];
$order_total = ($order_subtotal + $ship_cost);
$order_date = date('Y-m-d', strtotime($order_info['order_date']));
$payment_status = $order_info['checkout_status'];
$payment_status_class = '';
if ($payment_status == 'PaymentActionCompleted'):
    $payment_status = 'Complete';
    $payment_status_class = 'label-success';
elseif ($row->checkout_status == 'PaymentActionInProgress'):
    $payment_status = 'In Progress';
    $payment_status_class = 'label-primary';
elseif ($row->checkout_status == 'PaymentActionFailed'):
    $payment_status = 'Failed';
    $payment_status_class = 'label-danger';
elseif ($row->checkout_status == 'PaymentActionNotInitiated'):
    $payment_status = 'Not Initiated';
    $payment_status_class = 'label-warning';
else:
    $payment_status = $order_info['checkout_status'];
endif;
//////////////////////// End order Details ////////////////////////
//
////////////////////////// User Details ///////////////////////////
$user_id = $order_info['user_id'];
$user_name = $order_info['user_name'];
$user_email = $order_info['user_email'];
$user_registered = date('Y-m-d', strtotime($order_info['user_registered']));
$user_status = ($order_info['user_status']) ? 'Active' : 'Blocked';
//////////////////////// End user Details /////////////////////////
//
//////////////////////// Billing Details //////////////////////////
$billing_details = unserialize($order_info['order_billing']);
$billing_name = $billing_details['billing_fname'] . ' ' . $billing_details['billing_lname'];
$billing_address = $billing_details['billing_address'] . ', ' . $billing_details['billing_city'] . ', ' . $billing_details['billing_state'] . ', ' . $billing_details['billing_country'] . ', ' . $billing_details['billing_zip'] . '.';
$billing_phone = $billing_details['billing_phone'];
$billing_email = $billing_details['billing_email'];
//////////////////////// End billing Details ///////////////////////
//
//////////////////////// Shipping Details //////////////////////////
$shipping_details = unserialize($order_info['order_shipping']);
$shipping_name = $shipping_details['shipping_fname'] . ' ' . $shipping_details['shipping_lname'];
$shipping_address = $shipping_details['shipping_address'] . ', ' . $shipping_details['shipping_city'] . ', ' . $shipping_details['shipping_state'] . ', ' . $shipping_details['shipping_country'] . ', ' . $shipping_details['shipping_zip'] . '.';
////////////////////// End shipping Details ////////////////////////
//////////////////////// Payment Details //////////////////////////
$payment_details = unserialize($order_info['payment_info']);
if ($payment_details && !empty($payment_details)):
    $payment_transaction_id = $payment_details[0]['TRANSACTIONID'];
    $payment_payed_status = $payment_details[0]['PAYMENTSTATUS'];
    $payment_pending_reason = $payment_details[0]['PENDINGREASON'];
endif;
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Order Details</h3>
                <div class="box-tools pull-right">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                <strong>Order Id:</strong> <?= $order_id; ?>
                <br>
                <strong>Payment Status:</strong> <span class="label <?= $payment_status_class ?>"><?= $payment_status; ?></span>
                <br>
                <strong>Order Status:</strong> <span class="label <?= $order_status_class ?>"><?= $order_status_type; ?></span>
                <br>
                <strong>Date:</strong> <?= $order_date; ?>
                <br>
            </div><!-- /.box-body -->
            <div class="box-footer" style="display: block;">

            </div><!-- /.box-footer-->
        </div>
    </div><!-- ./col -->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">User</h3>
                <div class="box-tools pull-right">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                <strong>Name:</strong> <?= $user_name; ?>
                <br>
                <strong>Email:</strong> <?= $user_email; ?>
                <br>
                <strong>Registered from:</strong> <?= $user_registered; ?>
                <br>
                <!--<strong>Status:</strong>--> 
                <?php // echo $user_status  ?>
                <!--<br>-->
            </div><!-- /.box-body -->
            <div class="box-footer" style="display: block;">

            </div><!-- /.box-footer-->
        </div>
    </div><!-- ./col -->

</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Bill to</h3>
                <div class="box-tools pull-right">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                <strong><?= $billing_name; ?></strong>
                <br>
                <strong></strong> <?= $billing_address; ?>
                <br>
                <strong>Phone:</strong> <?= $billing_phone; ?>
                <br>
                <strong>Email:</strong> <?= $billing_email; ?>
                <br>
            </div><!-- /.box-body -->
            <div class="box-footer" style="display: block;">

            </div><!-- /.box-footer-->
        </div>
    </div><!-- ./col -->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Ship to</h3>
                <div class="box-tools pull-right">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                <strong><?= $shipping_name; ?></strong>
                <br>
                <strong></strong> <?= $shipping_address; ?>
                <br>

            </div><!-- /.box-body -->
            <div class="box-footer" style="display: block;">

            </div><!-- /.box-footer-->
        </div>
    </div><!-- ./col -->

</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Cart</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body" style="display: block;">
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>&ensp;</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>SKU</th>
                            <!--<th>Description</th>-->
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order_items as $item):
                            $product_id = $item->product_id;
                            $featured_image = $item->featured_image;
                            $product_url = site_url('detail/' . $product_id);
                            $product_image_url = site_url(THUMB_PATH . '/' . $featured_image);
                            $product_title = $item->product_title;
                            $product_qty = $item->prod_qty;
                            $product_sku = $item->product_sku;
                            $product_content = $item->product_content;
                            $product_price = $item->prod_price;
                            $product_subtotal = ($product_price * $product_qty);
                            ?>
                            <tr>
                                <td>
                                    <a target="_blank" href="<?= $product_url; ?>"><img src="<?= $product_image_url; ?>" width="100" /></a>
                                </td>
                                <td>
                                    <a target="_blank" href="<?= $product_url; ?>"><?= $product_title; ?></a>
                                </td>
                                <td><?= $product_qty; ?></td>
                                <td><?= $product_sku; ?></td>
                                <!--<td>-->
                                <?php // echo $product_content; ?>
                                <!--</td>-->
                                <td><?= '$' . $product_price; ?></td>
                                <td><?= '$' . $product_subtotal; ?></td>
                            </tr>
                        <?php endforeach;
                        ?>
                    </tbody>
                </table>
            </div><!-- /.col -->
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer" style="display: block;">
        <div class="col-xs-6"></div>
        <div class="col-xs-6">
            <p class="lead">Cart <?= $order_date ?></p>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>$<?= $order_subtotal; ?></td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>$<?= $ship_cost; ?></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>$<?= $order_total; ?></td>
                        </tr>
                    </tbody></table>
            </div>
        </div>
    </div><!-- /.box-footer-->
</div>
<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Email to <?= $billing_name; ?></h3>
                <div class="box-tools pull-right">
                    <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
                    <button data-original-title="Remove" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title=""><i class="fa fa-times"></i></button>
                </div>
            </div>
            <form id="admin_email_to_client" action="" method="post">
                <input type="hidden" name="user_id" value="<?= $user_id; ?>"/>
                <input type="hidden" name="order_id" value="<?= $order_id; ?>"/>
                <div class="box-body">
                    <div class="form-group">
                        <label>Email:</label>
                        <input class="form-control" placeholder="To:" name="user_email" value="<?= $user_email; ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Subject:</label>
                        <input class="form-control" placeholder="Subject:" name="email_subject" />
                    </div>
                    <div class="form-group">
                        <label>Message:</label>
                        <textarea id="email_to_client_content" name="email_content" class="form-control texteditor" style="height: 300px"></textarea>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-9" id="admin_email_to_client_message">

                        </div>
                        <div class="col-md-3">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                            </div>
                        </div><!-- /.box-footer -->
                    </div>
                    <?php if ($messages): ?>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="box box-primary collapsed-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Conversation</h3>
                                        <div class="box-tools pull-right">
                                            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
                                            <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body" style="display: none;">
                                        <div class="row">
                                            <div class="col-xs-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>Message</th>
                                                            <th>Status</th>
                                                            <th>&ensp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($messages as $message):
                                                            $message_datetime = $user_registered = date('d/m/Y h:i:s A', strtotime($message->message_datetime));
                                                            ?>
                                                            <tr>

                                                                <td><?= $message->message_subject; ?></td>
                                                                <td><?= $message->message_content; ?></td>
                                                                <td><?= $message->message_status; ?></td>
                                                                <td><?= $message_datetime; ?></td>
                                                            </tr>
                                                        <?php endforeach;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div><!-- /.col -->
                                        </div>
                                    </div><!-- /.box-body -->
                                </div>

                            </div></div>
                    <?php endif; ?>
                </div>
            </form>
            <?php
            // echo '<pre>';
//            print_r($messages); 
            ?>

        </div><!-- /. box -->

    </div><!-- /.col -->
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Payment Details</h3>
                <div class="box-tools pull-right">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <?php if ($payment_status): ?>
                <div class="box-body" style="display: block;">
                    <strong>Status:</strong> <?= $payment_payed_status; ?>
                    <br>
                    <strong>Transaction ID:</strong> <?= $payment_transaction_id; ?>
                    <br>
                    <?php if ($payment_payed_status != 'Completed'): ?>
                        <strong>Pending Reason:</strong> <?= $payment_pending_reason; ?>
                        <br>    
                    <?php endif; ?>
                </div><!-- /.box-body -->
            <?php endif; ?>
            <div class="box-footer" style="display: block;">

            </div><!-- /.box-footer-->
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Order Action</h3>
                <div class="box-tools pull-right">
                    <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <?php if ($order_statuses): ?>
                <form action="<?= site_url('admin/order_detail/' . $order_id); ?>" method="post">
                    <div class="box-body" style="display: block;">
                        <div class="form-group">
                            <label>Change Your Order Status</label>
                            <select class="form-control" name="order_status">
                                <?php
                                foreach ($order_statuses as $status):
                                    $order_status_id = $status->order_status_id;
                                    $order_status_type = $status->order_status_type;
                                    ?>
                                    <option value="<?= $order_status_id; ?>" <?= ($order_status_id == $order_status) ? 'selected' : '' ?>> <?= $order_status_type; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="box-footer" style="display: block;">
                        <div class="pull-right">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div><!-- /.box-footer-->
                </form>
            <?php endif; ?>
        </div>
    </div><!-- ./col -->
</div>