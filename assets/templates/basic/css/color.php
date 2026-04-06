<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color or !checkhexcolor($color)) {
    $color = "#336699";
}

function checkhexcolor2($secondColor)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) and $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor or !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}

?>
.payment-item:has(.payment-item__radio:checked) {
    border-left: 3px solid <?php echo $color; ?>!important;
}
.menu, .bg--primary,.footer-section,.btn--primary,.transection-table-2 thead,.dashboard-user::before,.login,.contact--btn,::selection, .hot-product-sidebar > .title, .btn--base, .pagination .page-item.active span, .pagination .page-item.active a, .pagination .page-item:hover span, .pagination .page-item:hover a{
    background: <?php echo $color; ?>!important
}
.custom--radio input[type="radio"]::after, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,.user-dashboard-tab li a:hover, .payment-item__btn, .user-toggler, .feedback-icon, .dashboard-card-item .icon, .text--primary {
    color : <?php echo $color; ?>!important
}

.cmn--btn{
    color : <?php echo $color; ?>
}

.menu > li:not(.close-trigger):hover,.bg--base,.hot-item .thumb .discount-wrapper,.overview-item,.cmn--btn:hover,.checkout-button,.social-links li a:hover,.mobile-code, .scrollToTop, .menu li.has-sub-menu li{
    background: <?php echo $secondColor; ?>!important
}
.text--secondary,.text--base,.contact-info-wrapper .contact-list a,.contact-info-wrapper .address i, .dashboard-card-item .content .price{
    color: <?php echo $secondColor; ?>!important
}

.social-links li a:hover, {
    border-color:<?php echo $secondColor; ?>!important
}
.payment-item:has(.payment-item__radio:checked) .payment-item__check {
    border: 3px solid <?php echo $color; ?>
}
.user-dashboard-tab li a:hover, .user-dashboard-tab li a.active , .border--primary, .feedback-icon, .btn--primary {
    border-color:<?php echo $color; ?>!important
}
.payment-item__check {
    border: 1px solid <?php echo $color; ?>
}

.menu li.search-toggler-btn, .menu li.search-toggler-btn:hover {
  background-color: transparent !important;
}

.btn--base,
.product-item .content .cmn--btn, .hot-item .content .button-wrapper .cmn--btn {
    color: #fff !important;
}

.payment-card-title  {
    background: <?php echo $color; ?>!important
}
