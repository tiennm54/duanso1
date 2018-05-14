<?php
$statisticCount = Session::get('statisticCount', []);
?>
<header id="header" class="navbar navbar-static-top">
    <div class="navbar-header">
        <a type="button" id="button-menu" class="pull-left"><i class="fa fa-dedent fa-lg"></i></a>
        <a href="{{ URL::route('admin.index') }}" class="navbar-brand">
            <img src="{{url('theme_backend/image/logo.png')}}" alt="Buy Premium Key" title="Buy Premium Key" width="150px">
        </a>
    </div>
    <ul class="nav pull-right">
        <?php if ($statisticCount): ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <?php if ($statisticCount["count_noti"] > 0): ?>
                        <span class="label label-danger pull-left">
                            <?php echo $statisticCount["count_noti"]; ?>
                        </span>
                    <?php endif; ?>
                    <i class="fa fa-bell fa-lg"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right alerts-dropdown">

                    <li class="dropdown-header">Notification</li>
                    <li>
                        <?php $payment_bonus_id = $statisticCount["payment_bonus_id"]; ?>
                        <a href="<?php echo URL::route('adminUserOrders.listOrders') . "?payment_status=pending&payment_type=" . $payment_bonus_id; ?>" style="display: block; overflow: auto;">
                            <span class="label <?php echo ($statisticCount["count_bonus_payment"] > 0) ? "label-warning" : "label-success"; ?> pull-right">
                                <?php echo $statisticCount["count_bonus_payment"]; ?>
                            </span>
                            Bonus payment
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL::route('adminUserOrders.listOrders') . "?payment_status=pending&used_bonus=yes"; ?>">
                            <span class="label <?php echo ($statisticCount["count_used_bonus_pending"] > 0) ? "label-danger" : "label-success"; ?> pull-right">
                                <?php echo $statisticCount["count_used_bonus_pending"]; ?>
                            </span>
                            Used bonus
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL::route('admin.userManagement.index') . "?filter_status=1"; ?>">
                            <span class="label  <?php echo ($statisticCount["count_user_lock"] > 0) ? "label-danger" : "label-success"; ?>  pull-right">
                                <?php echo $statisticCount["count_user_lock"]; ?>
                            </span>User locked
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo URL::route('admin.comment.index'); ?>">
                            <span class="label  <?php echo ($statisticCount["count_comment"] > 0) ? "label-danger" : "label-success"; ?>  pull-right">
                                <?php echo $statisticCount["count_comment"]; ?>
                            </span>User Comment
                        </a>
                    </li>

                    <li class="divider"></li>
                    <li class="dropdown-header">Orders (Processing)</li>
                    <li>
                        <a href="<?php echo URL::route('adminUserOrders.listOrders') . "?payment_status=paid"; ?>">
                            <span class="label label-danger pull-right">
                                <?php echo $statisticCount["count_order_paid"]; ?>
                            </span>
                            Paid
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL::route('adminUserOrders.listOrders') . "?payment_status=pending"; ?>">
                            <span class="label label-danger pull-right">
                                <?php echo $statisticCount["count_order_pending"]; ?>
                            </span>
                            Pending
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo URL::route('adminUserOrders.listOrders') . "?payment_status=refund"; ?>">
                            <span class="label label-danger pull-right">
                                <?php echo $statisticCount["count_order_refund"]; ?>
                            </span>
                            Refund
                        </a>
                    </li>

                    <li class="divider"></li>
                    <li class="dropdown-header">Affiliates</li>
                    <li>
                        <a href="<?php echo URL::route('admin.feedback.index'); ?>">
                            <span class="label <?php echo ($statisticCount["count_feedback"] > 0 ) ? "label-danger" : "label-success" ?> pull-right">
                                <?php echo $statisticCount["count_feedback"]; ?>
                            </span>Feed back
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Products</li>
                    <li>
                        <a href="<?php URL::route('articles.index') . '?int_status_stock=0'; ?>">
                            <span class="label label-danger pull-right">
                                <?php echo $statisticCount["count_product_no_stock"]; ?>
                            </span>Out of stock
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home fa-lg"></i></a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">Stores</li>
                <li><a href="{{ URL::route('frontend.articles.index') }}" target="_blank">Your Store</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ URL::route('users.getLogout') }}">
                <span class="hidden-xs hidden-sm hidden-md">Logout</span> <i class="fa fa-sign-out fa-lg"></i>
            </a>
        </li>
    </ul>
</header>

