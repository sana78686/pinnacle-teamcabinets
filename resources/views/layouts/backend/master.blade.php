<!DOCTYPE html>
<!-- saved from url=(0081)https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm-variation.html -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">

    <title>Team Cabinets</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta name="description" content="Examples of just how powerful ArchitectUI really is!">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" integrity="sha512-v8QQ0YQ3H4K6Ic3PJkym91KoeNT5S3PnDKvqnwqFD1oiqIl653crGZplPdU5KKtHjO0QKcQ2aUlQZYjHczkmGw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/linearicons@1.0.2/dist/web-font/style.min.css">
    <script src="https://cdn.jsdelivr.net/npm/linearicons@1.0.2/package.min.js"></script><link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/6.6.6/css/flag-icon.min.css">

    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/themify.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/feather-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/animate.css')}}">
    @yield('css')
    <!-- Plugins css Ends-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/css/pe7-icon.css')}}">
    <link
        href="{{ asset('backend') }}/main.d810cf0ae7f39f28f336.css"
        rel="stylesheet">
    <style>
        @-webkit-keyframes swal2-show {
            0% {
                -webkit-transform: scale(.7);
                transform: scale(.7)
            }

            45% {
                -webkit-transform: scale(1.05);
                transform: scale(1.05)
            }

            80% {
                -webkit-transform: scale(.95);
                transform: scale(.95)
            }

            100% {
                -webkit-transform: scale(1);
                transform: scale(1)
            }
        }

        @keyframes swal2-show {
            0% {
                -webkit-transform: scale(.7);
                transform: scale(.7)
            }

            45% {
                -webkit-transform: scale(1.05);
                transform: scale(1.05)
            }

            80% {
                -webkit-transform: scale(.95);
                transform: scale(.95)
            }

            100% {
                -webkit-transform: scale(1);
                transform: scale(1)
            }
        }

        @-webkit-keyframes swal2-hide {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1
            }

            100% {
                -webkit-transform: scale(.5);
                transform: scale(.5);
                opacity: 0
            }
        }

        @keyframes swal2-hide {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1
            }

            100% {
                -webkit-transform: scale(.5);
                transform: scale(.5);
                opacity: 0
            }
        }

        @-webkit-keyframes swal2-animate-success-line-tip {
            0% {
                top: 1.1875em;
                left: .0625em;
                width: 0
            }

            54% {
                top: 1.0625em;
                left: .125em;
                width: 0
            }

            70% {
                top: 2.1875em;
                left: -.375em;
                width: 3.125em
            }

            84% {
                top: 3em;
                left: 1.3125em;
                width: 1.0625em
            }

            100% {
                top: 2.8125em;
                left: .875em;
                width: 1.5625em
            }
        }

        @keyframes swal2-animate-success-line-tip {
            0% {
                top: 1.1875em;
                left: .0625em;
                width: 0
            }

            54% {
                top: 1.0625em;
                left: .125em;
                width: 0
            }

            70% {
                top: 2.1875em;
                left: -.375em;
                width: 3.125em
            }

            84% {
                top: 3em;
                left: 1.3125em;
                width: 1.0625em
            }

            100% {
                top: 2.8125em;
                left: .875em;
                width: 1.5625em
            }
        }

        @-webkit-keyframes swal2-animate-success-line-long {
            0% {
                top: 3.375em;
                right: 2.875em;
                width: 0
            }

            65% {
                top: 3.375em;
                right: 2.875em;
                width: 0
            }

            84% {
                top: 2.1875em;
                right: 0;
                width: 3.4375em
            }

            100% {
                top: 2.375em;
                right: .5em;
                width: 2.9375em
            }
        }

        @keyframes swal2-animate-success-line-long {
            0% {
                top: 3.375em;
                right: 2.875em;
                width: 0
            }

            65% {
                top: 3.375em;
                right: 2.875em;
                width: 0
            }

            84% {
                top: 2.1875em;
                right: 0;
                width: 3.4375em
            }

            100% {
                top: 2.375em;
                right: .5em;
                width: 2.9375em
            }
        }

        @-webkit-keyframes swal2-rotate-success-circular-line {
            0% {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            5% {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            12% {
                -webkit-transform: rotate(-405deg);
                transform: rotate(-405deg)
            }

            100% {
                -webkit-transform: rotate(-405deg);
                transform: rotate(-405deg)
            }
        }

        @keyframes swal2-rotate-success-circular-line {
            0% {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            5% {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            12% {
                -webkit-transform: rotate(-405deg);
                transform: rotate(-405deg)
            }

            100% {
                -webkit-transform: rotate(-405deg);
                transform: rotate(-405deg)
            }
        }

        @-webkit-keyframes swal2-animate-error-x-mark {
            0% {
                margin-top: 1.625em;
                -webkit-transform: scale(.4);
                transform: scale(.4);
                opacity: 0
            }

            50% {
                margin-top: 1.625em;
                -webkit-transform: scale(.4);
                transform: scale(.4);
                opacity: 0
            }

            80% {
                margin-top: -.375em;
                -webkit-transform: scale(1.15);
                transform: scale(1.15)
            }

            100% {
                margin-top: 0;
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes swal2-animate-error-x-mark {
            0% {
                margin-top: 1.625em;
                -webkit-transform: scale(.4);
                transform: scale(.4);
                opacity: 0
            }

            50% {
                margin-top: 1.625em;
                -webkit-transform: scale(.4);
                transform: scale(.4);
                opacity: 0
            }

            80% {
                margin-top: -.375em;
                -webkit-transform: scale(1.15);
                transform: scale(1.15)
            }

            100% {
                margin-top: 0;
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 1
            }
        }

        @-webkit-keyframes swal2-animate-error-icon {
            0% {
                -webkit-transform: rotateX(100deg);
                transform: rotateX(100deg);
                opacity: 0
            }

            100% {
                -webkit-transform: rotateX(0);
                transform: rotateX(0);
                opacity: 1
            }
        }

        @keyframes swal2-animate-error-icon {
            0% {
                -webkit-transform: rotateX(100deg);
                transform: rotateX(100deg);
                opacity: 0
            }

            100% {
                -webkit-transform: rotateX(0);
                transform: rotateX(0);
                opacity: 1
            }
        }

        body.swal2-toast-shown .swal2-container {
            background-color: transparent
        }

        body.swal2-toast-shown .swal2-container.swal2-shown {
            background-color: transparent
        }

        body.swal2-toast-shown .swal2-container.swal2-top {
            top: 0;
            right: auto;
            bottom: auto;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%)
        }

        body.swal2-toast-shown .swal2-container.swal2-top-end,
        body.swal2-toast-shown .swal2-container.swal2-top-right {
            top: 0;
            right: 0;
            bottom: auto;
            left: auto
        }

        body.swal2-toast-shown .swal2-container.swal2-top-left,
        body.swal2-toast-shown .swal2-container.swal2-top-start {
            top: 0;
            right: auto;
            bottom: auto;
            left: 0
        }

        body.swal2-toast-shown .swal2-container.swal2-center-left,
        body.swal2-toast-shown .swal2-container.swal2-center-start {
            top: 50%;
            right: auto;
            bottom: auto;
            left: 0;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%)
        }

        body.swal2-toast-shown .swal2-container.swal2-center {
            top: 50%;
            right: auto;
            bottom: auto;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%)
        }

        body.swal2-toast-shown .swal2-container.swal2-center-end,
        body.swal2-toast-shown .swal2-container.swal2-center-right {
            top: 50%;
            right: 0;
            bottom: auto;
            left: auto;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%)
        }

        body.swal2-toast-shown .swal2-container.swal2-bottom-left,
        body.swal2-toast-shown .swal2-container.swal2-bottom-start {
            top: auto;
            right: auto;
            bottom: 0;
            left: 0
        }

        body.swal2-toast-shown .swal2-container.swal2-bottom {
            top: auto;
            right: auto;
            bottom: 0;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%)
        }

        body.swal2-toast-shown .swal2-container.swal2-bottom-end,
        body.swal2-toast-shown .swal2-container.swal2-bottom-right {
            top: auto;
            right: 0;
            bottom: 0;
            left: auto
        }

        body.swal2-toast-column .swal2-toast {
            flex-direction: column;
            align-items: stretch
        }

        body.swal2-toast-column .swal2-toast .swal2-actions {
            flex: 1;
            align-self: stretch;
            height: 2.2em;
            margin-top: .3125em
        }

        body.swal2-toast-column .swal2-toast .swal2-loading {
            justify-content: center
        }

        body.swal2-toast-column .swal2-toast .swal2-input {
            height: 2em;
            margin: .3125em auto;
            font-size: 1em
        }

        body.swal2-toast-column .swal2-toast .swal2-validation-message {
            font-size: 1em
        }

        .swal2-popup.swal2-toast {
            flex-direction: row;
            align-items: center;
            width: auto;
            padding: .625em;
            box-shadow: 0 0 .625em #d9d9d9;
            overflow-y: hidden
        }

        .swal2-popup.swal2-toast .swal2-header {
            flex-direction: row
        }

        .swal2-popup.swal2-toast .swal2-title {
            flex-grow: 1;
            justify-content: flex-start;
            margin: 0 .6em;
            font-size: 1em
        }

        .swal2-popup.swal2-toast .swal2-footer {
            margin: .5em 0 0;
            padding: .5em 0 0;
            font-size: .8em
        }

        .swal2-popup.swal2-toast .swal2-close {
            position: initial;
            width: .8em;
            height: .8em;
            line-height: .8
        }

        .swal2-popup.swal2-toast .swal2-content {
            justify-content: flex-start;
            font-size: 1em
        }

        .swal2-popup.swal2-toast .swal2-icon {
            width: 2em;
            min-width: 2em;
            height: 2em;
            margin: 0
        }

        .swal2-popup.swal2-toast .swal2-icon-text {
            font-size: 2em;
            font-weight: 700;
            line-height: 1em
        }

        .swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring {
            width: 2em;
            height: 2em
        }

        .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
            top: .875em;
            width: 1.375em
        }

        .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
            left: .3125em
        }

        .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
            right: .3125em
        }

        .swal2-popup.swal2-toast .swal2-actions {
            height: auto;
            margin: 0 .3125em
        }

        .swal2-popup.swal2-toast .swal2-styled {
            margin: 0 .3125em;
            padding: .3125em .625em;
            font-size: 1em
        }

        .swal2-popup.swal2-toast .swal2-styled:focus {
            box-shadow: 0 0 0 .0625em #fff, 0 0 0 .125em rgba(50, 100, 150, .4)
        }

        .swal2-popup.swal2-toast .swal2-success {
            border-color: #a5dc86
        }

        .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line] {
            position: absolute;
            width: 2em;
            height: 2.8125em;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            border-radius: 50%
        }

        .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left] {
            top: -.25em;
            left: -.9375em;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 2em 2em;
            transform-origin: 2em 2em;
            border-radius: 4em 0 0 4em
        }

        .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right] {
            top: -.25em;
            left: .9375em;
            -webkit-transform-origin: 0 2em;
            transform-origin: 0 2em;
            border-radius: 0 4em 4em 0
        }

        .swal2-popup.swal2-toast .swal2-success .swal2-success-ring {
            width: 2em;
            height: 2em
        }

        .swal2-popup.swal2-toast .swal2-success .swal2-success-fix {
            top: 0;
            left: .4375em;
            width: .4375em;
            height: 2.6875em
        }

        .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line] {
            height: .3125em
        }

        .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip] {
            top: 1.125em;
            left: .1875em;
            width: .75em
        }

        .swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long] {
            top: .9375em;
            right: .1875em;
            width: 1.375em
        }

        .swal2-popup.swal2-toast.swal2-show {
            -webkit-animation: showSweetToast .5s;
            animation: showSweetToast .5s
        }

        .swal2-popup.swal2-toast.swal2-hide {
            -webkit-animation: hideSweetToast .2s forwards;
            animation: hideSweetToast .2s forwards
        }

        .swal2-popup.swal2-toast .swal2-animate-success-icon .swal2-success-line-tip {
            -webkit-animation: animate-toast-success-tip .75s;
            animation: animate-toast-success-tip .75s
        }

        .swal2-popup.swal2-toast .swal2-animate-success-icon .swal2-success-line-long {
            -webkit-animation: animate-toast-success-long .75s;
            animation: animate-toast-success-long .75s
        }

        @-webkit-keyframes showSweetToast {
            0% {
                -webkit-transform: translateY(-.625em) rotateZ(2deg);
                transform: translateY(-.625em) rotateZ(2deg);
                opacity: 0
            }

            33% {
                -webkit-transform: translateY(0) rotateZ(-2deg);
                transform: translateY(0) rotateZ(-2deg);
                opacity: .5
            }

            66% {
                -webkit-transform: translateY(.3125em) rotateZ(2deg);
                transform: translateY(.3125em) rotateZ(2deg);
                opacity: .7
            }

            100% {
                -webkit-transform: translateY(0) rotateZ(0);
                transform: translateY(0) rotateZ(0);
                opacity: 1
            }
        }

        @keyframes showSweetToast {
            0% {
                -webkit-transform: translateY(-.625em) rotateZ(2deg);
                transform: translateY(-.625em) rotateZ(2deg);
                opacity: 0
            }

            33% {
                -webkit-transform: translateY(0) rotateZ(-2deg);
                transform: translateY(0) rotateZ(-2deg);
                opacity: .5
            }

            66% {
                -webkit-transform: translateY(.3125em) rotateZ(2deg);
                transform: translateY(.3125em) rotateZ(2deg);
                opacity: .7
            }

            100% {
                -webkit-transform: translateY(0) rotateZ(0);
                transform: translateY(0) rotateZ(0);
                opacity: 1
            }
        }

        @-webkit-keyframes hideSweetToast {
            0% {
                opacity: 1
            }

            33% {
                opacity: .5
            }

            100% {
                -webkit-transform: rotateZ(1deg);
                transform: rotateZ(1deg);
                opacity: 0
            }
        }

        @keyframes hideSweetToast {
            0% {
                opacity: 1
            }

            33% {
                opacity: .5
            }

            100% {
                -webkit-transform: rotateZ(1deg);
                transform: rotateZ(1deg);
                opacity: 0
            }
        }

        @-webkit-keyframes animate-toast-success-tip {
            0% {
                top: .5625em;
                left: .0625em;
                width: 0
            }

            54% {
                top: .125em;
                left: .125em;
                width: 0
            }

            70% {
                top: .625em;
                left: -.25em;
                width: 1.625em
            }

            84% {
                top: 1.0625em;
                left: .75em;
                width: .5em
            }

            100% {
                top: 1.125em;
                left: .1875em;
                width: .75em
            }
        }

        @keyframes animate-toast-success-tip {
            0% {
                top: .5625em;
                left: .0625em;
                width: 0
            }

            54% {
                top: .125em;
                left: .125em;
                width: 0
            }

            70% {
                top: .625em;
                left: -.25em;
                width: 1.625em
            }

            84% {
                top: 1.0625em;
                left: .75em;
                width: .5em
            }

            100% {
                top: 1.125em;
                left: .1875em;
                width: .75em
            }
        }

        @-webkit-keyframes animate-toast-success-long {
            0% {
                top: 1.625em;
                right: 1.375em;
                width: 0
            }

            65% {
                top: 1.25em;
                right: .9375em;
                width: 0
            }

            84% {
                top: .9375em;
                right: 0;
                width: 1.125em
            }

            100% {
                top: .9375em;
                right: .1875em;
                width: 1.375em
            }
        }

        @keyframes animate-toast-success-long {
            0% {
                top: 1.625em;
                right: 1.375em;
                width: 0
            }

            65% {
                top: 1.25em;
                right: .9375em;
                width: 0
            }

            84% {
                top: .9375em;
                right: 0;
                width: 1.125em
            }

            100% {
                top: .9375em;
                right: .1875em;
                width: 1.375em
            }
        }

        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
            overflow: hidden
        }

        body.swal2-height-auto {
            height: auto !important
        }

        body.swal2-no-backdrop .swal2-shown {
            top: auto;
            right: auto;
            bottom: auto;
            left: auto;
            background-color: transparent
        }

        body.swal2-no-backdrop .swal2-shown>.swal2-modal {
            box-shadow: 0 0 10px rgba(0, 0, 0, .4)
        }

        body.swal2-no-backdrop .swal2-shown.swal2-top {
            top: 0;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%)
        }

        body.swal2-no-backdrop .swal2-shown.swal2-top-left,
        body.swal2-no-backdrop .swal2-shown.swal2-top-start {
            top: 0;
            left: 0
        }

        body.swal2-no-backdrop .swal2-shown.swal2-top-end,
        body.swal2-no-backdrop .swal2-shown.swal2-top-right {
            top: 0;
            right: 0
        }

        body.swal2-no-backdrop .swal2-shown.swal2-center {
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%)
        }

        body.swal2-no-backdrop .swal2-shown.swal2-center-left,
        body.swal2-no-backdrop .swal2-shown.swal2-center-start {
            top: 50%;
            left: 0;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%)
        }

        body.swal2-no-backdrop .swal2-shown.swal2-center-end,
        body.swal2-no-backdrop .swal2-shown.swal2-center-right {
            top: 50%;
            right: 0;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%)
        }

        body.swal2-no-backdrop .swal2-shown.swal2-bottom {
            bottom: 0;
            left: 50%;
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%)
        }

        body.swal2-no-backdrop .swal2-shown.swal2-bottom-left,
        body.swal2-no-backdrop .swal2-shown.swal2-bottom-start {
            bottom: 0;
            left: 0
        }

        body.swal2-no-backdrop .swal2-shown.swal2-bottom-end,
        body.swal2-no-backdrop .swal2-shown.swal2-bottom-right {
            right: 0;
            bottom: 0
        }

        .swal2-container {
            display: flex;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background-color: transparent;
            z-index: 1060;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch
        }

        .swal2-container.swal2-top {
            align-items: flex-start
        }

        .swal2-container.swal2-top-left,
        .swal2-container.swal2-top-start {
            align-items: flex-start;
            justify-content: flex-start
        }

        .swal2-container.swal2-top-end,
        .swal2-container.swal2-top-right {
            align-items: flex-start;
            justify-content: flex-end
        }

        .swal2-container.swal2-center {
            align-items: center
        }

        .swal2-container.swal2-center-left,
        .swal2-container.swal2-center-start {
            align-items: center;
            justify-content: flex-start
        }

        .swal2-container.swal2-center-end,
        .swal2-container.swal2-center-right {
            align-items: center;
            justify-content: flex-end
        }

        .swal2-container.swal2-bottom {
            align-items: flex-end
        }

        .swal2-container.swal2-bottom-left,
        .swal2-container.swal2-bottom-start {
            align-items: flex-end;
            justify-content: flex-start
        }

        .swal2-container.swal2-bottom-end,
        .swal2-container.swal2-bottom-right {
            align-items: flex-end;
            justify-content: flex-end
        }

        .swal2-container.swal2-grow-fullscreen>.swal2-modal {
            display: flex !important;
            flex: 1;
            align-self: stretch;
            justify-content: center
        }

        .swal2-container.swal2-grow-row>.swal2-modal {
            display: flex !important;
            flex: 1;
            align-content: center;
            justify-content: center
        }

        .swal2-container.swal2-grow-column {
            flex: 1;
            flex-direction: column
        }

        .swal2-container.swal2-grow-column.swal2-bottom,
        .swal2-container.swal2-grow-column.swal2-center,
        .swal2-container.swal2-grow-column.swal2-top {
            align-items: center
        }

        .swal2-container.swal2-grow-column.swal2-bottom-left,
        .swal2-container.swal2-grow-column.swal2-bottom-start,
        .swal2-container.swal2-grow-column.swal2-center-left,
        .swal2-container.swal2-grow-column.swal2-center-start,
        .swal2-container.swal2-grow-column.swal2-top-left,
        .swal2-container.swal2-grow-column.swal2-top-start {
            align-items: flex-start
        }

        .swal2-container.swal2-grow-column.swal2-bottom-end,
        .swal2-container.swal2-grow-column.swal2-bottom-right,
        .swal2-container.swal2-grow-column.swal2-center-end,
        .swal2-container.swal2-grow-column.swal2-center-right,
        .swal2-container.swal2-grow-column.swal2-top-end,
        .swal2-container.swal2-grow-column.swal2-top-right {
            align-items: flex-end
        }

        .swal2-container.swal2-grow-column>.swal2-modal {
            display: flex !important;
            flex: 1;
            align-content: center;
            justify-content: center
        }

        .swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal {
            margin: auto
        }

        @media all and (-ms-high-contrast:none),
        (-ms-high-contrast:active) {
            .swal2-container .swal2-modal {
                margin: 0 !important
            }
        }

        .swal2-container.swal2-fade {
            transition: background-color .1s
        }

        .swal2-container.swal2-shown {
            background-color: rgba(0, 0, 0, .4)
        }

        .swal2-popup {
            display: none;
            position: relative;
            flex-direction: column;
            justify-content: center;
            width: 32em;
            max-width: 100%;
            padding: 1.25em;
            border-radius: .3125em;
            background: #fff;
            font-family: inherit;
            font-size: 1rem;
            box-sizing: border-box
        }

        .swal2-popup:focus {
            outline: 0
        }

        .swal2-popup.swal2-loading {
            overflow-y: hidden
        }

        .swal2-popup .swal2-header {
            display: flex;
            flex-direction: column;
            align-items: center
        }

        .swal2-popup .swal2-title {
            display: block;
            position: relative;
            max-width: 100%;
            margin: 0 0 .4em;
            padding: 0;
            color: #595959;
            font-size: 1.875em;
            font-weight: 600;
            text-align: center;
            text-transform: none;
            word-wrap: break-word
        }

        .swal2-popup .swal2-actions {
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            margin: 1.25em auto 0;
            z-index: 1
        }

        .swal2-popup .swal2-actions:not(.swal2-loading) .swal2-styled[disabled] {
            opacity: .4
        }

        .swal2-popup .swal2-actions:not(.swal2-loading) .swal2-styled:hover {
            background-image: linear-gradient(rgba(0, 0, 0, .1), rgba(0, 0, 0, .1))
        }

        .swal2-popup .swal2-actions:not(.swal2-loading) .swal2-styled:active {
            background-image: linear-gradient(rgba(0, 0, 0, .2), rgba(0, 0, 0, .2))
        }

        .swal2-popup .swal2-actions.swal2-loading .swal2-styled.swal2-confirm {
            width: 2.5em;
            height: 2.5em;
            margin: .46875em;
            padding: 0;
            border: .25em solid transparent;
            border-radius: 100%;
            border-color: transparent;
            background-color: transparent !important;
            color: transparent;
            cursor: default;
            box-sizing: border-box;
            -webkit-animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
            animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none
        }

        .swal2-popup .swal2-actions.swal2-loading .swal2-styled.swal2-cancel {
            margin-right: 30px;
            margin-left: 30px
        }

        .swal2-popup .swal2-actions.swal2-loading :not(.swal2-styled).swal2-confirm::after {
            display: inline-block;
            width: 15px;
            height: 15px;
            margin-left: 5px;
            border: 3px solid #999;
            border-radius: 50%;
            border-right-color: transparent;
            box-shadow: 1px 1px 1px #fff;
            content: '';
            -webkit-animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
            animation: swal2-rotate-loading 1.5s linear 0s infinite normal
        }

        .swal2-popup .swal2-styled {
            margin: .3125em;
            padding: .625em 2em;
            font-weight: 500;
            box-shadow: none
        }

        .swal2-popup .swal2-styled:not([disabled]) {
            cursor: pointer
        }

        .swal2-popup .swal2-styled.swal2-confirm {
            border: 0;
            border-radius: .25em;
            background: initial;
            background-color: #3085d6;
            color: #fff;
            font-size: 1.0625em
        }

        .swal2-popup .swal2-styled.swal2-cancel {
            border: 0;
            border-radius: .25em;
            background: initial;
            background-color: #aaa;
            color: #fff;
            font-size: 1.0625em
        }

        .swal2-popup .swal2-styled:focus {
            outline: 0;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(50, 100, 150, .4)
        }

        .swal2-popup .swal2-styled::-moz-focus-inner {
            border: 0
        }

        .swal2-popup .swal2-footer {
            justify-content: center;
            margin: 1.25em 0 0;
            padding: 1em 0 0;
            border-top: 1px solid #eee;
            color: #545454;
            font-size: 1em
        }

        .swal2-popup .swal2-image {
            max-width: 100%;
            margin: 1.25em auto
        }

        .swal2-popup .swal2-close {
            position: absolute;
            top: 0;
            right: 0;
            justify-content: center;
            width: 1.2em;
            height: 1.2em;
            padding: 0;
            transition: color .1s ease-out;
            border: none;
            border-radius: 0;
            outline: initial;
            background: 0 0;
            color: #ccc;
            font-family: serif;
            font-size: 2.5em;
            line-height: 1.2;
            cursor: pointer;
            overflow: hidden
        }

        .swal2-popup .swal2-close:hover {
            -webkit-transform: none;
            transform: none;
            color: #f27474
        }

        .swal2-popup>.swal2-checkbox,
        .swal2-popup>.swal2-file,
        .swal2-popup>.swal2-input,
        .swal2-popup>.swal2-radio,
        .swal2-popup>.swal2-select,
        .swal2-popup>.swal2-textarea {
            display: none
        }

        .swal2-popup .swal2-content {
            justify-content: center;
            margin: 0;
            padding: 0;
            color: #545454;
            font-size: 1.125em;
            font-weight: 300;
            line-height: normal;
            z-index: 1;
            word-wrap: break-word
        }

        .swal2-popup #swal2-content {
            text-align: center
        }

        .swal2-popup .swal2-checkbox,
        .swal2-popup .swal2-file,
        .swal2-popup .swal2-input,
        .swal2-popup .swal2-radio,
        .swal2-popup .swal2-select,
        .swal2-popup .swal2-textarea {
            margin: 1em auto
        }

        .swal2-popup .swal2-file,
        .swal2-popup .swal2-input,
        .swal2-popup .swal2-textarea {
            width: 100%;
            transition: border-color .3s, box-shadow .3s;
            border: 1px solid #d9d9d9;
            border-radius: .1875em;
            font-size: 1.125em;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .06);
            box-sizing: border-box
        }

        .swal2-popup .swal2-file.swal2-inputerror,
        .swal2-popup .swal2-input.swal2-inputerror,
        .swal2-popup .swal2-textarea.swal2-inputerror {
            border-color: #f27474 !important;
            box-shadow: 0 0 2px #f27474 !important
        }

        .swal2-popup .swal2-file:focus,
        .swal2-popup .swal2-input:focus,
        .swal2-popup .swal2-textarea:focus {
            border: 1px solid #b4dbed;
            outline: 0;
            box-shadow: 0 0 3px #c4e6f5
        }

        .swal2-popup .swal2-file::-webkit-input-placeholder,
        .swal2-popup .swal2-input::-webkit-input-placeholder,
        .swal2-popup .swal2-textarea::-webkit-input-placeholder {
            color: #ccc
        }

        .swal2-popup .swal2-file:-ms-input-placeholder,
        .swal2-popup .swal2-input:-ms-input-placeholder,
        .swal2-popup .swal2-textarea:-ms-input-placeholder {
            color: #ccc
        }

        .swal2-popup .swal2-file::-ms-input-placeholder,
        .swal2-popup .swal2-input::-ms-input-placeholder,
        .swal2-popup .swal2-textarea::-ms-input-placeholder {
            color: #ccc
        }

        .swal2-popup .swal2-file::placeholder,
        .swal2-popup .swal2-input::placeholder,
        .swal2-popup .swal2-textarea::placeholder {
            color: #ccc
        }

        .swal2-popup .swal2-range input {
            width: 80%
        }

        .swal2-popup .swal2-range output {
            width: 20%;
            font-weight: 600;
            text-align: center
        }

        .swal2-popup .swal2-range input,
        .swal2-popup .swal2-range output {
            height: 2.625em;
            margin: 1em auto;
            padding: 0;
            font-size: 1.125em;
            line-height: 2.625em
        }

        .swal2-popup .swal2-input {
            height: 2.625em;
            padding: 0 .75em
        }

        .swal2-popup .swal2-input[type=number] {
            max-width: 10em
        }

        .swal2-popup .swal2-file {
            font-size: 1.125em
        }

        .swal2-popup .swal2-textarea {
            height: 6.75em;
            padding: .75em
        }

        .swal2-popup .swal2-select {
            min-width: 50%;
            max-width: 100%;
            padding: .375em .625em;
            color: #545454;
            font-size: 1.125em
        }

        .swal2-popup .swal2-checkbox,
        .swal2-popup .swal2-radio {
            align-items: center;
            justify-content: center
        }

        .swal2-popup .swal2-checkbox label,
        .swal2-popup .swal2-radio label {
            margin: 0 .6em;
            font-size: 1.125em
        }

        .swal2-popup .swal2-checkbox input,
        .swal2-popup .swal2-radio input {
            margin: 0 .4em
        }

        .swal2-popup .swal2-validation-message {
            display: none;
            align-items: center;
            justify-content: center;
            padding: .625em;
            background: #f0f0f0;
            color: #666;
            font-size: 1em;
            font-weight: 300;
            overflow: hidden
        }

        .swal2-popup .swal2-validation-message::before {
            display: inline-block;
            width: 1.5em;
            min-width: 1.5em;
            height: 1.5em;
            margin: 0 .625em;
            border-radius: 50%;
            background-color: #f27474;
            color: #fff;
            font-weight: 600;
            line-height: 1.5em;
            text-align: center;
            content: '!';
            zoom: normal
        }

        @supports (-ms-accelerator:true) {
            .swal2-range input {
                width: 100% !important
            }

            .swal2-range output {
                display: none
            }
        }

        @media all and (-ms-high-contrast:none),
        (-ms-high-contrast:active) {
            .swal2-range input {
                width: 100% !important
            }

            .swal2-range output {
                display: none
            }
        }

        @-moz-document url-prefix() {
            .swal2-close:focus {
                outline: 2px solid rgba(50, 100, 150, .4)
            }
        }

        .swal2-icon {
            position: relative;
            justify-content: center;
            width: 5em;
            height: 5em;
            margin: 1.25em auto 1.875em;
            border: .25em solid transparent;
            border-radius: 50%;
            line-height: 5em;
            cursor: default;
            box-sizing: content-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            zoom: normal
        }

        .swal2-icon-text {
            font-size: 3.75em
        }

        .swal2-icon.swal2-error {
            border-color: #f27474
        }

        .swal2-icon.swal2-error .swal2-x-mark {
            position: relative;
            flex-grow: 1
        }

        .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
            display: block;
            position: absolute;
            top: 2.3125em;
            width: 2.9375em;
            height: .3125em;
            border-radius: .125em;
            background-color: #f27474
        }

        .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left] {
            left: 1.0625em;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg)
        }

        .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right] {
            right: 1em;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg)
        }

        .swal2-icon.swal2-warning {
            border-color: #facea8;
            color: #f8bb86
        }

        .swal2-icon.swal2-info {
            border-color: #9de0f6;
            color: #3fc3ee
        }

        .swal2-icon.swal2-question {
            border-color: #c9dae1;
            color: #87adbd
        }

        .swal2-icon.swal2-success {
            border-color: #a5dc86
        }

        .swal2-icon.swal2-success [class^=swal2-success-circular-line] {
            position: absolute;
            width: 3.75em;
            height: 7.5em;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            border-radius: 50%
        }

        .swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left] {
            top: -.4375em;
            left: -2.0635em;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 3.75em 3.75em;
            transform-origin: 3.75em 3.75em;
            border-radius: 7.5em 0 0 7.5em
        }

        .swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right] {
            top: -.6875em;
            left: 1.875em;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 0 3.75em;
            transform-origin: 0 3.75em;
            border-radius: 0 7.5em 7.5em 0
        }

        .swal2-icon.swal2-success .swal2-success-ring {
            position: absolute;
            top: -.25em;
            left: -.25em;
            width: 100%;
            height: 100%;
            border: .25em solid rgba(165, 220, 134, .3);
            border-radius: 50%;
            z-index: 2;
            box-sizing: content-box
        }

        .swal2-icon.swal2-success .swal2-success-fix {
            position: absolute;
            top: .5em;
            left: 1.625em;
            width: .4375em;
            height: 5.625em;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            z-index: 1
        }

        .swal2-icon.swal2-success [class^=swal2-success-line] {
            display: block;
            position: absolute;
            height: .3125em;
            border-radius: .125em;
            background-color: #a5dc86;
            z-index: 2
        }

        .swal2-icon.swal2-success [class^=swal2-success-line][class$=tip] {
            top: 2.875em;
            left: .875em;
            width: 1.5625em;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg)
        }

        .swal2-icon.swal2-success [class^=swal2-success-line][class$=long] {
            top: 2.375em;
            right: .5em;
            width: 2.9375em;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg)
        }

        .swal2-progresssteps {
            align-items: center;
            margin: 0 0 1.25em;
            padding: 0;
            font-weight: 600
        }

        .swal2-progresssteps li {
            display: inline-block;
            position: relative
        }

        .swal2-progresssteps .swal2-progresscircle {
            width: 2em;
            height: 2em;
            border-radius: 2em;
            background: #3085d6;
            color: #fff;
            line-height: 2em;
            text-align: center;
            z-index: 20
        }

        .swal2-progresssteps .swal2-progresscircle:first-child {
            margin-left: 0
        }

        .swal2-progresssteps .swal2-progresscircle:last-child {
            margin-right: 0
        }

        .swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep {
            background: #3085d6
        }

        .swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep~.swal2-progresscircle {
            background: #add8e6
        }

        .swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep~.swal2-progressline {
            background: #add8e6
        }

        .swal2-progresssteps .swal2-progressline {
            width: 2.5em;
            height: .4em;
            margin: 0 -1px;
            background: #3085d6;
            z-index: 10
        }

        [class^=swal2] {
            -webkit-tap-highlight-color: transparent
        }

        .swal2-show {
            -webkit-animation: swal2-show .3s;
            animation: swal2-show .3s
        }

        .swal2-show.swal2-noanimation {
            -webkit-animation: none;
            animation: none
        }

        .swal2-hide {
            -webkit-animation: swal2-hide .15s forwards;
            animation: swal2-hide .15s forwards
        }

        .swal2-hide.swal2-noanimation {
            -webkit-animation: none;
            animation: none
        }

        .swal2-rtl .swal2-close {
            right: auto;
            left: 0
        }

        .swal2-animate-success-icon .swal2-success-line-tip {
            -webkit-animation: swal2-animate-success-line-tip .75s;
            animation: swal2-animate-success-line-tip .75s
        }

        .swal2-animate-success-icon .swal2-success-line-long {
            -webkit-animation: swal2-animate-success-line-long .75s;
            animation: swal2-animate-success-line-long .75s
        }

        .swal2-animate-success-icon .swal2-success-circular-line-right {
            -webkit-animation: swal2-rotate-success-circular-line 4.25s ease-in;
            animation: swal2-rotate-success-circular-line 4.25s ease-in
        }

        .swal2-animate-error-icon {
            -webkit-animation: swal2-animate-error-icon .5s;
            animation: swal2-animate-error-icon .5s
        }

        .swal2-animate-error-icon .swal2-x-mark {
            -webkit-animation: swal2-animate-error-x-mark .5s;
            animation: swal2-animate-error-x-mark .5s
        }

        @-webkit-keyframes swal2-rotate-loading {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @keyframes swal2-rotate-loading {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg)
            }
        }

        @media print {
            body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
                overflow-y: scroll !important
            }

            body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true] {
                display: none
            }

            body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container {
                position: initial !important
            }
        }
    </style>
    <style type="text/css">
        .apexcharts-canvas {
            position: relative;
            user-select: none;
            /* cannot give overflow: hidden as it will crop tooltips which overflow outside chart area */
        }

        /* scrollbar is not visible by default for legend, hence forcing the visibility */
        .apexcharts-canvas ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 6px;
        }

        .apexcharts-canvas ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: rgba(0, 0, 0, .5);
            box-shadow: 0 0 1px rgba(255, 255, 255, .5);
            -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
        }

        .apexcharts-inner {
            position: relative;
        }

        .legend-mouseover-inactive {
            transition: 0.15s ease all;
            opacity: 0.20;
        }

        .apexcharts-series-collapsed {
            opacity: 0;
        }

        .apexcharts-gridline,
        .apexcharts-text {
            pointer-events: none;
        }

        .apexcharts-tooltip {
            border-radius: 5px;
            box-shadow: 2px 2px 6px -4px #999;
            cursor: default;
            font-size: 14px;
            left: 62px;
            opacity: 0;
            pointer-events: none;
            position: absolute;
            top: 20px;
            overflow: hidden;
            white-space: nowrap;
            z-index: 12;
            transition: 0.15s ease all;
        }

        .apexcharts-tooltip.light {
            border: 1px solid #e3e3e3;
            background: rgba(255, 255, 255, 0.96);
        }

        .apexcharts-tooltip.dark {
            color: #fff;
            background: rgba(30, 30, 30, 0.8);
        }

        .apexcharts-tooltip .apexcharts-marker,
        .apexcharts-area-series .apexcharts-area,
        .apexcharts-line {
            pointer-events: none;
        }

        .apexcharts-tooltip.active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-tooltip-title {
            padding: 6px;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .apexcharts-tooltip.light .apexcharts-tooltip-title {
            background: #ECEFF1;
            border-bottom: 1px solid #ddd;
        }

        .apexcharts-tooltip.dark .apexcharts-tooltip-title {
            background: rgba(0, 0, 0, 0.7);
            border-bottom: 1px solid #222;
        }

        .apexcharts-tooltip-text-value,
        .apexcharts-tooltip-text-z-value {
            display: inline-block;
            font-weight: 600;
            margin-left: 5px;
        }

        .apexcharts-tooltip-text-z-label:empty,
        .apexcharts-tooltip-text-z-value:empty {
            display: none;
        }

        .apexcharts-tooltip-text-value,
        .apexcharts-tooltip-text-z-value {
            font-weight: 600;
        }

        .apexcharts-tooltip-marker {
            width: 12px;
            height: 12px;
            position: relative;
            top: 0px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .apexcharts-tooltip-series-group {
            padding: 0 10px;
            display: none;
            text-align: left;
            justify-content: left;
            align-items: center;
        }

        .apexcharts-tooltip-series-group.active .apexcharts-tooltip-marker {
            opacity: 1;
        }

        .apexcharts-tooltip-series-group.active,
        .apexcharts-tooltip-series-group:last-child {
            padding-bottom: 4px;
        }

        .apexcharts-tooltip-y-group {
            padding: 6px 0 5px;
        }

        .apexcharts-tooltip-candlestick {
            padding: 4px 8px;
        }

        .apexcharts-tooltip-candlestick>div {
            margin: 4px 0;
        }

        .apexcharts-tooltip-candlestick span.value {
            font-weight: bold;
        }

        .apexcharts-xaxistooltip {
            opacity: 0;
            padding: 9px 10px;
            pointer-events: none;
            color: #373d3f;
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: #ECEFF1;
            border: 1px solid #90A4AE;
            transition: 0.15s ease all;
        }

        .apexcharts-xaxistooltip:after,
        .apexcharts-xaxistooltip:before {
            left: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .apexcharts-xaxistooltip:after {
            border-color: rgba(236, 239, 241, 0);
            border-width: 6px;
            margin-left: -6px;
        }

        .apexcharts-xaxistooltip:before {
            border-color: rgba(144, 164, 174, 0);
            border-width: 7px;
            margin-left: -7px;
        }

        .apexcharts-xaxistooltip-bottom:after,
        .apexcharts-xaxistooltip-bottom:before {
            bottom: 100%;
        }

        .apexcharts-xaxistooltip-bottom:after {
            border-bottom-color: #ECEFF1;
        }

        .apexcharts-xaxistooltip-bottom:before {
            border-bottom-color: #90A4AE;
        }

        .apexcharts-xaxistooltip-top:after,
        .apexcharts-xaxistooltip-top:before {
            top: 100%;
        }

        .apexcharts-xaxistooltip-top:after {
            border-top-color: #ECEFF1;
        }

        .apexcharts-xaxistooltip-top:before {
            border-top-color: #90A4AE;
        }

        .apexcharts-xaxistooltip.active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-yaxistooltip {
            opacity: 0;
            padding: 4px 10px;
            pointer-events: none;
            color: #373d3f;
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: #ECEFF1;
            border: 1px solid #90A4AE;
        }

        .apexcharts-yaxistooltip:after,
        .apexcharts-yaxistooltip:before {
            top: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .apexcharts-yaxistooltip:after {
            border-color: rgba(236, 239, 241, 0);
            border-width: 6px;
            margin-top: -6px;
        }

        .apexcharts-yaxistooltip:before {
            border-color: rgba(144, 164, 174, 0);
            border-width: 7px;
            margin-top: -7px;
        }

        .apexcharts-yaxistooltip-left:after,
        .apexcharts-yaxistooltip-left:before {
            left: 100%;
        }

        .apexcharts-yaxistooltip-left:after {
            border-left-color: #ECEFF1;
        }

        .apexcharts-yaxistooltip-left:before {
            border-left-color: #90A4AE;
        }

        .apexcharts-yaxistooltip-right:after,
        .apexcharts-yaxistooltip-right:before {
            right: 100%;
        }

        .apexcharts-yaxistooltip-right:after {
            border-right-color: #ECEFF1;
        }

        .apexcharts-yaxistooltip-right:before {
            border-right-color: #90A4AE;
        }

        .apexcharts-yaxistooltip.active {
            opacity: 1;
        }

        .apexcharts-xcrosshairs,
        .apexcharts-ycrosshairs {
            pointer-events: none;
            opacity: 0;
            transition: 0.15s ease all;
        }

        .apexcharts-xcrosshairs.active,
        .apexcharts-ycrosshairs.active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-ycrosshairs-hidden {
            opacity: 0;
        }

        .apexcharts-zoom-rect {
            pointer-events: none;
        }

        .apexcharts-selection-rect {
            cursor: move;
        }

        .svg_select_points,
        .svg_select_points_rot {
            opacity: 0;
            visibility: hidden;
        }

        .svg_select_points_l,
        .svg_select_points_r {
            cursor: ew-resize;
            opacity: 1;
            visibility: visible;
            fill: #888;
        }

        .apexcharts-canvas.zoomable .hovering-zoom {
            cursor: crosshair
        }

        .apexcharts-canvas.zoomable .hovering-pan {
            cursor: move
        }

        .apexcharts-xaxis,
        .apexcharts-yaxis {
            pointer-events: none;
        }

        .apexcharts-zoom-icon,
        .apexcharts-zoom-in-icon,
        .apexcharts-zoom-out-icon,
        .apexcharts-reset-zoom-icon,
        .apexcharts-pan-icon,
        .apexcharts-selection-icon,
        .apexcharts-menu-icon {
            cursor: pointer;
            width: 20px;
            height: 20px;
            text-align: center;
        }


        .apexcharts-zoom-icon svg,
        .apexcharts-zoom-in-icon svg,
        .apexcharts-zoom-out-icon svg,
        .apexcharts-reset-zoom-icon svg,
        .apexcharts-menu-icon svg {
            fill: #6E8192;
        }

        .apexcharts-selection-icon svg {
            fill: #444;
            transform: scale(0.86)
        }

        .apexcharts-zoom-icon.selected svg,
        .apexcharts-selection-icon.selected svg,
        .apexcharts-reset-zoom-icon.selected svg {
            fill: #008FFB;
        }

        .apexcharts-selection-icon:not(.selected):hover svg,
        .apexcharts-zoom-icon:not(.selected):hover svg,
        .apexcharts-zoom-in-icon:hover svg,
        .apexcharts-zoom-out-icon:hover svg,
        .apexcharts-reset-zoom-icon:hover svg,
        .apexcharts-menu-icon:hover svg {
            fill: #333;
        }

        .apexcharts-selection-icon,
        .apexcharts-menu-icon {
            margin-right: 3px;
            margin-left: 5px;
            position: relative;
            top: 1px;
        }

        .apexcharts-reset-zoom-icon {
            margin-left: 7px;
        }

        .apexcharts-zoom-icon {
            transform: scale(1);
        }

        .apexcharts-zoom-in-icon,
        .apexcharts-zoom-out-icon {
            transform: scale(0.8)
        }

        .apexcharts-zoom-out-icon {
            margin-right: 3px;
        }

        .apexcharts-pan-icon {
            transform: scale(0.72);
            position: relative;
            left: 1px;
            top: 0px;
        }

        .apexcharts-pan-icon svg {
            fill: #fff;
            stroke: #6E8192;
            stroke-width: 2;
        }

        .apexcharts-pan-icon.selected svg {
            stroke: #008FFB;
        }

        .apexcharts-pan-icon:not(.selected):hover svg {
            stroke: #333;
        }

        .apexcharts-toolbar {
            position: absolute;
            z-index: 11;
            top: 0px;
            right: 3px;
            max-width: 176px;
            text-align: right;
            border-radius: 3px;
            padding: 0px 6px 2px 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .apexcharts-toolbar svg {
            pointer-events: none;
        }

        .apexcharts-menu {
            background: #fff;
            position: absolute;
            top: 100%;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 3px;
            right: 10px;
            opacity: 0;
            min-width: 110px;
            transition: 0.15s ease all;
            pointer-events: none;
        }

        .apexcharts-menu.open {
            opacity: 1;
            pointer-events: all;
            transition: 0.15s ease all;
        }

        .apexcharts-menu-item {
            padding: 6px 7px;
            font-size: 12px;
            cursor: pointer;
        }

        .apexcharts-menu-item:hover {
            background: #eee;
        }

        @media screen and (min-width: 768px) {
            .apexcharts-toolbar {
                /*opacity: 0;*/
            }

            .apexcharts-canvas:hover .apexcharts-toolbar {
                opacity: 1;
            }
        }

        .apexcharts-datalabel.hidden {
            opacity: 0;
        }

        .apexcharts-pie-label,
        .apexcharts-datalabel,
        .apexcharts-datalabel-label,
        .apexcharts-datalabel-value {
            cursor: default;
            pointer-events: none;
        }

        .apexcharts-pie-label-delay {
            opacity: 0;
            animation-name: opaque;
            animation-duration: 0.3s;
            animation-fill-mode: forwards;
            animation-timing-function: ease;
        }

        .apexcharts-canvas .hidden {
            opacity: 0;
        }

        .apexcharts-hide .apexcharts-series-points {
            opacity: 0;
        }

        .apexcharts-area-series .apexcharts-series-markers .apexcharts-marker.no-pointer-events,
        .apexcharts-line-series .apexcharts-series-markers .apexcharts-marker.no-pointer-events,
        .apexcharts-radar-series path,
        .apexcharts-radar-series polygon {
            pointer-events: none;
        }

        /* markers */

        .apexcharts-marker {
            transition: 0.15s ease all;
        }

        @keyframes opaque {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
    <style type="text/css">
        .jqstooltip {
            position: absolute;
            left: 0px;
            top: 0px;
            visibility: hidden;
            background: rgb(0, 0, 0) transparent;
            background-color: rgba(0, 0, 0, 0.6);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
            color: white;
            font: 10px arial, san serif;
            text-align: left;
            white-space: nowrap;
            padding: 5px;
            border: 1px solid white;
            box-sizing: content-box;
            z-index: 10000;
        }

        .jqsfield {
            color: white;
            font: 10px arial, san serif;
            text-align: left;
        }
    </style>
    <style type="text/css">
        @font-face {
            font-weight: 400;
            font-style: normal;
            font-family: circular;

            src: url('chrome-extension://liecbddmkiiihnedobmlmillhodjkdmb/fonts/CircularXXWeb-Book.woff2') format('woff2');
        }

        @font-face {
            font-weight: 700;
            font-style: normal;
            font-family: circular;

            src: url('chrome-extension://liecbddmkiiihnedobmlmillhodjkdmb/fonts/CircularXXWeb-Bold.woff2') format('woff2');
        }
    </style>
    <link href="chrome-extension://alhgpfoeiimagjlnfekdhkjlkiomcapa/js/css/inject.css" rel="stylesheet" type="text/css"
        data-apio="true">
    <link data-apio="true" rel="stylesheet" type="text/css"
        href="chrome-extension://alhgpfoeiimagjlnfekdhkjlkiomcapa/js/css/a_chrome-extension_inject_global_module_scss.css">
    <style type="text/css">
        @keyframes resizeanim {
            from {
                opacity: 0;
            }

            to {
                opacity: 0;
            }
        }

        .resize-triggers {
            animation: 1ms resizeanim;
            visibility: hidden;
            opacity: 0;
        }

        .resize-triggers,
        .resize-triggers>div,
        .contract-trigger:before {
            content: " ";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .resize-triggers>div {
            background: #eee;
            overflow: auto;
        }

        .contract-trigger:before {
            width: 200%;
            height: 200%;
        }
    </style>
</head>

<body>
    <div class="app-container body-tabs-shadow fixed-header fixed-sidebar app-theme-gray fixed-footer">
        <div class="app-header header-shadow bg-dark header-text-light">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="ml-auto header__pane">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button"
                        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                    <ul class="header-megamenu nav">
                        <li class="nav-item">
                            <a href="javascript:void(0);" data-placement="bottom" rel="popover-focus" data-offset="300"
                                data-toggle="popover-custom" class="nav-link" data-original-title="" title="">
                                <i class="nav-link-icon pe-7s-gift"> </i> Mega Menu
                                <i class="ml-2 fa fa-angle-down opacity-5"></i>
                            </a>
                            <div class="rm-max-width">
                                <div class="d-none popover-custom-content">
                                    <div class="dropdown-mega-menu">
                                        <div class="grid-menu grid-menu-3col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6 col-xl-4">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item"> Overview</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">
                                                                <i class="nav-link-icon lnr-inbox"></i>
                                                                <span> Contacts</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">
                                                                <i class="nav-link-icon lnr-book"></i>
                                                                <span> Incidents</span>
                                                                <div class="ml-auto badge badge-pill badge-danger">5
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">
                                                                <i class="nav-link-icon lnr-picture"></i>
                                                                <span> Companies</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a disabled="" href="javascript:void(0);"
                                                                class="nav-link disabled">
                                                                <i class="nav-link-icon lnr-file-empty"></i>
                                                                <span> Dashboards</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item"> Favourites</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link"> Reports
                                                                Conversions </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link"> Quick
                                                                Start
                                                                <div class="ml-auto badge badge-success">New</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Users &amp;
                                                                Groups</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);"
                                                                class="nav-link">Proprieties</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item">Sales &amp; Marketing</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Queues </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Resource
                                                                Groups </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Goal
                                                                Metrics
                                                                <div class="ml-auto badge badge-warning">3</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);"
                                                                class="nav-link">Campaigns</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="btn-group nav-item">
                            <a class="nav-link" data-toggle="dropdown" aria-expanded="false">
                                <span class="ml-0 mr-2 badge badge-pill badge-danger">4</span> Settings
                                <i class="ml-2 fa fa-angle-down opacity-5"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-secondary">
                                        <div class="menu-header-image opacity-5"
                                            style="background-image: url(&#39;assets/images/dropdown-header/abstract2.jpg&#39;);">
                                        </div>
                                        <div class="menu-header-content">
                                            <h5 class="menu-header-title">Overview</h5>
                                            <h6 class="menu-header-subtitle">Dropdown menus for everyone</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="scroll-area-xs">
                                    <div class="scrollbar-container ps">
                                        <h6 tabindex="-1" class="dropdown-header">Key Figures</h6>
                                        <button type="button" tabindex="0" class="dropdown-item">Service
                                            Calendar</button>
                                        <button type="button" tabindex="0" class="dropdown-item">Knowledge
                                            Base</button>
                                        <button type="button" tabindex="0" class="dropdown-item">Accounts</button>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <button type="button" tabindex="0" class="dropdown-item">Products</button>
                                        <button type="button" tabindex="0" class="dropdown-item">Rollup
                                            Queries</button>
                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">
                                            </div>
                                        </div>
                                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav flex-column">
                                    <li class="nav-item-divider nav-item"></li>
                                    <li class="nav-item-btn nav-item">
                                        <button class="btn-wide btn-shadow btn btn-danger btn-sm">Cancel</button>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown nav-item">
                            <a aria-haspopup="true" data-toggle="dropdown" class="nav-link" aria-expanded="false">
                                <i class="nav-link-icon pe-7s-settings"></i> Projects
                                <i class="ml-2 fa fa-angle-down opacity-5"></i>
                            </a>
                            <div tabindex="-1" role="menu" aria-hidden="true"
                                class="dropdown-menu-rounded dropdown-menu-lg rm-pointers dropdown-menu">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-success">
                                        <div class="menu-header-image opacity-1"
                                            style="background-image: url(&#39;assets/images/dropdown-header/abstract3.jpg&#39;);">
                                        </div>
                                        <div class="text-left menu-header-content">
                                            <h5 class="menu-header-title">Overview</h5>
                                            <h6 class="menu-header-subtitle">Unlimited options</h6>
                                            <div class="menu-header-btn-pane">
                                                <button class="mr-2 btn btn-dark btn-sm">Settings</button>
                                                <button class="btn-icon btn-icon-only btn btn-warning btn-sm">
                                                    <i class="pe-7s-config btn-icon-wrapper"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <i class="dropdown-icon lnr-file-empty"></i>Graphic Design
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <i class="dropdown-icon lnr-file-empty"> </i>App Development
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <i class="dropdown-icon lnr-file-empty"> </i>Icon Design
                                </button>
                                <div tabindex="-1" class="dropdown-divider"></div>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <i class="dropdown-icon lnr-file-empty"></i>Miscellaneous
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <i class="dropdown-icon lnr-file-empty"></i>Frontend Dev
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="app-header-right">
                    <div class="header-dots">
                        <div class="dropdown">
                            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"
                                class="p-0 mr-2 btn btn-link">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-primary"></span>
                                    <i class="icon text-primary ion-android-apps"></i>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true"
                                class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-plum-plate">
                                        <div class="menu-header-image"
                                            style="background-image: url(&#39;assets/images/dropdown-header/abstract4.jpg&#39;);">
                                        </div>
                                        <div class="text-white menu-header-content">
                                            <h5 class="menu-header-title">Grid Dashboard</h5>
                                            <h6 class="menu-header-subtitle">Easy grid navigation inside dropdowns</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-menu grid-menu-xl grid-menu-3col">
                                    <div class="no-gutters row">
                                        <div class="col-sm-6 col-xl-4">
                                            <button
                                                class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                <i
                                                    class="mb-3 pe-7s-world icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg"></i>
                                                Automation
                                            </button>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <button
                                                class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                <i
                                                    class="mb-3 pe-7s-piggy icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg">
                                                </i> Reports
                                            </button>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <button
                                                class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                <i
                                                    class="mb-3 pe-7s-config icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg">
                                                </i> Settings
                                            </button>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <button
                                                class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                <i
                                                    class="mb-3 pe-7s-browser icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg">
                                                </i> Content
                                            </button>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <button
                                                class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                <i
                                                    class="mb-3 pe-7s-hourglass icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg"></i>
                                                Activity
                                            </button>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <button
                                                class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                <i
                                                    class="mb-3 pe-7s-world icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg">
                                                </i> Contacts
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav flex-column">
                                    <li class="nav-item-divider nav-item"></li>
                                    <li class="text-center nav-item-btn nav-item">
                                        <button class="btn-shadow btn btn-primary btn-sm">Follow-ups</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"
                                class="p-0 mr-2 btn btn-link">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-danger"></span>
                                    <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                                    <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true"
                                class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="mb-0 dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-deep-blue">
                                        <div class="menu-header-image opacity-1"
                                            style="background-image: url(&#39;assets/images/dropdown-header/city3.jpg&#39;);">
                                        </div>
                                        <div class="menu-header-content text-dark">
                                            <h5 class="menu-header-title">Notifications</h5>
                                            <h6 class="menu-header-subtitle">You have <b>21</b> unread messages</h6>
                                        </div>
                                    </div>
                                </div>
                                <ul
                                    class="p-3 tabs-animated-shadow tabs-animated nav nav-justified tabs-shadow-bordered">
                                    <li class="nav-item">
                                        <a role="tab" class="nav-link active" data-toggle="tab"
                                            href="https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm-variation.html#tab-messages-header">
                                            <span>Messages</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a role="tab" class="nav-link" data-toggle="tab"
                                            href="https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm-variation.html#tab-events-header">
                                            <span>Events</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a role="tab" class="nav-link" data-toggle="tab"
                                            href="https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm-variation.html#tab-errors-header">
                                            <span>System Errors</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                                        <div class="scroll-area-sm">
                                            <div class="scrollbar-container ps">
                                                <div class="p-3">
                                                    <div class="notifications-box">
                                                        <div
                                                            class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                            <div
                                                                class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                                <div><span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <h4 class="timeline-title">All Hands Meeting
                                                                        </h4>
                                                                        <span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="vertical-timeline-item dot-warning vertical-timeline-element">
                                                                <div>
                                                                    <span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <p>Yet another one, at <span
                                                                                class="text-success">15:00 PM</span>
                                                                        </p>
                                                                        <span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="vertical-timeline-item dot-success vertical-timeline-element">
                                                                <div>
                                                                    <span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <h4 class="timeline-title">Build the production
                                                                            release
                                                                            <span
                                                                                class="ml-2 badge badge-danger">NEW</span>
                                                                        </h4>
                                                                        <span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="vertical-timeline-item dot-primary vertical-timeline-element">
                                                                <div>
                                                                    <span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <h4 class="timeline-title">Something not
                                                                            important
                                                                            <div
                                                                                class="mt-2 avatar-wrapper avatar-wrapper-overlap">
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm">
                                                                                    <div class="avatar-icon">
                                                                                        <img src="{{ asset('backend') }}/1.jpg"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm">
                                                                                    <div class="avatar-icon">
                                                                                        <img src="{{ asset('backend') }}/2.jpg"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm">
                                                                                    <div class="avatar-icon">
                                                                                        <img src="{{ asset('backend') }}/3.jpg"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm">
                                                                                    <div class="avatar-icon">
                                                                                        <img src="{{ asset('backend') }}/4.jpg"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm">
                                                                                    <div class="avatar-icon">
                                                                                        <img src="{{ asset('backend') }}/5.jpg"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm">
                                                                                    <div class="avatar-icon">
                                                                                        <img src="{{ asset('backend') }}/9.jpg"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm">
                                                                                    <div class="avatar-icon">
                                                                                        <img src="{{ asset('backend') }}/7.jpg"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm">
                                                                                    <div class="avatar-icon">
                                                                                        <img src="{{ asset('backend') }}/8.jpg"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="avatar-icon-wrapper avatar-icon-sm avatar-icon-add">
                                                                                    <div class="avatar-icon"><i>+</i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </h4>
                                                                        <span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="vertical-timeline-item dot-info vertical-timeline-element">
                                                                <div>
                                                                    <span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <h4 class="timeline-title">This dot has an info
                                                                            state</h4>
                                                                        <span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                                <div>
                                                                    <span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <h4 class="timeline-title">All Hands Meeting
                                                                        </h4>
                                                                        <span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="vertical-timeline-item dot-warning vertical-timeline-element">
                                                                <div>
                                                                    <span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <p>Yet another one, at <span
                                                                                class="text-success">15:00 PM</span>
                                                                        </p><span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="vertical-timeline-item dot-success vertical-timeline-element">
                                                                <div><span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <h4 class="timeline-title">Build the production
                                                                            release
                                                                            <span
                                                                                class="ml-2 badge badge-danger">NEW</span>
                                                                        </h4>
                                                                        <span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="vertical-timeline-item dot-dark vertical-timeline-element">
                                                                <div><span
                                                                        class="vertical-timeline-element-icon bounce-in"></span>
                                                                    <div
                                                                        class="vertical-timeline-element-content bounce-in">
                                                                        <h4 class="timeline-title">This dot has a dark
                                                                            state</h4>
                                                                        <span
                                                                            class="vertical-timeline-element-date"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                    <div class="ps__thumb-x" tabindex="0"
                                                        style="left: 0px; width: 0px;"></div>
                                                </div>
                                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                    <div class="ps__thumb-y" tabindex="0"
                                                        style="top: 0px; height: 0px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-events-header" role="tabpanel">
                                        <div class="scroll-area-sm">
                                            <div class="scrollbar-container ps">
                                                <div class="p-3">
                                                    <div
                                                        class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <i
                                                                        class="badge badge-dot badge-dot-xl badge-success">
                                                                    </i>
                                                                </span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">All Hands Meeting</h4>
                                                                    <p>Lorem ipsum dolor sic amet, today at
                                                                        <a href="javascript:void(0);">12:00 PM</a>
                                                                    </p>
                                                                    <span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <i
                                                                        class="badge badge-dot badge-dot-xl badge-warning">
                                                                    </i>
                                                                </span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at <b
                                                                            class="text-danger">12:00 PM</b></p>
                                                                    <p>Yet another one, at <span
                                                                            class="text-success">15:00 PM</span></p>
                                                                    <span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <i
                                                                        class="badge badge-dot badge-dot-xl badge-danger">
                                                                    </i>
                                                                </span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">Build the production
                                                                        release</h4>
                                                                    <p>Lorem ipsum dolor sit amit,consectetur eiusmdd
                                                                        tempor incididunt ut
                                                                        labore et dolore magna elit enim at minim veniam
                                                                        quis nostrud
                                                                    </p>
                                                                    <span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <i
                                                                        class="badge badge-dot badge-dot-xl badge-primary">
                                                                    </i>
                                                                </span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title text-success">Something
                                                                        not important</h4>
                                                                    <p>Lorem ipsum dolor sit amit,consectetur elit enim
                                                                        at minim veniam quis nostrud</p>
                                                                    <span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <i
                                                                        class="badge badge-dot badge-dot-xl badge-success">
                                                                    </i>
                                                                </span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">All Hands Meeting</h4>
                                                                    <p>Lorem ipsum dolor sic amet, today at
                                                                        <a href="javascript:void(0);">12:00 PM</a>
                                                                    </p>
                                                                    <span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <i
                                                                        class="badge badge-dot badge-dot-xl badge-warning">
                                                                    </i>
                                                                </span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <p>Another meeting today, at <b
                                                                            class="text-danger">12:00 PM</b></p>
                                                                    <p>Yet another one, at <span
                                                                            class="text-success">15:00 PM</span></p>
                                                                    <span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <i
                                                                        class="badge badge-dot badge-dot-xl badge-danger">
                                                                    </i>
                                                                </span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title">Build the production
                                                                        release</h4>
                                                                    <p>Lorem ipsum dolor sit amit,consectetur eiusmdd
                                                                        tempor incididunt ut
                                                                        labore et dolore magna elit enim at minim veniam
                                                                        quis nostrud
                                                                    </p>
                                                                    <span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="vertical-timeline-item vertical-timeline-element">
                                                            <div>
                                                                <span class="vertical-timeline-element-icon bounce-in">
                                                                    <i
                                                                        class="badge badge-dot badge-dot-xl badge-primary">
                                                                    </i>
                                                                </span>
                                                                <div
                                                                    class="vertical-timeline-element-content bounce-in">
                                                                    <h4 class="timeline-title text-success">Something
                                                                        not important</h4>
                                                                    <p>Lorem ipsum dolor sit amit,consectetur elit enim
                                                                        at minim veniam quis nostrud</p>
                                                                    <span
                                                                        class="vertical-timeline-element-date"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                    <div class="ps__thumb-x" tabindex="0"
                                                        style="left: 0px; width: 0px;"></div>
                                                </div>
                                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                    <div class="ps__thumb-y" tabindex="0"
                                                        style="top: 0px; height: 0px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-errors-header" role="tabpanel">
                                        <div class="scroll-area-sm">
                                            <div class="scrollbar-container ps">
                                                <div class="pt-3 pb-0 no-results">
                                                    <div class="swal2-icon swal2-success swal2-animate-success-icon">
                                                        <div class="swal2-success-circular-line-left"
                                                            style="background-color: rgb(255, 255, 255);"></div>
                                                        <span class="swal2-success-line-tip"></span>
                                                        <span class="swal2-success-line-long"></span>
                                                        <div class="swal2-success-ring"></div>
                                                        <div class="swal2-success-fix"
                                                            style="background-color: rgb(255, 255, 255);"></div>
                                                        <div class="swal2-success-circular-line-right"
                                                            style="background-color: rgb(255, 255, 255);"></div>
                                                    </div>
                                                    <div class="results-subtitle">All caught up!</div>
                                                    <div class="results-title">There are no system errors!</div>
                                                </div>
                                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                    <div class="ps__thumb-x" tabindex="0"
                                                        style="left: 0px; width: 0px;"></div>
                                                </div>
                                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                    <div class="ps__thumb-y" tabindex="0"
                                                        style="top: 0px; height: 0px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav flex-column">
                                    <li class="nav-item-divider nav-item"></li>
                                    <li class="text-center nav-item-btn nav-item">
                                        <button class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View Latest
                                            Changes</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button type="button" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-focus"></span>
                                    <span class="language-icon opacity-8 flag large DE"></span>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true"
                                class="rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="dropdown-menu-header">
                                    <div class="pt-4 pb-4 dropdown-menu-header-inner bg-focus">
                                        <div class="menu-header-image opacity-05"
                                            style="background-image: url(&#39;assets/images/dropdown-header/city2.jpg&#39;);">
                                        </div>
                                        <div class="text-center text-white menu-header-content">
                                            <h6 class="mt-0 menu-header-subtitle"> Choose Language</h6>
                                        </div>
                                    </div>
                                </div>
                                <h6 tabindex="-1" class="dropdown-header"> Popular Languages</h6>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <span class="mr-3 opacity-8 flag large US"></span> USA
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <span class="mr-3 opacity-8 flag large CH"></span> Switzerland
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <span class="mr-3 opacity-8 flag large FR"></span> France
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <span class="mr-3 opacity-8 flag large ES"></span>Spain
                                </button>
                                <div tabindex="-1" class="dropdown-divider"></div>
                                <h6 tabindex="-1" class="dropdown-header">Others</h6>
                                <button type="button" tabindex="0" class="dropdown-item active">
                                    <span class="mr-3 opacity-8 flag large DE"></span> Germany
                                </button>
                                <button type="button" tabindex="0" class="dropdown-item">
                                    <span class="mr-3 opacity-8 flag large IT"></span> Italy
                                </button>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button type="button" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false"
                                class="p-0 btn btn-link dd-chart-btn">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-success"></span>
                                    <i class="icon text-success ion-ios-analytics"></i>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true"
                                class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-premium-dark">
                                        <div class="menu-header-image"
                                            style="background-image: url(&#39;assets/images/dropdown-header/abstract4.jpg&#39;);">
                                        </div>
                                        <div class="text-white menu-header-content">
                                            <h5 class="menu-header-title">Users Online</h5>
                                            <h6 class="menu-header-subtitle">Recent Account Activity Overview</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-chart">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg opacity-9 bg-focus"></div>
                                            <i class="text-white lnr-users"></i>
                                        </div>
                                        <div class="widget-numbers">
                                            <span>344k</span>
                                        </div>
                                        <div class="pt-2 widget-subheading">
                                            Profile views since last login
                                        </div>
                                        <div class="widget-description text-danger">
                                            <span class="pr-1"><span>176%</span></span>
                                            <i class="fa fa-arrow-left"></i>
                                        </div>
                                    </div>
                                    <div class="widget-chart-wrapper">
                                        <div id="dashboard-sparkline-carousel-3-pop"></div>
                                    </div>
                                </div>
                                <ul class="nav flex-column">
                                    <li class="mt-0 nav-item-divider nav-item"></li>
                                    <li class="text-center nav-item-btn nav-item">
                                        <button class="btn-shine btn-wide btn-pill btn btn-warning btn-sm">
                                            <i class="mr-2 fa fa-cog fa-spin"></i>View Details
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="pr-0 header-btn-lg">
                        <div class="p-0 widget-content">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            class="p-0 btn">
                                            <img width="42" class="rounded-circle"
                                                src="{{ asset('backend') }}/1.jpg"
                                                alt="">
                                            <i class="ml-2 fa fa-angle-down opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-info">
                                                    <div class="menu-header-image opacity-2"
                                                        style="background-image: url(&#39;assets/images/dropdown-header/city3.jpg&#39;);">
                                                    </div>
                                                    <div class="text-left menu-header-content">
                                                        <div class="p-0 widget-content">
                                                            <div class="widget-content-wrapper">
                                                                <div class="mr-3 widget-content-left">
                                                                    <img width="42" class="rounded-circle"
                                                                        src="{{ asset('backend') }}/1.jpg"
                                                                        alt="">
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">Alina Mcloughlin</div>
                                                                    <div class="widget-subheading opacity-8">A short
                                                                        profile description</div>
                                                                </div>
                                                                <div class="mr-2 widget-content-right">
                                                                    <button
                                                                        class="btn-pill btn-shadow btn-shine btn btn-focus">Logout</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="scroll-area-xs" style="height: 150px;">
                                                <div class="scrollbar-container ps">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item">Activity</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Chat
                                                                <div class="ml-auto badge badge-pill badge-info">8
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Recover
                                                                Password</a>
                                                        </li>
                                                        <li class="nav-item-header nav-item">My Account
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Settings
                                                                <div class="ml-auto badge badge-success">New</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Messages
                                                                <div class="ml-auto badge badge-warning">512</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Logs</a>
                                                        </li>
                                                    </ul>
                                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                        <div class="ps__thumb-x" tabindex="0"
                                                            style="left: 0px; width: 0px;"></div>
                                                    </div>
                                                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                        <div class="ps__thumb-y" tabindex="0"
                                                            style="top: 0px; height: 0px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nav flex-column">
                                                <li class="mb-0 nav-item-divider nav-item"></li>
                                            </ul>
                                            <div class="grid-menu grid-menu-2col">
                                                <div class="no-gutters row">
                                                    <div class="col-sm-6">
                                                        <button
                                                            class="pt-2 pb-2 btn-icon-vertical btn-transition btn-transition-alt btn btn-outline-warning">
                                                            <i
                                                                class="mb-2 pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper"></i>
                                                            Message Inbox
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button
                                                            class="pt-2 pb-2 btn-icon-vertical btn-transition btn-transition-alt btn btn-outline-danger">
                                                            <i
                                                                class="mb-2 pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper"></i>
                                                            <b>Support Tickets</b>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nav flex-column">
                                                <li class="nav-item-divider nav-item">
                                                </li>
                                                <li class="text-center nav-item-btn nav-item">
                                                    <button class="btn-wide btn btn-primary btn-sm"> Open Messages
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-3 widget-content-left header-user-info">
                                    <div class="widget-heading"> Alina Mclourd </div>
                                    <div class="widget-subheading"> VP People Manager </div>
                                </div>
                                <div class="ml-3 widget-content-right header-user-info">
                                    <button type="button"
                                        class="p-1 btn-shadow btn btn-primary btn-sm show-toastr-example">
                                        <i class="pl-1 pr-1 text-white fa fa-calendar"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-btn-lg">
                        <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui-theme-settings">
            <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
            </button>
            <div class="theme-settings__inner">
                <div class="scrollbar-container ps ps--active-y">
                    <div class="theme-settings__options-wrapper">
                        <h3 class="themeoptions-heading">Layout Options</h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="p-0 widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="mr-3 widget-content-left">
                                                <div class="switch has-switch switch-container-class"
                                                    data-class="fixed-header">
                                                    <div class="switch-animate switch-on">
                                                        <div class="toggle btn btn-success" data-toggle="toggle"
                                                            role="button" style="width: 56.5px; height: 33.1875px;">
                                                            <input type="checkbox" checked=""
                                                                data-toggle="toggle" data-onstyle="success">
                                                            <div class="toggle-group"><label for=""
                                                                    class="btn btn-success toggle-on">On</label><label
                                                                    for=""
                                                                    class="btn btn-light toggle-off">Off</label><span
                                                                    class="toggle-handle btn btn-light"></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Header</div>
                                                <div class="widget-subheading">Makes the header top fixed, always
                                                    visible!</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="p-0 widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="mr-3 widget-content-left">
                                                <div class="switch has-switch switch-container-class"
                                                    data-class="fixed-sidebar">
                                                    <div class="switch-animate switch-on">
                                                        <div class="toggle btn btn-success" data-toggle="toggle"
                                                            role="button" style="width: 56.5px; height: 33.1875px;">
                                                            <input type="checkbox" checked=""
                                                                data-toggle="toggle" data-onstyle="success">
                                                            <div class="toggle-group"><label for=""
                                                                    class="btn btn-success toggle-on">On</label><label
                                                                    for=""
                                                                    class="btn btn-light toggle-off">Off</label><span
                                                                    class="toggle-handle btn btn-light"></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Sidebar</div>
                                                <div class="widget-subheading">Makes the sidebar left fixed, always
                                                    visible!</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="p-0 widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="mr-3 widget-content-left">
                                                <div class="switch has-switch switch-container-class active"
                                                    data-class="fixed-footer">
                                                    <div class="switch-animate switch-off">
                                                        <div class="toggle btn btn-success" data-toggle="toggle"
                                                            role="button" style="width: 56.5px; height: 33.1875px;">
                                                            <input type="checkbox" data-toggle="toggle"
                                                                data-onstyle="success">
                                                            <div class="toggle-group"><label for=""
                                                                    class="btn btn-success toggle-on">On</label><label
                                                                    for=""
                                                                    class="btn btn-light toggle-off">Off</label><span
                                                                    class="toggle-handle btn btn-light"></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Footer</div>
                                                <div class="widget-subheading">Makes the app footer bottom fixed,
                                                    always visible!</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div> Header Options </div>
                            <button type="button"
                                class="ml-auto btn-pill btn-shadow btn-wide btn btn-focus btn-sm switch-header-cs-class"
                                data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme</h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-header-cs-class"
                                            data-class="bg-primary header-text-light"></div>
                                        <div class="swatch-holder bg-secondary switch-header-cs-class"
                                            data-class="bg-secondary header-text-light"></div>
                                        <div class="swatch-holder bg-success switch-header-cs-class"
                                            data-class="bg-success header-text-light"></div>
                                        <div class="swatch-holder bg-info switch-header-cs-class"
                                            data-class="bg-info header-text-light"></div>
                                        <div class="swatch-holder bg-warning switch-header-cs-class"
                                            data-class="bg-warning header-text-dark"></div>
                                        <div class="swatch-holder bg-danger switch-header-cs-class"
                                            data-class="bg-danger header-text-light"></div>
                                        <div class="swatch-holder bg-light switch-header-cs-class"
                                            data-class="bg-light header-text-dark"></div>
                                        <div class="swatch-holder bg-dark switch-header-cs-class active"
                                            data-class="bg-dark header-text-light"></div>
                                        <div class="swatch-holder bg-focus switch-header-cs-class"
                                            data-class="bg-focus header-text-light"></div>
                                        <div class="swatch-holder bg-alternate switch-header-cs-class"
                                            data-class="bg-alternate header-text-light"></div>
                                        <div class="divider"></div>
                                        <div class="swatch-holder bg-vicious-stance switch-header-cs-class"
                                            data-class="bg-vicious-stance header-text-light"></div>
                                        <div class="swatch-holder bg-midnight-bloom switch-header-cs-class"
                                            data-class="bg-midnight-bloom header-text-light"></div>
                                        <div class="swatch-holder bg-night-sky switch-header-cs-class"
                                            data-class="bg-night-sky header-text-light"></div>
                                        <div class="swatch-holder bg-slick-carbon switch-header-cs-class"
                                            data-class="bg-slick-carbon header-text-light"></div>
                                        <div class="swatch-holder bg-asteroid switch-header-cs-class"
                                            data-class="bg-asteroid header-text-light"></div>
                                        <div class="swatch-holder bg-royal switch-header-cs-class"
                                            data-class="bg-royal header-text-light"></div>
                                        <div class="swatch-holder bg-warm-flame switch-header-cs-class"
                                            data-class="bg-warm-flame header-text-dark"></div>
                                        <div class="swatch-holder bg-night-fade switch-header-cs-class"
                                            data-class="bg-night-fade header-text-dark"></div>
                                        <div class="swatch-holder bg-sunny-morning switch-header-cs-class"
                                            data-class="bg-sunny-morning header-text-dark"></div>
                                        <div class="swatch-holder bg-tempting-azure switch-header-cs-class"
                                            data-class="bg-tempting-azure header-text-dark"></div>
                                        <div class="swatch-holder bg-amy-crisp switch-header-cs-class"
                                            data-class="bg-amy-crisp header-text-dark"></div>
                                        <div class="swatch-holder bg-heavy-rain switch-header-cs-class"
                                            data-class="bg-heavy-rain header-text-dark"></div>
                                        <div class="swatch-holder bg-mean-fruit switch-header-cs-class"
                                            data-class="bg-mean-fruit header-text-dark"></div>
                                        <div class="swatch-holder bg-malibu-beach switch-header-cs-class"
                                            data-class="bg-malibu-beach header-text-light"></div>
                                        <div class="swatch-holder bg-deep-blue switch-header-cs-class"
                                            data-class="bg-deep-blue header-text-dark"></div>
                                        <div class="swatch-holder bg-ripe-malin switch-header-cs-class"
                                            data-class="bg-ripe-malin header-text-light"></div>
                                        <div class="swatch-holder bg-arielle-smile switch-header-cs-class"
                                            data-class="bg-arielle-smile header-text-light"></div>
                                        <div class="swatch-holder bg-plum-plate switch-header-cs-class"
                                            data-class="bg-plum-plate header-text-light"></div>
                                        <div class="swatch-holder bg-happy-fisher switch-header-cs-class"
                                            data-class="bg-happy-fisher header-text-dark"></div>
                                        <div class="swatch-holder bg-happy-itmeo switch-header-cs-class"
                                            data-class="bg-happy-itmeo header-text-light"></div>
                                        <div class="swatch-holder bg-mixed-hopes switch-header-cs-class"
                                            data-class="bg-mixed-hopes header-text-light"></div>
                                        <div class="swatch-holder bg-strong-bliss switch-header-cs-class"
                                            data-class="bg-strong-bliss header-text-light"></div>
                                        <div class="swatch-holder bg-grow-early switch-header-cs-class"
                                            data-class="bg-grow-early header-text-light"></div>
                                        <div class="swatch-holder bg-love-kiss switch-header-cs-class"
                                            data-class="bg-love-kiss header-text-light"></div>
                                        <div class="swatch-holder bg-premium-dark switch-header-cs-class"
                                            data-class="bg-premium-dark header-text-light"></div>
                                        <div class="swatch-holder bg-happy-green switch-header-cs-class"
                                            data-class="bg-happy-green header-text-light"></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Sidebar Options</div>
                            <button type="button"
                                class="ml-auto btn-pill btn-shadow btn-wide btn btn-focus btn-sm switch-sidebar-cs-class"
                                data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <!--<li class="list-group-item">
                                    <div class="p-0 widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="mr-3 widget-content-left">
                                                <div class="switch has-switch" data-on-label="ON" data-off-label="OFF">
                                                    <div class="switch-animate switch-off">
                                                        <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Sidebar Background Image
                                                </div>
                                                <div class="widget-subheading">Enable background images for sidebar!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>-->
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme</h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-sidebar-cs-class"
                                            data-class="bg-primary sidebar-text-light"></div>
                                        <div class="swatch-holder bg-secondary switch-sidebar-cs-class"
                                            data-class="bg-secondary sidebar-text-light"></div>
                                        <div class="swatch-holder bg-success switch-sidebar-cs-class"
                                            data-class="bg-success sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-info switch-sidebar-cs-class"
                                            data-class="bg-info sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-warning switch-sidebar-cs-class"
                                            data-class="bg-warning sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-danger switch-sidebar-cs-class"
                                            data-class="bg-danger sidebar-text-light"></div>
                                        <div class="swatch-holder bg-light switch-sidebar-cs-class"
                                            data-class="bg-light sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-dark switch-sidebar-cs-class"
                                            data-class="bg-dark sidebar-text-light"></div>
                                        <div class="swatch-holder bg-focus switch-sidebar-cs-class"
                                            data-class="bg-focus sidebar-text-light"></div>
                                        <div class="swatch-holder bg-alternate switch-sidebar-cs-class"
                                            data-class="bg-alternate sidebar-text-light"></div>
                                        <div class="divider"></div>
                                        <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class"
                                            data-class="bg-vicious-stance sidebar-text-light"></div>
                                        <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class"
                                            data-class="bg-midnight-bloom sidebar-text-light"></div>
                                        <div class="swatch-holder bg-night-sky switch-sidebar-cs-class"
                                            data-class="bg-night-sky sidebar-text-light"></div>
                                        <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class"
                                            data-class="bg-slick-carbon sidebar-text-light"></div>
                                        <div class="swatch-holder bg-asteroid switch-sidebar-cs-class"
                                            data-class="bg-asteroid sidebar-text-light"></div>
                                        <div class="swatch-holder bg-royal switch-sidebar-cs-class"
                                            data-class="bg-royal sidebar-text-light"></div>
                                        <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class"
                                            data-class="bg-warm-flame sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-night-fade switch-sidebar-cs-class"
                                            data-class="bg-night-fade sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class"
                                            data-class="bg-sunny-morning sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class"
                                            data-class="bg-tempting-azure sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class"
                                            data-class="bg-amy-crisp sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class"
                                            data-class="bg-heavy-rain sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class"
                                            data-class="bg-mean-fruit sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class"
                                            data-class="bg-malibu-beach sidebar-text-light"></div>
                                        <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class"
                                            data-class="bg-deep-blue sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class"
                                            data-class="bg-ripe-malin sidebar-text-light"></div>
                                        <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class"
                                            data-class="bg-arielle-smile sidebar-text-light"></div>
                                        <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class"
                                            data-class="bg-plum-plate sidebar-text-light"></div>
                                        <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class"
                                            data-class="bg-happy-fisher sidebar-text-dark"></div>
                                        <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class"
                                            data-class="bg-happy-itmeo sidebar-text-light"></div>
                                        <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class"
                                            data-class="bg-mixed-hopes sidebar-text-light"></div>
                                        <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class"
                                            data-class="bg-strong-bliss sidebar-text-light"></div>
                                        <div class="swatch-holder bg-grow-early switch-sidebar-cs-class"
                                            data-class="bg-grow-early sidebar-text-light"></div>
                                        <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class"
                                            data-class="bg-love-kiss sidebar-text-light"></div>
                                        <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class"
                                            data-class="bg-premium-dark sidebar-text-light"></div>
                                        <div class="swatch-holder bg-happy-green switch-sidebar-cs-class"
                                            data-class="bg-happy-green sidebar-text-light"></div>
                                    </div>
                                </li>
                                <!--<li class="theme-settings-swatches d-none list-group-item">
                                    <div class="p-0 widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Background Opacity
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div role="group" class="btn-group-sm btn-group">
                                                    <button type="button" class="btn-shadow opacity-3 active btn btn-primary">4%
                                                    </button>
                                                    <button type="button" class="btn-shadow opacity-4 btn btn-primary">6%
                                                    </button>
                                                    <button type="button" class="btn-shadow opacity-5 btn btn-primary">8%
                                                    </button>
                                                    <button type="button" class="btn-shadow opacity-6 btn btn-primary">10%
                                                    </button>
                                                    <button type="button" class="btn-shadow opacity-7 btn btn-primary">15%
                                                    </button>
                                                    <button type="button" class="btn-shadow opacity-8 btn btn-primary">20%
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>-->
                                <!--<li class="theme-settings-swatches d-none list-group-item">
                                    <h5>Sidebar Image Background
                                    </h5>
                                    <div class="divider">
                                    </div>
                                    <div class="swatch-holder swatch-holder-img active">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/city1.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/city2.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/city3.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/city4.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/city5.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/abstract1.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/abstract2.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/abstract3.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/abstract4.jpg">
                                        </a>
                                    </div>
                                    <div class="swatch-holder swatch-holder-img">
                                        <a class="img-holder switch-trigger">
                                            <img alt=" " src="assets/images/sidebar/abstract5.jpg">
                                        </a>
                                    </div>
                                </li>-->
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Main Content Options</div>
                            <button type="button"
                                class="ml-auto btn-pill btn-shadow btn-wide active btn btn-focus btn-sm">Restore
                                Default</button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <!--<li class="list-group-item">
                                    <div class="p-0 widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="mr-3 widget-content-left">
                                                <div class="switch has-switch" data-on-label="ON" data-off-label="OFF">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Page Title Icon
                                                </div>
                                                <div class="widget-subheading">Enable the icon box for page titles!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="p-0 widget-content">
                                        <div class="widget-content-wrapper">
                                            <div class="mr-3 widget-content-left">
                                                <div class="switch has-switch" data-on-label="ON" data-off-label="OFF">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Page Title Description
                                                </div>
                                                <div class="widget-subheading">Enable the description below page title!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>-->
                                <li class="list-group-item">
                                    <h5 class="pb-2">Page Section Tabs</h5>
                                    <div class="theme-settings-swatches">
                                        <div role="group" class="mt-2 btn-group">
                                            <button type="button"
                                                class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class"
                                                data-class="body-tabs-line"> Line</button>
                                            <button type="button"
                                                class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class"
                                                data-class="body-tabs-shadow"> Shadow </button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <h5 class="pb-2">Light Color Schemes
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div role="group" class="mt-2 btn-group">
                                            <button type="button"
                                                class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class"
                                                data-class="app-theme-white"> White Theme</button>
                                            <button type="button"
                                                class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class active"
                                                data-class="app-theme-gray"> Gray Theme</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; height: 607px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 314px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="ml-auto header__pane">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar ps ps--active-y">
                    <div class="app-sidebar__inner">
                        @include('layouts.backend.sidebar')
                    </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; height: 547px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 295px;"></div>
                    </div>
                </div>
            </div>
            <div class="app-main__outer">
                <div class="app-main__inner">

                    @yield('content')
                </div>
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-left">
                                <div class="footer-dots">
                                    <div class="dropdown">
                                        <a aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"
                                            class="dot-btn-wrapper">
                                            <i class="dot-btn-icon lnr-bullhorn icon-gradient bg-mean-fruit"></i>
                                            <div class="badge badge-dot badge-abs badge-dot-sm badge-danger">
                                                Notifications</div>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu-xl rm-pointers dropdown-menu">
                                            <div class="mb-0 dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-deep-blue">
                                                    <div class="menu-header-image opacity-1"
                                                        style="background-image: url(&#39;assets/images/dropdown-header/city3.jpg&#39;);">
                                                    </div>
                                                    <div class="menu-header-content text-dark">
                                                        <h5 class="menu-header-title">Notifications</h5>
                                                        <h6 class="menu-header-subtitle">You have <b>21</b> unread
                                                            messages</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul
                                                class="p-3 tabs-animated-shadow tabs-animated nav nav-justified tabs-shadow-bordered">
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link active" data-toggle="tab"
                                                        href="https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm-variation.html#tab-messages-header1">
                                                        <span>Messages</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link" data-toggle="tab"
                                                        href="https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm-variation.html#tab-events-header1">
                                                        <span>Events</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a role="tab" class="nav-link" data-toggle="tab"
                                                        href="https://demo.dashboardpack.com/architectui-html-pro/dashboards-crm-variation.html#tab-errors-header1">
                                                        <span>System Errors</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-messages-header1"
                                                    role="tabpanel">
                                                    <div class="scroll-area-sm">
                                                        <div class="scrollbar-container ps">
                                                            <div class="p-3">
                                                                <div class="notifications-box">
                                                                    <div
                                                                        class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                                                                        <div
                                                                            class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">All
                                                                                        Hands Meeting</h4>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="vertical-timeline-item dot-warning vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <p>Yet another one, at
                                                                                        <span
                                                                                            class="text-success">15:00
                                                                                            PM</span>
                                                                                    </p>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="vertical-timeline-item dot-success vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">Build
                                                                                        the production release
                                                                                        <span
                                                                                            class="ml-2 badge badge-danger">NEW</span>
                                                                                    </h4>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="vertical-timeline-item dot-primary vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">
                                                                                        Something not important
                                                                                        <div
                                                                                            class="mt-2 avatar-wrapper avatar-wrapper-overlap">
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <img src="{{ asset('backend') }}/1.jpg"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <img src="{{ asset('backend') }}/2.jpg"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <img src="{{ asset('backend') }}/3.jpg"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <img src="{{ asset('backend') }}/4.jpg"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <img src="{{ asset('backend') }}/5.jpg"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <img src="{{ asset('backend') }}/9.jpg"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <img src="{{ asset('backend') }}/7.jpg"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <img src="{{ asset('backend') }}/8.jpg"
                                                                                                        alt="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div
                                                                                                class="avatar-icon-wrapper avatar-icon-sm avatar-icon-add">
                                                                                                <div
                                                                                                    class="avatar-icon">
                                                                                                    <i>+</i></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </h4>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="vertical-timeline-item dot-info vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">This
                                                                                        dot has an info state</h4>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">All
                                                                                        Hands Meeting</h4>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="vertical-timeline-item dot-warning vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <p>Yet another one, at
                                                                                        <span
                                                                                            class="text-success">15:00
                                                                                            PM</span>
                                                                                    </p>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="vertical-timeline-item dot-success vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">Build
                                                                                        the production release
                                                                                        <span
                                                                                            class="ml-2 badge badge-danger">NEW</span>
                                                                                    </h4>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="vertical-timeline-item dot-dark vertical-timeline-element">
                                                                            <div>
                                                                                <span
                                                                                    class="vertical-timeline-element-icon bounce-in"></span>
                                                                                <div
                                                                                    class="vertical-timeline-element-content bounce-in">
                                                                                    <h4 class="timeline-title">This
                                                                                        dot has a dark state</h4>
                                                                                    <span
                                                                                        class="vertical-timeline-element-date"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                                <div class="ps__thumb-x" tabindex="0"
                                                                    style="left: 0px; width: 0px;"></div>
                                                            </div>
                                                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                                <div class="ps__thumb-y" tabindex="0"
                                                                    style="top: 0px; height: 0px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab-events-header1" role="tabpanel">
                                                    <div class="scroll-area-sm">
                                                        <div class="scrollbar-container ps">
                                                            <div class="p-3">
                                                                <div
                                                                    class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                                    <div
                                                                        class="vertical-timeline-item vertical-timeline-element">
                                                                        <div>
                                                                            <span
                                                                                class="vertical-timeline-element-icon bounce-in">
                                                                                <i
                                                                                    class="badge badge-dot badge-dot-xl badge-success"></i>
                                                                            </span>
                                                                            <div
                                                                                class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title">All Hands
                                                                                    Meeting</h4>
                                                                                <p>Lorem ipsum dolor sic amet, today at
                                                                                    <a href="javascript:void(0);">12:00
                                                                                        PM</a>
                                                                                </p>
                                                                                <span
                                                                                    class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="vertical-timeline-item vertical-timeline-element">
                                                                        <div>
                                                                            <span
                                                                                class="vertical-timeline-element-icon bounce-in">
                                                                                <i
                                                                                    class="badge badge-dot badge-dot-xl badge-warning"></i>
                                                                            </span>
                                                                            <div
                                                                                class="vertical-timeline-element-content bounce-in">
                                                                                <p>Another meeting today, at
                                                                                    <b class="text-danger">12:00
                                                                                        PM</b>
                                                                                </p>
                                                                                <p>Yet another one, at <span
                                                                                        class="text-success">15:00
                                                                                        PM</span></p>
                                                                                <span
                                                                                    class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="vertical-timeline-item vertical-timeline-element">
                                                                        <div>
                                                                            <span
                                                                                class="vertical-timeline-element-icon bounce-in">
                                                                                <i
                                                                                    class="badge badge-dot badge-dot-xl badge-danger"></i>
                                                                            </span>
                                                                            <div
                                                                                class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title">Build the
                                                                                    production release</h4>
                                                                                <p>Lorem ipsum dolor sit
                                                                                    amit,consectetur eiusmdd tempor
                                                                                    incididunt ut labore et dolore magna
                                                                                    elit enim at
                                                                                    minim veniam quis nostrud
                                                                                </p>
                                                                                <span
                                                                                    class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="vertical-timeline-item vertical-timeline-element">
                                                                        <div>
                                                                            <span
                                                                                class="vertical-timeline-element-icon bounce-in">
                                                                                <i
                                                                                    class="badge badge-dot badge-dot-xl badge-primary"></i>
                                                                            </span>
                                                                            <div
                                                                                class="vertical-timeline-element-content bounce-in">
                                                                                <h4
                                                                                    class="timeline-title text-success">
                                                                                    Something not important</h4>
                                                                                <p>Lorem ipsum dolor sit
                                                                                    amit,consectetur elit enim at
                                                                                    minim veniam quis nostrud</p>
                                                                                <span
                                                                                    class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="vertical-timeline-item vertical-timeline-element">
                                                                        <div>
                                                                            <span
                                                                                class="vertical-timeline-element-icon bounce-in">
                                                                                <i
                                                                                    class="badge badge-dot badge-dot-xl badge-success"></i>
                                                                            </span>
                                                                            <div
                                                                                class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title">All Hands
                                                                                    Meeting</h4>
                                                                                <p>Lorem ipsum dolor sic amet, today at
                                                                                    <a href="javascript:void(0);">12:00
                                                                                        PM</a>
                                                                                </p>
                                                                                <span
                                                                                    class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="vertical-timeline-item vertical-timeline-element">
                                                                        <div>
                                                                            <span
                                                                                class="vertical-timeline-element-icon bounce-in">
                                                                                <i
                                                                                    class="badge badge-dot badge-dot-xl badge-warning"></i>
                                                                            </span>
                                                                            <div
                                                                                class="vertical-timeline-element-content bounce-in">
                                                                                <p>Another meeting today, at
                                                                                    <b class="text-danger">12:00
                                                                                        PM</b>
                                                                                </p>
                                                                                <p>Yet another one, at <span
                                                                                        class="text-success">15:00
                                                                                        PM</span></p>
                                                                                <span
                                                                                    class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="vertical-timeline-item vertical-timeline-element">
                                                                        <div>
                                                                            <span
                                                                                class="vertical-timeline-element-icon bounce-in">
                                                                                <i
                                                                                    class="badge badge-dot badge-dot-xl badge-danger"></i>
                                                                            </span>
                                                                            <div
                                                                                class="vertical-timeline-element-content bounce-in">
                                                                                <h4 class="timeline-title">Build the
                                                                                    production release</h4>
                                                                                <p>Lorem ipsum dolor sit
                                                                                    amit,consectetur eiusmdd tempor
                                                                                    incididunt ut labore et dolore magna
                                                                                    elit enim at
                                                                                    minim veniam quis nostrud
                                                                                </p>
                                                                                <span
                                                                                    class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="vertical-timeline-item vertical-timeline-element">
                                                                        <div>
                                                                            <span
                                                                                class="vertical-timeline-element-icon bounce-in">
                                                                                <i
                                                                                    class="badge badge-dot badge-dot-xl badge-primary"></i>
                                                                            </span>
                                                                            <div
                                                                                class="vertical-timeline-element-content bounce-in">
                                                                                <h4
                                                                                    class="timeline-title text-success">
                                                                                    Something not important</h4>
                                                                                <p>Lorem ipsum dolor sit
                                                                                    amit,consectetur elit enim at
                                                                                    minim veniam quis nostrud
                                                                                </p>
                                                                                <span
                                                                                    class="vertical-timeline-element-date"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                                <div class="ps__thumb-x" tabindex="0"
                                                                    style="left: 0px; width: 0px;"></div>
                                                            </div>
                                                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                                <div class="ps__thumb-y" tabindex="0"
                                                                    style="top: 0px; height: 0px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab-errors-header1" role="tabpanel">
                                                    <div class="scroll-area-sm">
                                                        <div class="scrollbar-container ps">
                                                            <div class="pt-3 pb-0 no-results">
                                                                <div
                                                                    class="swal2-icon swal2-success swal2-animate-success-icon">
                                                                    <div class="swal2-success-circular-line-left"
                                                                        style="background-color: rgb(255, 255, 255);">
                                                                    </div>
                                                                    <span class="swal2-success-line-tip"></span>
                                                                    <span class="swal2-success-line-long"></span>
                                                                    <div class="swal2-success-ring"></div>
                                                                    <div class="swal2-success-fix"
                                                                        style="background-color: rgb(255, 255, 255);">
                                                                    </div>
                                                                    <div class="swal2-success-circular-line-right"
                                                                        style="background-color: rgb(255, 255, 255);">
                                                                    </div>
                                                                </div>
                                                                <div class="results-subtitle">All caught up!</div>
                                                                <div class="results-title">There are no system errors!
                                                                </div>
                                                            </div>
                                                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                                <div class="ps__thumb-x" tabindex="0"
                                                                    style="left: 0px; width: 0px;"></div>
                                                            </div>
                                                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                                <div class="ps__thumb-y" tabindex="0"
                                                                    style="top: 0px; height: 0px;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nav flex-column">
                                                <li class="nav-item-divider nav-item"></li>
                                                <li class="text-center nav-item-btn nav-item">
                                                    <button
                                                        class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View
                                                        Latest Changes</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="dots-separator"></div>
                                    <div class="dropdown">
                                        <a class="dot-btn-wrapper" aria-haspopup="true" data-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="dot-btn-icon lnr-earth icon-gradient bg-happy-itmeo"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="rm-pointers dropdown-menu">
                                            <div class="dropdown-menu-header">
                                                <div class="pt-4 pb-4 dropdown-menu-header-inner bg-focus">
                                                    <div class="menu-header-image opacity-05"
                                                        style="background-image: url(&#39;assets/images/dropdown-header/city2.jpg&#39;);">
                                                    </div>
                                                    <div class="text-center text-white menu-header-content">
                                                        <h6 class="mt-0 menu-header-subtitle"> Choose Language</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 tabindex="-1" class="dropdown-header"> Popular Languages</h6>
                                            <button type="button" tabindex="0" class="dropdown-item">
                                                <span class="mr-3 opacity-8 flag large US"></span> USA
                                            </button>
                                            <button type="button" tabindex="0" class="dropdown-item">
                                                <span class="mr-3 opacity-8 flag large CH"></span> Switzerland
                                            </button>
                                            <button type="button" tabindex="0" class="dropdown-item">
                                                <span class="mr-3 opacity-8 flag large FR"></span>France
                                            </button>
                                            <button type="button" tabindex="0" class="dropdown-item">
                                                <span class="mr-3 opacity-8 flag large ES"></span>Spain
                                            </button>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <h6 tabindex="-1" class="dropdown-header">Others</h6>
                                            <button type="button" tabindex="0" class="dropdown-item active">
                                                <span class="mr-3 opacity-8 flag large DE"></span>Germany
                                            </button>
                                            <button type="button" tabindex="0" class="dropdown-item">
                                                <span class="mr-3 opacity-8 flag large IT"></span> Italy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="dots-separator"></div>
                                    <div class="dropdown">
                                        <a class="dot-btn-wrapper dd-chart-btn-2" aria-haspopup="true"
                                            data-toggle="dropdown" aria-expanded="false">
                                            <i class="dot-btn-icon lnr-pie-chart icon-gradient bg-love-kiss"></i>
                                            <div class="badge badge-dot badge-abs badge-dot-sm badge-warning">
                                                Notifications</div>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true"
                                            class="dropdown-menu-xl rm-pointers dropdown-menu">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-premium-dark">
                                                    <div class="menu-header-image"
                                                        style="background-image: url(&#39;assets/images/dropdown-header/abstract4.jpg&#39;);">
                                                    </div>
                                                    <div class="text-white menu-header-content">
                                                        <h5 class="menu-header-title">Users Online</h5>
                                                        <h6 class="menu-header-subtitle">Recent Account Activity
                                                            Overview</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-chart">
                                                <div class="widget-chart-content">
                                                    <div class="icon-wrapper rounded-circle">
                                                        <div class="icon-wrapper-bg opacity-9 bg-focus"></div>
                                                        <i class="text-white lnr-users"></i>
                                                    </div>
                                                    <div class="widget-numbers">
                                                        <span>344k</span>
                                                    </div>
                                                    <div class="pt-2 widget-subheading"> Profile views since last
                                                        login</div>
                                                    <div class="widget-description text-danger">
                                                        <span class="pr-1"> <span>176%</span></span>
                                                        <i class="fa fa-arrow-left"></i>
                                                    </div>
                                                </div>
                                                <div class="widget-chart-wrapper">
                                                    <div id="dashboard-sparkline-carousel-4-pop"></div>
                                                </div>
                                            </div>
                                            <ul class="nav flex-column">
                                                <li class="mt-0 nav-item-divider nav-item"></li>
                                                <li class="text-center nav-item-btn nav-item">
                                                    <button
                                                        class="btn-shine btn-wide btn-pill btn btn-warning btn-sm">
                                                        <i class="mr-2 fa fa-cog fa-spin"></i> View Details
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="app-footer-right">
                                <ul class="header-megamenu nav">
                                    <li class="nav-item">
                                        <a data-placement="top" rel="popover-focus" data-offset="300"
                                            data-toggle="popover-custom" class="nav-link" data-original-title=""
                                            title="">
                                            Footer Menu
                                            <i class="ml-2 fa fa-angle-up opacity-8"></i>
                                        </a>
                                        <div class="rm-max-width rm-pointers">
                                            <div class="d-none popover-custom-content">
                                                <div class="dropdown-mega-menu dropdown-mega-menu-sm">
                                                    <div class="grid-menu grid-menu-2col">
                                                        <div class="no-gutters row">
                                                            <div class="col-sm-6 col-xl-6">
                                                                <ul class="nav flex-column">
                                                                    <li class="nav-item-header nav-item">Overview</li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link">
                                                                            <i class="nav-link-icon lnr-inbox"></i>
                                                                            <span>Contacts</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link">
                                                                            <i class="nav-link-icon lnr-book"></i>
                                                                            <span>Incidents</span>
                                                                            <div
                                                                                class="ml-auto badge badge-pill badge-danger">
                                                                                5</div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link">
                                                                            <i class="nav-link-icon lnr-picture"></i>
                                                                            <span>Companies</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a disabled="" class="nav-link disabled">
                                                                            <i
                                                                                class="nav-link-icon lnr-file-empty"></i>
                                                                            <span>Dashboards</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-sm-6 col-xl-6">
                                                                <ul class="nav flex-column">
                                                                    <li class="nav-item-header nav-item">Sales &amp;
                                                                        Marketing</li>
                                                                    <li class="nav-item"><a
                                                                            class="nav-link">Queues</a></li>
                                                                    <li class="nav-item"><a
                                                                            class="nav-link">Resource Groups</a></li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link">Goal Metrics
                                                                            <div class="ml-auto badge badge-warning">3
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item"><a
                                                                            class="nav-link">Campaigns</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a data-placement="top" rel="popover-focus" data-offset="300"
                                            data-toggle="popover-custom" class="nav-link" data-original-title=""
                                            title="">
                                            Grid Menu
                                            <div class="ml-0 ml-1 badge badge-dark">
                                                <small>NEW</small>
                                            </div>
                                            <i class="ml-2 fa fa-angle-up opacity-8"></i>
                                        </a>
                                        <div class="rm-max-width rm-pointers">
                                            <div class="d-none popover-custom-content">
                                                <div class="dropdown-menu-header">
                                                    <div class="dropdown-menu-header-inner bg-tempting-azure">
                                                        <div class="menu-header-image opacity-1"
                                                            style="background-image: url(&#39;assets/images/dropdown-header/city5.jpg&#39;);">
                                                        </div>
                                                        <div class="menu-header-content text-dark">
                                                            <h5 class="menu-header-title">Two Column Grid</h5>
                                                            <h6 class="menu-header-subtitle">Easy grid navigation
                                                                inside popovers</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="grid-menu grid-menu-2col">
                                                    <div class="no-gutters row">
                                                        <div class="col-sm-6">
                                                            <button
                                                                class="pt-2 pb-2 btn-icon-vertical btn-transition-text btn-transition btn-transition-alt btn btn-outline-dark">
                                                                <i
                                                                    class="mb-2 lnr-lighter text-dark opacity-7 btn-icon-wrapper"></i>Automation
                                                            </button>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button
                                                                class="pt-2 pb-2 btn-icon-vertical btn-transition-text btn-transition btn-transition-alt btn btn-outline-danger">
                                                                <i
                                                                    class="mb-2 lnr-construction text-danger opacity-7 btn-icon-wrapper"></i>Reports
                                                            </button>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button
                                                                class="pt-2 pb-2 btn-icon-vertical btn-transition-text btn-transition btn-transition-alt btn btn-outline-success">
                                                                <i
                                                                    class="mb-2 lnr-bus text-success opacity-7 btn-icon-wrapper"></i>Activity
                                                            </button>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button
                                                                class="pt-2 pb-2 btn-icon-vertical btn-transition-text btn-transition btn-transition-alt btn btn-outline-focus">
                                                                <i
                                                                    class="mb-2 lnr-gift text-focus opacity-7 btn-icon-wrapper"></i>Settings
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="nav flex-column">
                                                    <li class="nav-item-divider nav-item"></li>
                                                    <li class="clearfix nav-item-btn nav-item">
                                                        <div class="float-left">
                                                            <button class="btn btn-link btn-sm">Link Button</button>
                                                        </div>
                                                        <div class="float-right">
                                                            <button class="btn-shadow btn btn-info btn-sm">Info
                                                                Button</button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-drawer-wrapper">
        <div class="drawer-nav-btn">
            <button type="button" class="hamburger hamburger--elastic is-active">
                <span class="hamburger-box"><span class="hamburger-inner"></span></span>
            </button>
        </div>
        <div class="drawer-content-wrapper">
            <div class="scrollbar-container ps ps--active-y">
                <h3 class="drawer-heading">Servers Status</h3>
                <div class="drawer-section">
                    <div class="row">
                        <div class="col">
                            <div class="progress-box">
                                <h4>Server Load 1</h4>
                                <div class="mx-auto circle-progress circle-progress-gradient-xl"><canvas
                                        width="114" height="114"></canvas>
                                    <small><span class="fsize-2">51%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-box">
                                <h4>Server Load 2</h4>
                                <div class="mx-auto circle-progress circle-progress-success-xl"><canvas
                                        width="114" height="114"></canvas>
                                    <small><span class="fsize-2">16%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-box">
                                <h4>Server Load 3</h4>
                                <div class="mx-auto circle-progress circle-progress-danger-xl"><canvas
                                        width="114" height="114"></canvas>
                                    <small><span class="fsize-2">51%<span></span></span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="mt-3" style="position: relative;">
                        <h5 class="text-center card-title">Live Statistics</h5>
                        <div id="sparkline-carousel-3" style="min-height: 120px;">
                            <div id="apexchartsmo8vkhc4" class="apexcharts-canvas apexchartsmo8vkhc4"
                                style="width: 402px; height: 120px;"><svg id="SvgjsSvg1337" width="402"
                                    height="120" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                                    class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                    style="background: transparent;">
                                    <g id="SvgjsG1339" class="apexcharts-inner apexcharts-graphical"
                                        transform="translate(0, 0)">
                                        <defs id="SvgjsDefs1338">
                                            <clippath id="gridRectMaskmo8vkhc4">
                                                <rect id="SvgjsRect1342" width="405" height="123" x="-1.5"
                                                    y="-1.5" rx="0" ry="0" fill="#ffffff"
                                                    opacity="1" stroke-width="0" stroke="none"
                                                    stroke-dasharray="0"></rect>
                                            </clippath>
                                            <clippath id="gridRectMarkerMaskmo8vkhc4">
                                                <rect id="SvgjsRect1343" width="410" height="128" x="-4"
                                                    y="-4" rx="0" ry="0" fill="#ffffff"
                                                    opacity="1" stroke-width="0" stroke="none"
                                                    stroke-dasharray="0"></rect>
                                            </clippath>
                                        </defs>
                                        <rect id="SvgjsRect1341" width="0" height="120" x="0" y="0"
                                            rx="0" ry="0" fill="#b1b9c4" opacity="1"
                                            stroke-width="0" stroke-dasharray="0" class="apexcharts-xcrosshairs"
                                            filter="none" fill-opacity="0.9"></rect>
                                        <g id="SvgjsG1350" class="apexcharts-xaxis" transform="translate(0, 0)">
                                            <g id="SvgjsG1351" class="apexcharts-xaxis-texts-g"
                                                transform="translate(0, -4)"></g>
                                        </g>
                                        <g id="SvgjsG1354" class="apexcharts-grid">
                                            <line id="SvgjsLine1356" x1="0" y1="120"
                                                x2="402" y2="120" stroke="transparent"
                                                stroke-dasharray="0"></line>
                                            <line id="SvgjsLine1355" x1="0" y1="1"
                                                x2="0" y2="120" stroke="transparent"
                                                stroke-dasharray="0"></line>
                                        </g>
                                        <g id="SvgjsG1345" class="apexcharts-line-series apexcharts-plot-series">
                                            <g id="SvgjsG1346" class="apexcharts-series series-1"
                                                data:longestSeries="true" rel="1" data:realIndex="0">
                                                <path id="apexcharts-line-0"
                                                    d="M8.375 63.26824254881809C14.2375 63.26824254881809 19.2625 43.53545734840698 25.125 43.53545734840698C30.9875 43.53545734840698 36.0125 86.70092497430628 41.875 86.70092497430628C47.7375 86.70092497430628 52.7625 74.36793422404932 58.625 74.36793422404932C64.4875 74.36793422404932 69.5125 69.43473792394656 75.375 69.43473792394656C81.2375 69.43473792394656 86.2625 64.50154162384378 92.125 64.50154162384378C97.9875 64.50154162384378 103.0125 81.76772867420348 108.875 81.76772867420348C114.7375 81.76772867420348 119.7625 53.401849948612536 125.625 53.401849948612536C131.4875 53.401849948612536 136.5125 76.83453237410072 142.375 76.83453237410072C148.2375 76.83453237410072 153.2625 66.96813977389516 159.125 66.96813977389516C164.9875 66.96813977389516 170.0125 62.03494347379239 175.875 62.03494347379239C181.7375 62.03494347379239 186.7625 71.90133607399794 192.625 71.90133607399794C198.4875 71.90133607399794 203.5125 90.40082219938336 209.375 90.40082219938336C215.2375 90.40082219938336 220.2625 5.3031860226104754 226.125 5.3031860226104754C231.9875 5.3031860226104754 237.0125 96.56731757451182 242.875 96.56731757451182C248.7375 96.56731757451182 253.7625 53.401849948612536 259.625 53.401849948612536C265.4875 53.401849948612536 270.5125 44.76875642343268 276.375 44.76875642343268C282.2375 44.76875642343268 287.2625 54.635149023638235 293.125 54.635149023638235C298.9875 54.635149023638235 304.0125 76.83453237410072 309.875 76.83453237410072C315.7375 76.83453237410072 320.7625 86.70092497430628 326.625 86.70092497430628C332.4875 86.70092497430628 337.5125 73.13463514902364 343.375 73.13463514902364C349.2375 73.13463514902364 354.2625 50.935251798561154 360.125 50.935251798561154C365.9875 50.935251798561154 371.0125 57.10174717368962 376.875 57.10174717368962C382.7375 57.10174717368962 387.7625 39.8355601233299 393.625 39.8355601233299C393.625 39.8355601233299 393.625 39.8355601233299 393.625 39.8355601233299 "
                                                    fill="none" fill-opacity="1" stroke="rgba(58,196,125,0.85)"
                                                    stroke-opacity="1" stroke-linecap="butt" stroke-width="3"
                                                    stroke-dasharray="0" class="apexcharts-line" index="0"
                                                    clip-path="url(#gridRectMaskmo8vkhc4)"
                                                    pathTo="M 8.375 63.26824254881809C 14.2375 63.26824254881809 19.2625 43.53545734840698 25.125 43.53545734840698C 30.9875 43.53545734840698 36.0125 86.70092497430628 41.875 86.70092497430628C 47.7375 86.70092497430628 52.7625 74.36793422404932 58.625 74.36793422404932C 64.4875 74.36793422404932 69.5125 69.43473792394656 75.375 69.43473792394656C 81.2375 69.43473792394656 86.2625 64.50154162384378 92.125 64.50154162384378C 97.9875 64.50154162384378 103.0125 81.76772867420348 108.875 81.76772867420348C 114.7375 81.76772867420348 119.7625 53.401849948612536 125.625 53.401849948612536C 131.4875 53.401849948612536 136.5125 76.83453237410072 142.375 76.83453237410072C 148.2375 76.83453237410072 153.2625 66.96813977389516 159.125 66.96813977389516C 164.9875 66.96813977389516 170.0125 62.03494347379239 175.875 62.03494347379239C 181.7375 62.03494347379239 186.7625 71.90133607399794 192.625 71.90133607399794C 198.4875 71.90133607399794 203.5125 90.40082219938336 209.375 90.40082219938336C 215.2375 90.40082219938336 220.2625 5.3031860226104754 226.125 5.3031860226104754C 231.9875 5.3031860226104754 237.0125 96.56731757451182 242.875 96.56731757451182C 248.7375 96.56731757451182 253.7625 53.401849948612536 259.625 53.401849948612536C 265.4875 53.401849948612536 270.5125 44.76875642343268 276.375 44.76875642343268C 282.2375 44.76875642343268 287.2625 54.635149023638235 293.125 54.635149023638235C 298.9875 54.635149023638235 304.0125 76.83453237410072 309.875 76.83453237410072C 315.7375 76.83453237410072 320.7625 86.70092497430628 326.625 86.70092497430628C 332.4875 86.70092497430628 337.5125 73.13463514902364 343.375 73.13463514902364C 349.2375 73.13463514902364 354.2625 50.935251798561154 360.125 50.935251798561154C 365.9875 50.935251798561154 371.0125 57.10174717368962 376.875 57.10174717368962C 382.7375 57.10174717368962 387.7625 39.8355601233299 393.625 39.8355601233299"
                                                    pathFrom="M -1 120L -1 120L 25.125 120L 41.875 120L 58.625 120L 75.375 120L 92.125 120L 108.875 120L 125.625 120L 142.375 120L 159.125 120L 175.875 120L 192.625 120L 209.375 120L 226.125 120L 242.875 120L 259.625 120L 276.375 120L 293.125 120L 309.875 120L 326.625 120L 343.375 120L 360.125 120L 376.875 120L 393.625 120">
                                                </path>
                                                <g id="SvgjsG1347" class="apexcharts-series-markers-wrap"></g>
                                                <g id="SvgjsG1348" class="apexcharts-datalabels"></g>
                                            </g>
                                        </g>
                                        <line id="SvgjsLine1357" x1="0" y1="0" x2="402"
                                            y2="0" stroke="#b6b6b6" stroke-dasharray="0"
                                            stroke-width="1" class="apexcharts-ycrosshairs"></line>
                                        <line id="SvgjsLine1358" x1="0" y1="0" x2="402"
                                            y2="0" stroke-dasharray="0" stroke-width="0"
                                            class="apexcharts-ycrosshairs-hidden"></line>
                                        <g id="SvgjsG1359" class="apexcharts-yaxis-annotations"></g>
                                        <g id="SvgjsG1360" class="apexcharts-xaxis-annotations"></g>
                                        <g id="SvgjsG1361" class="apexcharts-point-annotations"></g>
                                    </g>
                                    <g id="SvgjsG1352" class="apexcharts-yaxis" rel="0"
                                        transform="translate(-35, 0)">
                                        <g id="SvgjsG1353" class="apexcharts-yaxis-texts-g"></g>
                                    </g>
                                </svg>
                                <div class="apexcharts-legend"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="p-0 widget-chart">
                                    <div class="widget-chart-content">
                                        <div class="widget-numbers text-warning fsize-3">43</div>
                                        <div class="pt-1 widget-subheading">Packages</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-0 widget-chart">
                                    <div class="widget-chart-content">
                                        <div class="widget-numbers text-danger fsize-3">65</div>
                                        <div class="pt-1 widget-subheading">Dropped</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-0 widget-chart">
                                    <div class="widget-chart-content">
                                        <div class="widget-numbers text-success fsize-3">18</div>
                                        <div class="pt-1 widget-subheading">Invalid</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="mt-2 text-center d-block">
                            <button class="mr-2 border-0 btn-transition btn btn-outline-danger">Escalate
                                Issue</button>
                            <button class="border-0 btn-transition btn btn-outline-success">Support Center</button>
                        </div>
                        <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 403px; height: 289px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                </div>
                <h3 class="drawer-heading">File Transfers</h3>
                <div class="p-0 drawer-section">
                    <div class="files-box">
                        <ul class="list-group list-group-flush">
                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div
                                            class="mr-3 widget-content-left opacity-6 fsize-2 text-primary center-elem">
                                            <i class="fa fa-file-alt"></i>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading font-weight-normal">TPSReport.docx</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                                <i class="fa fa-cloud-download-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div
                                            class="mr-3 widget-content-left opacity-6 fsize-2 text-warning center-elem">
                                            <i class="fa fa-file-archive"></i>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading font-weight-normal">Latest_photos.zip</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                                <i class="fa fa-cloud-download-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div
                                            class="mr-3 widget-content-left opacity-6 fsize-2 text-danger center-elem">
                                            <i class="fa fa-file-pdf"></i>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading font-weight-normal">Annual Revenue.pdf</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                                <i class="fa fa-cloud-download-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div
                                            class="mr-3 widget-content-left opacity-6 fsize-2 text-success center-elem">
                                            <i class="fa fa-file-excel"></i>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading font-weight-normal">Analytics_GrowthReport.xls
                                            </div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="btn-icon btn-icon-only btn btn-link btn-sm">
                                                <i class="fa fa-cloud-download-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="drawer-heading">Tasks in Progress</h3>
                <div class="p-0 drawer-section">
                    <div class="todo-box">
                        <ul class="todo-list-wrapper list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="todo-indicator bg-warning"></div>
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div class="mr-2 widget-content-left">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox1266"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="exampleCustomCheckbox1266">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Wash the car
                                                <div class="ml-2 badge badge-danger">Rejected</div>
                                            </div>
                                            <div class="widget-subheading"><i>Written by Bob</i></div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="todo-indicator bg-focus"></div>
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div class="mr-2 widget-content-left">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox1666"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="exampleCustomCheckbox1666">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Task with hover dropdown menu</div>
                                            <div class="widget-subheading">
                                                <div>By Johnny
                                                    <div class="ml-2 badge badge-pill badge-info">NEW</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <div class="d-inline-block dropdown">
                                                <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"
                                                    class="border-0 btn-transition btn btn-link">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true"
                                                    class="dropdown-menu dropdown-menu-right">
                                                    <h6 tabindex="-1" class="dropdown-header">Header</h6>
                                                    <button type="button" disabled="" tabindex="-1"
                                                        class="disabled dropdown-item">Action</button>
                                                    <button type="button" tabindex="0"
                                                        class="dropdown-item">Another Action</button>
                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                    <button type="button" tabindex="0"
                                                        class="dropdown-item">Another Action</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="todo-indicator bg-primary"></div>
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div class="mr-2 widget-content-left">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox4777"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="exampleCustomCheckbox4777">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">Badge on the right task</div>
                                            <div class="widget-subheading">This task has show on hover actions!</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                        <div class="ml-3 widget-content-right">
                                            <div class="badge badge-pill badge-success">Latest Task</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="todo-indicator bg-info"></div>
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div class="mr-2 widget-content-left">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox2444"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="exampleCustomCheckbox2444">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="mr-3 widget-content-left">
                                            <div class="widget-content-left">
                                                <img width="42" class="rounded"
                                                    src="{{ asset('backend') }}/1.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Go grocery shopping</div>
                                            <div class="widget-subheading">A short description ...</div>
                                        </div>
                                        <div class="widget-content-right widget-content-actions">
                                            <button class="border-0 btn-transition btn btn-sm btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="todo-indicator bg-success"></div>
                                <div class="p-0 widget-content">
                                    <div class="widget-content-wrapper">
                                        <div class="mr-2 widget-content-left">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" id="exampleCustomCheckbox3222"
                                                    class="custom-control-input">
                                                <label class="custom-control-label"
                                                    for="exampleCustomCheckbox3222">&nbsp;</label>
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-heading">Development Task</div>
                                            <div class="widget-subheading">Finish React ToDo List App</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="mr-2 badge badge-warning">69</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <button class="border-0 btn-transition btn btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button class="border-0 btn-transition btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 class="drawer-heading">Urgent Notifications</h3>
                <div class="drawer-section">
                    <div class="notifications-box">
                        <div
                            class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">
                            <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">All Hands Meeting</h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-warning vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <p>Yet another one, at <span class="text-success">15:00 PM</span></p>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-success vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">Build the production release
                                            <div class="ml-2 badge badge-danger">NEW</div>
                                        </h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-primary vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">Something not important
                                            <div class="mt-2 avatar-wrapper avatar-wrapper-overlap">
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/1.jpg"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/2.jpg"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/3.jpg"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/4.jpg"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/5.jpg"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/6.jpg"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/7.jpg"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm">
                                                    <div class="avatar-icon">
                                                        <img src="{{ asset('backend') }}/8.jpg"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="avatar-icon-wrapper avatar-icon-sm avatar-icon-add">
                                                    <div class="avatar-icon"><i>+</i></div>
                                                </div>
                                            </div>
                                        </h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-info vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon bounce-in"></span>
                                    <div class="vertical-timeline-element-content bounce-in">
                                        <h4 class="timeline-title">This dot has an info state</h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="vertical-timeline-item dot-dark vertical-timeline-element">
                                <div>
                                    <span class="vertical-timeline-element-icon is-hidden"></span>
                                    <div class="vertical-timeline-element-content is-hidden">
                                        <h4 class="timeline-title">This dot has a dark state</h4>
                                        <span class="vertical-timeline-element-date"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps__rail-y" style="top: 0px; height: 607px; right: 0px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 261px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-drawer-overlay d-none animated fadeIn"></div>
    <script type="text/javascript"
        src="{{ asset('backend') }}/main.d810cf0ae7f39f28f336.js.download">
    </script>

    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004"
            d="M-1 152L-1 152C-1 152 24.6875 152 24.6875 152C24.6875 152 41.14583333333333 152 41.14583333333333 152C41.14583333333333 152 57.60416666666666 152 57.60416666666666 152C57.60416666666666 152 74.06249999999999 152 74.06249999999999 152C74.06249999999999 152 90.52083333333331 152 90.52083333333331 152C90.52083333333331 152 106.97916666666664 152 106.97916666666664 152C106.97916666666664 152 123.43749999999997 152 123.43749999999997 152C123.43749999999997 152 139.89583333333331 152 139.89583333333331 152C139.89583333333331 152 156.35416666666666 152 156.35416666666666 152C156.35416666666666 152 172.8125 152 172.8125 152C172.8125 152 189.27083333333334 152 189.27083333333334 152C189.27083333333334 152 205.72916666666669 152 205.72916666666669 152C205.72916666666669 152 222.18750000000003 152 222.18750000000003 152C222.18750000000003 152 238.64583333333337 152 238.64583333333337 152C238.64583333333337 152 255.1041666666667 152 255.1041666666667 152C255.1041666666667 152 271.56250000000006 152 271.56250000000006 152C271.56250000000006 152 288.02083333333337 152 288.02083333333337 152C288.02083333333337 152 304.4791666666667 152 304.4791666666667 152C304.4791666666667 152 320.9375 152 320.9375 152C320.9375 152 337.3958333333333 152 337.3958333333333 152C337.3958333333333 152 353.85416666666663 152 353.85416666666663 152C353.85416666666663 152 370.31249999999994 152 370.31249999999994 152C370.31249999999994 152 386.77083333333326 152 386.77083333333326 152C386.77083333333326 152 386.77083333333326 152 386.77083333333326 152 ">
        </path>
    </svg>
    <div id="loom-companion-mv3" ext-id="liecbddmkiiihnedobmlmillhodjkdmb">
        <section id="shadow-host-companion"><template shadowrootmode="open">
                <div id="inner-shadow-companion">
                    <div class="css-0" id="tooltip-mount-layer-companion"></div>
                    <style data-emotion="companion-global"></style>
                    <style data-emotion="companion" data-s=""></style>
                    <style>
                        #inner-shadow-companion {
                            font-size: 100%;
                        }

                        #inner-shadow-companion {
                            font-family: circular, -apple-system, BlinkMacSystemFont, Segoe UI,
                                sans-serif;
                            color: var(--lns-color-body);

                            font-size: var(--lns-fontSize-medium);
                            line-height: var(--lns-lineHeight-medium);
                            ;
                            font-feature-settings: 'ss08' on;
                        }

                        #inner-shadow-companion *,
                        #inner-shadow-companion *:before,
                        #inner-shadow-companion *:after {
                            box-sizing: border-box;
                        }

                        #inner-shadow-companion * {
                            -webkit-font-smoothing: antialiased;
                            -moz-osx-font-smoothing: grayscale;
                            letter-spacing: calc(0.6px - 0.05em);
                        }


                        #inner-shadow-companion,
                        .theme-light,
                        [data-lens-theme="light"] {
                            --lns-color-primary: var(--lns-themeLight-color-primary);
                            --lns-color-primaryHover: var(--lns-themeLight-color-primaryHover);
                            --lns-color-primaryActive: var(--lns-themeLight-color-primaryActive);
                            --lns-color-body: var(--lns-themeLight-color-body);
                            --lns-color-bodyDimmed: var(--lns-themeLight-color-bodyDimmed);
                            --lns-color-background: var(--lns-themeLight-color-background);
                            --lns-color-backgroundHover: var(--lns-themeLight-color-backgroundHover);
                            --lns-color-backgroundActive: var(--lns-themeLight-color-backgroundActive);
                            --lns-color-backgroundSecondary: var(--lns-themeLight-color-backgroundSecondary);
                            --lns-color-backgroundSecondary2: var(--lns-themeLight-color-backgroundSecondary2);
                            --lns-color-overlay: var(--lns-themeLight-color-overlay);
                            --lns-color-border: var(--lns-themeLight-color-border);
                            --lns-color-focusRing: var(--lns-themeLight-color-focusRing);
                            --lns-color-record: var(--lns-themeLight-color-record);
                            --lns-color-recordHover: var(--lns-themeLight-color-recordHover);
                            --lns-color-recordActive: var(--lns-themeLight-color-recordActive);
                            --lns-color-info: var(--lns-themeLight-color-info);
                            --lns-color-success: var(--lns-themeLight-color-success);
                            --lns-color-warning: var(--lns-themeLight-color-warning);
                            --lns-color-danger: var(--lns-themeLight-color-danger);
                            --lns-color-dangerHover: var(--lns-themeLight-color-dangerHover);
                            --lns-color-dangerActive: var(--lns-themeLight-color-dangerActive);
                            --lns-color-backdrop: var(--lns-themeLight-color-backdrop);
                            --lns-color-backdropDark: var(--lns-themeLight-color-backdropDark);
                            --lns-color-backdropTwilight: var(--lns-themeLight-color-backdropTwilight);
                            --lns-color-disabledContent: var(--lns-themeLight-color-disabledContent);
                            --lns-color-highlight: var(--lns-themeLight-color-highlight);
                            --lns-color-disabledBackground: var(--lns-themeLight-color-disabledBackground);
                            --lns-color-formFieldBorder: var(--lns-themeLight-color-formFieldBorder);
                            --lns-color-formFieldBackground: var(--lns-themeLight-color-formFieldBackground);
                            --lns-color-buttonBorder: var(--lns-themeLight-color-buttonBorder);
                            --lns-color-upgrade: var(--lns-themeLight-color-upgrade);
                            --lns-color-upgradeHover: var(--lns-themeLight-color-upgradeHover);
                            --lns-color-upgradeActive: var(--lns-themeLight-color-upgradeActive);
                            --lns-color-tabBackground: var(--lns-themeLight-color-tabBackground);
                            --lns-color-discoveryBackground: var(--lns-themeLight-color-discoveryBackground);
                            --lns-color-discoveryLightBackground: var(--lns-themeLight-color-discoveryLightBackground);
                            --lns-color-discoveryTitle: var(--lns-themeLight-color-discoveryTitle);
                            --lns-color-discoveryHighlight: var(--lns-themeLight-color-discoveryHighlight);
                        }

                        .theme-dark,
                        [data-lens-theme="dark"] {
                            --lns-color-primary: var(--lns-themeDark-color-primary);
                            --lns-color-primaryHover: var(--lns-themeDark-color-primaryHover);
                            --lns-color-primaryActive: var(--lns-themeDark-color-primaryActive);
                            --lns-color-body: var(--lns-themeDark-color-body);
                            --lns-color-bodyDimmed: var(--lns-themeDark-color-bodyDimmed);
                            --lns-color-background: var(--lns-themeDark-color-background);
                            --lns-color-backgroundHover: var(--lns-themeDark-color-backgroundHover);
                            --lns-color-backgroundActive: var(--lns-themeDark-color-backgroundActive);
                            --lns-color-backgroundSecondary: var(--lns-themeDark-color-backgroundSecondary);
                            --lns-color-backgroundSecondary2: var(--lns-themeDark-color-backgroundSecondary2);
                            --lns-color-overlay: var(--lns-themeDark-color-overlay);
                            --lns-color-border: var(--lns-themeDark-color-border);
                            --lns-color-focusRing: var(--lns-themeDark-color-focusRing);
                            --lns-color-record: var(--lns-themeDark-color-record);
                            --lns-color-recordHover: var(--lns-themeDark-color-recordHover);
                            --lns-color-recordActive: var(--lns-themeDark-color-recordActive);
                            --lns-color-info: var(--lns-themeDark-color-info);
                            --lns-color-success: var(--lns-themeDark-color-success);
                            --lns-color-warning: var(--lns-themeDark-color-warning);
                            --lns-color-danger: var(--lns-themeDark-color-danger);
                            --lns-color-dangerHover: var(--lns-themeDark-color-dangerHover);
                            --lns-color-dangerActive: var(--lns-themeDark-color-dangerActive);
                            --lns-color-backdrop: var(--lns-themeDark-color-backdrop);
                            --lns-color-backdropDark: var(--lns-themeDark-color-backdropDark);
                            --lns-color-backdropTwilight: var(--lns-themeDark-color-backdropTwilight);
                            --lns-color-disabledContent: var(--lns-themeDark-color-disabledContent);
                            --lns-color-highlight: var(--lns-themeDark-color-highlight);
                            --lns-color-disabledBackground: var(--lns-themeDark-color-disabledBackground);
                            --lns-color-formFieldBorder: var(--lns-themeDark-color-formFieldBorder);
                            --lns-color-formFieldBackground: var(--lns-themeDark-color-formFieldBackground);
                            --lns-color-buttonBorder: var(--lns-themeDark-color-buttonBorder);
                            --lns-color-upgrade: var(--lns-themeDark-color-upgrade);
                            --lns-color-upgradeHover: var(--lns-themeDark-color-upgradeHover);
                            --lns-color-upgradeActive: var(--lns-themeDark-color-upgradeActive);
                            --lns-color-tabBackground: var(--lns-themeDark-color-tabBackground);
                            --lns-color-discoveryBackground: var(--lns-themeDark-color-discoveryBackground);
                            --lns-color-discoveryLightBackground: var(--lns-themeDark-color-discoveryLightBackground);
                            --lns-color-discoveryTitle: var(--lns-themeDark-color-discoveryTitle);
                            --lns-color-discoveryHighlight: var(--lns-themeDark-color-discoveryHighlight);
                        }



                        #inner-shadow-companion {
                            --lns-fontWeight-book: 400;
                            --lns-fontWeight-bold: 700;
                            --lns-unit: 0.5rem;
                            --lns-fontSize-small: calc(1.5 * var(--lns-unit, 8px));
                            --lns-lineHeight-small: 1.5;
                            --lns-fontSize-body-sm: calc(1.5 * var(--lns-unit, 8px));
                            --lns-lineHeight-body-sm: 1.5;
                            --lns-fontSize-medium: calc(1.75 * var(--lns-unit, 8px));
                            --lns-lineHeight-medium: 1.6;
                            --lns-fontSize-body-md: calc(1.75 * var(--lns-unit, 8px));
                            --lns-lineHeight-body-md: 1.6;
                            --lns-fontSize-large: calc(2.25 * var(--lns-unit, 8px));
                            --lns-lineHeight-large: 1.45;
                            --lns-fontSize-body-lg: calc(2.25 * var(--lns-unit, 8px));
                            --lns-lineHeight-body-lg: 1.45;
                            --lns-fontSize-xlarge: calc(3 * var(--lns-unit, 8px));
                            --lns-lineHeight-xlarge: 1.35;
                            --lns-fontSize-heading-sm: calc(3 * var(--lns-unit, 8px));
                            --lns-lineHeight-heading-sm: 1.35;
                            --lns-fontSize-xxlarge: calc(4 * var(--lns-unit, 8px));
                            --lns-lineHeight-xxlarge: 1.2;
                            --lns-fontSize-heading-md: calc(4 * var(--lns-unit, 8px));
                            --lns-lineHeight-heading-md: 1.2;
                            --lns-fontSize-xxxlarge: calc(6 * var(--lns-unit, 8px));
                            --lns-lineHeight-xxxlarge: 1.15;
                            --lns-fontSize-heading-lg: calc(6 * var(--lns-unit, 8px));
                            --lns-lineHeight-heading-lg: 1.15;
                            --lns-radius-medium: calc(1 * var(--lns-unit, 8px));
                            --lns-radius-large: calc(2 * var(--lns-unit, 8px));
                            --lns-radius-xlarge: calc(3 * var(--lns-unit, 8px));
                            --lns-radius-full: calc(999 * var(--lns-unit, 8px));
                            --lns-shadow-small: 0 calc(0.5 * var(--lns-unit, 8px)) calc(1.25 * var(--lns-unit, 8px)) hsla(0, 0%, 0%, 0.05);
                            --lns-shadow-medium: 0 calc(0.5 * var(--lns-unit, 8px)) calc(1.25 * var(--lns-unit, 8px)) hsla(0, 0%, 0%, 0.1);
                            --lns-shadow-large: 0 calc(0.75 * var(--lns-unit, 8px)) calc(3 * var(--lns-unit, 8px)) hsla(0, 0%, 0%, 0.1);
                            --lns-space-xsmall: calc(0.5 * var(--lns-unit, 8px));
                            --lns-space-small: calc(1 * var(--lns-unit, 8px));
                            --lns-space-medium: calc(2 * var(--lns-unit, 8px));
                            --lns-space-large: calc(3 * var(--lns-unit, 8px));
                            --lns-space-xlarge: calc(5 * var(--lns-unit, 8px));
                            --lns-space-xxlarge: calc(8 * var(--lns-unit, 8px));
                            --lns-formFieldBorderWidth: 1px;
                            --lns-formFieldBorderWidthFocus: 2px;
                            --lns-formFieldHeight: calc(4.5 * var(--lns-unit, 8px));
                            --lns-formFieldRadius: calc(2.25 * var(--lns-unit, 8px));
                            --lns-formFieldHorizontalPadding: calc(2 * var(--lns-unit, 8px));
                            --lns-formFieldBorderShadow:
                                inset 0 0 0 var(--lns-formFieldBorderWidth) var(--lns-color-formFieldBorder);
                            --lns-formFieldBorderShadowFocus:
                                inset 0 0 0 var(--lns-formFieldBorderWidthFocus) var(--lns-color-blurple),
                                0 0 0 var(--lns-formFieldBorderWidthFocus) var(--lns-color-focusRing);
                            --lns-formFieldBorderShadowError:
                                inset 0 0 0 var(--lns-formFieldBorderWidthFocus) var(--lns-color-danger),
                                0 0 0 var(--lns-formFieldBorderWidthFocus) var(--lns-color-orangeLight);
                            --lns-color-red: hsla(11, 80%, 45%, 1);
                            --lns-color-blurpleLight: hsla(240, 83.3%, 95.3%, 1);
                            --lns-color-blurpleMedium: hsla(242, 81%, 87.6%, 1);
                            --lns-color-blurple: hsla(242, 88.4%, 66.3%, 1);
                            --lns-color-blurpleDark: hsla(242, 87.6%, 62%, 1);
                            --lns-color-blurpleStrong: hsla(252, 46%, 33%, 1);
                            --lns-color-offWhite: hsla(45, 36.4%, 95.7%, 1);
                            --lns-color-blueLight: hsla(206, 58.3%, 85.9%, 1);
                            --lns-color-blue: hsla(206, 100%, 73.3%, 1);
                            --lns-color-blueDark: hsla(206, 29.5%, 33.9%, 1);
                            --lns-color-orangeLight: hsla(6, 100%, 89.6%, 1);
                            --lns-color-orange: hsla(11, 100%, 62.2%, 1);
                            --lns-color-orangeDark: hsla(11, 79.9%, 64.9%, 1);
                            --lns-color-tealLight: hsla(180, 20%, 67.6%, 1);
                            --lns-color-teal: hsla(180, 51.4%, 51.6%, 1);
                            --lns-color-tealDark: hsla(180, 16.2%, 22.9%, 1);
                            --lns-color-yellowLight: hsla(39, 100%, 87.8%, 1);
                            --lns-color-yellow: hsla(50, 100%, 57.3%, 1);
                            --lns-color-yellowDark: hsla(39, 100%, 68%, 1);
                            --lns-color-grey8: hsla(0, 0%, 13%, 1);
                            --lns-color-grey7: hsla(246, 16%, 26%, 1);
                            --lns-color-grey6: hsla(252, 13%, 46%, 1);
                            --lns-color-grey5: hsla(240, 7%, 62%, 1);
                            --lns-color-grey4: hsla(259, 12%, 75%, 1);
                            --lns-color-grey3: hsla(260, 11%, 85%, 1);
                            --lns-color-grey2: hsla(260, 11%, 95%, 1);
                            --lns-color-grey1: hsla(240, 7%, 97%, 1);
                            --lns-color-white: hsla(0, 0%, 100%, 1);
                            --lns-themeLight-color-primary: hsla(242, 88.4%, 66.3%, 1);
                            --lns-themeLight-color-primaryHover: hsla(242, 88.4%, 56.3%, 1);
                            --lns-themeLight-color-primaryActive: hsla(242, 88.4%, 45.3%, 1);
                            --lns-themeLight-color-body: hsla(0, 0%, 13%, 1);
                            --lns-themeLight-color-bodyDimmed: hsla(252, 13%, 46%, 1);
                            --lns-themeLight-color-background: hsla(0, 0%, 100%, 1);
                            --lns-themeLight-color-backgroundHover: hsla(246, 16%, 26%, 0.1);
                            --lns-themeLight-color-backgroundActive: hsla(246, 16%, 26%, 0.3);
                            --lns-themeLight-color-backgroundSecondary: hsla(246, 16%, 26%, 0.04);
                            --lns-themeLight-color-backgroundSecondary2: hsla(45, 34%, 78%, 0.2);
                            --lns-themeLight-color-overlay: hsla(0, 0%, 100%, 1);
                            --lns-themeLight-color-border: hsla(252, 13%, 46%, 0.2);
                            --lns-themeLight-color-focusRing: hsla(242, 88.4%, 66.3%, 0.5);
                            --lns-themeLight-color-record: hsla(11, 100%, 62.2%, 1);
                            --lns-themeLight-color-recordHover: hsla(11, 100%, 52.2%, 1);
                            --lns-themeLight-color-recordActive: hsla(11, 100%, 42.2%, 1);
                            --lns-themeLight-color-info: hsla(206, 100%, 73.3%, 1);
                            --lns-themeLight-color-success: hsla(180, 51.4%, 51.6%, 1);
                            --lns-themeLight-color-warning: hsla(39, 100%, 68%, 1);
                            --lns-themeLight-color-danger: hsla(11, 80%, 45%, 1);
                            --lns-themeLight-color-dangerHover: hsla(11, 80%, 38%, 1);
                            --lns-themeLight-color-dangerActive: hsla(11, 80%, 31%, 1);
                            --lns-themeLight-color-backdrop: hsla(0, 0%, 13%, 0.5);
                            --lns-themeLight-color-backdropDark: hsla(0, 0%, 13%, 0.9);
                            --lns-themeLight-color-backdropTwilight: hsla(245, 44.8%, 46.9%, 0.8);
                            --lns-themeLight-color-disabledContent: hsla(240, 7%, 62%, 1);
                            --lns-themeLight-color-highlight: hsla(240, 83.3%, 66.3%, 0.15);
                            --lns-themeLight-color-disabledBackground: hsla(260, 11%, 95%, 1);
                            --lns-themeLight-color-formFieldBorder: hsla(260, 11%, 85%, 1);
                            --lns-themeLight-color-formFieldBackground: hsla(0, 0%, 100%, 1);
                            --lns-themeLight-color-buttonBorder: hsla(252, 13%, 46%, 0.25);
                            --lns-themeLight-color-upgrade: hsla(206, 100%, 93%, 1);
                            --lns-themeLight-color-upgradeHover: hsla(206, 100%, 85%, 1);
                            --lns-themeLight-color-upgradeActive: hsla(206, 100%, 77%, 1);
                            --lns-themeLight-color-tabBackground: hsla(252, 13%, 46%, 0.15);
                            --lns-themeLight-color-discoveryBackground: hsla(206, 100%, 93%, 1);
                            --lns-themeLight-color-discoveryLightBackground: hsla(206, 100%, 97%, 1);
                            --lns-themeLight-color-discoveryTitle: hsla(0, 0%, 13%, 1);
                            --lns-themeLight-color-discoveryHighlight: hsla(206, 100%, 77%, 0.3);
                            --lns-themeDark-color-primary: hsla(242, 87%, 73%, 1);
                            --lns-themeDark-color-primaryHover: hsla(242, 88.4%, 56.3%, 1);
                            --lns-themeDark-color-primaryActive: hsla(242, 88.4%, 45.3%, 1);
                            --lns-themeDark-color-body: hsla(240, 7%, 97%, 1);
                            --lns-themeDark-color-bodyDimmed: hsla(240, 7%, 62%, 1);
                            --lns-themeDark-color-background: hsla(0, 0%, 13%, 1);
                            --lns-themeDark-color-backgroundHover: hsla(0, 0%, 100%, 0.1);
                            --lns-themeDark-color-backgroundActive: hsla(0, 0%, 100%, 0.2);
                            --lns-themeDark-color-backgroundSecondary: hsla(0, 0%, 100%, 0.04);
                            --lns-themeDark-color-backgroundSecondary2: hsla(45, 13%, 44%, 0.2);
                            --lns-themeDark-color-overlay: hsla(0, 0%, 20%, 1);
                            --lns-themeDark-color-border: hsla(259, 12%, 75%, 0.2);
                            --lns-themeDark-color-focusRing: hsla(242, 88.4%, 66.3%, 0.5);
                            --lns-themeDark-color-record: hsla(11, 100%, 62.2%, 1);
                            --lns-themeDark-color-recordHover: hsla(11, 100%, 52.2%, 1);
                            --lns-themeDark-color-recordActive: hsla(11, 100%, 42.2%, 1);
                            --lns-themeDark-color-info: hsla(206, 100%, 73.3%, 1);
                            --lns-themeDark-color-success: hsla(180, 51.4%, 51.6%, 1);
                            --lns-themeDark-color-warning: hsla(39, 100%, 68%, 1);
                            --lns-themeDark-color-danger: hsla(11, 80%, 45%, 1);
                            --lns-themeDark-color-dangerHover: hsla(11, 80%, 38%, 1);
                            --lns-themeDark-color-dangerActive: hsla(11, 80%, 31%, 1);
                            --lns-themeDark-color-backdrop: hsla(0, 0%, 13%, 0.5);
                            --lns-themeDark-color-backdropDark: hsla(0, 0%, 13%, 0.9);
                            --lns-themeDark-color-backdropTwilight: hsla(245, 44.8%, 46.9%, 0.8);
                            --lns-themeDark-color-disabledContent: hsla(240, 7%, 62%, 1);
                            --lns-themeDark-color-highlight: hsla(240, 83.3%, 66.3%, 0.15);
                            --lns-themeDark-color-disabledBackground: hsla(252, 13%, 23%, 1);
                            --lns-themeDark-color-formFieldBorder: hsla(252, 13%, 46%, 1);
                            --lns-themeDark-color-formFieldBackground: hsla(0, 0%, 13%, 1);
                            --lns-themeDark-color-buttonBorder: hsla(0, 0%, 100%, 0.25);
                            --lns-themeDark-color-upgrade: hsla(206, 92%, 81%, 1);
                            --lns-themeDark-color-upgradeHover: hsla(206, 92%, 74%, 1);
                            --lns-themeDark-color-upgradeActive: hsla(206, 92%, 67%, 1);
                            --lns-themeDark-color-tabBackground: hsla(0, 0%, 100%, 0.15);
                            --lns-themeDark-color-discoveryBackground: hsla(206, 92%, 81%, 1);
                            --lns-themeDark-color-discoveryLightBackground: hsla(0, 0%, 13%, 1);
                            --lns-themeDark-color-discoveryTitle: hsla(206, 100%, 73.3%, 1);
                            --lns-themeDark-color-discoveryHighlight: hsla(206, 100%, 77%, 0.3);
                            --lns-gradient-ai-primary: radial-gradient(134.96% 884.49% at 119.29% 112.58%, #DC43BE 0%, #565ADD 70%);
                            --lns-gradient-ai-secondary: radial-gradient(100% 138.41% at 100% 100%, #EFF0FF 0%, #FFFFFF 100%);
                        }


                        .c\:red {
                            color: var(--lns-color-red)
                        }

                        .c\:blurpleLight {
                            color: var(--lns-color-blurpleLight)
                        }

                        .c\:blurpleMedium {
                            color: var(--lns-color-blurpleMedium)
                        }

                        .c\:blurple {
                            color: var(--lns-color-blurple)
                        }

                        .c\:blurpleDark {
                            color: var(--lns-color-blurpleDark)
                        }

                        .c\:blurpleStrong {
                            color: var(--lns-color-blurpleStrong)
                        }

                        .c\:offWhite {
                            color: var(--lns-color-offWhite)
                        }

                        .c\:blueLight {
                            color: var(--lns-color-blueLight)
                        }

                        .c\:blue {
                            color: var(--lns-color-blue)
                        }

                        .c\:blueDark {
                            color: var(--lns-color-blueDark)
                        }

                        .c\:orangeLight {
                            color: var(--lns-color-orangeLight)
                        }

                        .c\:orange {
                            color: var(--lns-color-orange)
                        }

                        .c\:orangeDark {
                            color: var(--lns-color-orangeDark)
                        }

                        .c\:tealLight {
                            color: var(--lns-color-tealLight)
                        }

                        .c\:teal {
                            color: var(--lns-color-teal)
                        }

                        .c\:tealDark {
                            color: var(--lns-color-tealDark)
                        }

                        .c\:yellowLight {
                            color: var(--lns-color-yellowLight)
                        }

                        .c\:yellow {
                            color: var(--lns-color-yellow)
                        }

                        .c\:yellowDark {
                            color: var(--lns-color-yellowDark)
                        }

                        .c\:grey8 {
                            color: var(--lns-color-grey8)
                        }

                        .c\:grey7 {
                            color: var(--lns-color-grey7)
                        }

                        .c\:grey6 {
                            color: var(--lns-color-grey6)
                        }

                        .c\:grey5 {
                            color: var(--lns-color-grey5)
                        }

                        .c\:grey4 {
                            color: var(--lns-color-grey4)
                        }

                        .c\:grey3 {
                            color: var(--lns-color-grey3)
                        }

                        .c\:grey2 {
                            color: var(--lns-color-grey2)
                        }

                        .c\:grey1 {
                            color: var(--lns-color-grey1)
                        }

                        .c\:white {
                            color: var(--lns-color-white)
                        }

                        .c\:primary {
                            color: var(--lns-color-primary)
                        }

                        .c\:primaryHover {
                            color: var(--lns-color-primaryHover)
                        }

                        .c\:primaryActive {
                            color: var(--lns-color-primaryActive)
                        }

                        .c\:body {
                            color: var(--lns-color-body)
                        }

                        .c\:bodyDimmed {
                            color: var(--lns-color-bodyDimmed)
                        }

                        .c\:background {
                            color: var(--lns-color-background)
                        }

                        .c\:backgroundHover {
                            color: var(--lns-color-backgroundHover)
                        }

                        .c\:backgroundActive {
                            color: var(--lns-color-backgroundActive)
                        }

                        .c\:backgroundSecondary {
                            color: var(--lns-color-backgroundSecondary)
                        }

                        .c\:backgroundSecondary2 {
                            color: var(--lns-color-backgroundSecondary2)
                        }

                        .c\:overlay {
                            color: var(--lns-color-overlay)
                        }

                        .c\:border {
                            color: var(--lns-color-border)
                        }

                        .c\:focusRing {
                            color: var(--lns-color-focusRing)
                        }

                        .c\:record {
                            color: var(--lns-color-record)
                        }

                        .c\:recordHover {
                            color: var(--lns-color-recordHover)
                        }

                        .c\:recordActive {
                            color: var(--lns-color-recordActive)
                        }

                        .c\:info {
                            color: var(--lns-color-info)
                        }

                        .c\:success {
                            color: var(--lns-color-success)
                        }

                        .c\:warning {
                            color: var(--lns-color-warning)
                        }

                        .c\:danger {
                            color: var(--lns-color-danger)
                        }

                        .c\:dangerHover {
                            color: var(--lns-color-dangerHover)
                        }

                        .c\:dangerActive {
                            color: var(--lns-color-dangerActive)
                        }

                        .c\:backdrop {
                            color: var(--lns-color-backdrop)
                        }

                        .c\:backdropDark {
                            color: var(--lns-color-backdropDark)
                        }

                        .c\:backdropTwilight {
                            color: var(--lns-color-backdropTwilight)
                        }

                        .c\:disabledContent {
                            color: var(--lns-color-disabledContent)
                        }

                        .c\:highlight {
                            color: var(--lns-color-highlight)
                        }

                        .c\:disabledBackground {
                            color: var(--lns-color-disabledBackground)
                        }

                        .c\:formFieldBorder {
                            color: var(--lns-color-formFieldBorder)
                        }

                        .c\:formFieldBackground {
                            color: var(--lns-color-formFieldBackground)
                        }

                        .c\:buttonBorder {
                            color: var(--lns-color-buttonBorder)
                        }

                        .c\:upgrade {
                            color: var(--lns-color-upgrade)
                        }

                        .c\:upgradeHover {
                            color: var(--lns-color-upgradeHover)
                        }

                        .c\:upgradeActive {
                            color: var(--lns-color-upgradeActive)
                        }

                        .c\:tabBackground {
                            color: var(--lns-color-tabBackground)
                        }

                        .c\:discoveryBackground {
                            color: var(--lns-color-discoveryBackground)
                        }

                        .c\:discoveryLightBackground {
                            color: var(--lns-color-discoveryLightBackground)
                        }

                        .c\:discoveryTitle {
                            color: var(--lns-color-discoveryTitle)
                        }

                        .c\:discoveryHighlight {
                            color: var(--lns-color-discoveryHighlight)
                        }

                        .shadow\:small {
                            box-shadow: var(--lns-shadow-small)
                        }

                        .shadow\:medium {
                            box-shadow: var(--lns-shadow-medium)
                        }

                        .shadow\:large {
                            box-shadow: var(--lns-shadow-large)
                        }

                        .radius\:medium {
                            border-radius: var(--lns-radius-medium)
                        }

                        .radius\:large {
                            border-radius: var(--lns-radius-large)
                        }

                        .radius\:xlarge {
                            border-radius: var(--lns-radius-xlarge)
                        }

                        .radius\:full {
                            border-radius: var(--lns-radius-full)
                        }

                        .bgc\:red {
                            background-color: var(--lns-color-red)
                        }

                        .bgc\:blurpleLight {
                            background-color: var(--lns-color-blurpleLight)
                        }

                        .bgc\:blurpleMedium {
                            background-color: var(--lns-color-blurpleMedium)
                        }

                        .bgc\:blurple {
                            background-color: var(--lns-color-blurple)
                        }

                        .bgc\:blurpleDark {
                            background-color: var(--lns-color-blurpleDark)
                        }

                        .bgc\:blurpleStrong {
                            background-color: var(--lns-color-blurpleStrong)
                        }

                        .bgc\:offWhite {
                            background-color: var(--lns-color-offWhite)
                        }

                        .bgc\:blueLight {
                            background-color: var(--lns-color-blueLight)
                        }

                        .bgc\:blue {
                            background-color: var(--lns-color-blue)
                        }

                        .bgc\:blueDark {
                            background-color: var(--lns-color-blueDark)
                        }

                        .bgc\:orangeLight {
                            background-color: var(--lns-color-orangeLight)
                        }

                        .bgc\:orange {
                            background-color: var(--lns-color-orange)
                        }

                        .bgc\:orangeDark {
                            background-color: var(--lns-color-orangeDark)
                        }

                        .bgc\:tealLight {
                            background-color: var(--lns-color-tealLight)
                        }

                        .bgc\:teal {
                            background-color: var(--lns-color-teal)
                        }

                        .bgc\:tealDark {
                            background-color: var(--lns-color-tealDark)
                        }

                        .bgc\:yellowLight {
                            background-color: var(--lns-color-yellowLight)
                        }

                        .bgc\:yellow {
                            background-color: var(--lns-color-yellow)
                        }

                        .bgc\:yellowDark {
                            background-color: var(--lns-color-yellowDark)
                        }

                        .bgc\:grey8 {
                            background-color: var(--lns-color-grey8)
                        }

                        .bgc\:grey7 {
                            background-color: var(--lns-color-grey7)
                        }

                        .bgc\:grey6 {
                            background-color: var(--lns-color-grey6)
                        }

                        .bgc\:grey5 {
                            background-color: var(--lns-color-grey5)
                        }

                        .bgc\:grey4 {
                            background-color: var(--lns-color-grey4)
                        }

                        .bgc\:grey3 {
                            background-color: var(--lns-color-grey3)
                        }

                        .bgc\:grey2 {
                            background-color: var(--lns-color-grey2)
                        }

                        .bgc\:grey1 {
                            background-color: var(--lns-color-grey1)
                        }

                        .bgc\:white {
                            background-color: var(--lns-color-white)
                        }

                        .bgc\:primary {
                            background-color: var(--lns-color-primary)
                        }

                        .bgc\:primaryHover {
                            background-color: var(--lns-color-primaryHover)
                        }

                        .bgc\:primaryActive {
                            background-color: var(--lns-color-primaryActive)
                        }

                        .bgc\:body {
                            background-color: var(--lns-color-body)
                        }

                        .bgc\:bodyDimmed {
                            background-color: var(--lns-color-bodyDimmed)
                        }

                        .bgc\:background {
                            background-color: var(--lns-color-background)
                        }

                        .bgc\:backgroundHover {
                            background-color: var(--lns-color-backgroundHover)
                        }

                        .bgc\:backgroundActive {
                            background-color: var(--lns-color-backgroundActive)
                        }

                        .bgc\:backgroundSecondary {
                            background-color: var(--lns-color-backgroundSecondary)
                        }

                        .bgc\:backgroundSecondary2 {
                            background-color: var(--lns-color-backgroundSecondary2)
                        }

                        .bgc\:overlay {
                            background-color: var(--lns-color-overlay)
                        }

                        .bgc\:border {
                            background-color: var(--lns-color-border)
                        }

                        .bgc\:focusRing {
                            background-color: var(--lns-color-focusRing)
                        }

                        .bgc\:record {
                            background-color: var(--lns-color-record)
                        }

                        .bgc\:recordHover {
                            background-color: var(--lns-color-recordHover)
                        }

                        .bgc\:recordActive {
                            background-color: var(--lns-color-recordActive)
                        }

                        .bgc\:info {
                            background-color: var(--lns-color-info)
                        }

                        .bgc\:success {
                            background-color: var(--lns-color-success)
                        }

                        .bgc\:warning {
                            background-color: var(--lns-color-warning)
                        }

                        .bgc\:danger {
                            background-color: var(--lns-color-danger)
                        }

                        .bgc\:dangerHover {
                            background-color: var(--lns-color-dangerHover)
                        }

                        .bgc\:dangerActive {
                            background-color: var(--lns-color-dangerActive)
                        }

                        .bgc\:backdrop {
                            background-color: var(--lns-color-backdrop)
                        }

                        .bgc\:backdropDark {
                            background-color: var(--lns-color-backdropDark)
                        }

                        .bgc\:backdropTwilight {
                            background-color: var(--lns-color-backdropTwilight)
                        }

                        .bgc\:disabledContent {
                            background-color: var(--lns-color-disabledContent)
                        }

                        .bgc\:highlight {
                            background-color: var(--lns-color-highlight)
                        }

                        .bgc\:disabledBackground {
                            background-color: var(--lns-color-disabledBackground)
                        }

                        .bgc\:formFieldBorder {
                            background-color: var(--lns-color-formFieldBorder)
                        }

                        .bgc\:formFieldBackground {
                            background-color: var(--lns-color-formFieldBackground)
                        }

                        .bgc\:buttonBorder {
                            background-color: var(--lns-color-buttonBorder)
                        }

                        .bgc\:upgrade {
                            background-color: var(--lns-color-upgrade)
                        }

                        .bgc\:upgradeHover {
                            background-color: var(--lns-color-upgradeHover)
                        }

                        .bgc\:upgradeActive {
                            background-color: var(--lns-color-upgradeActive)
                        }

                        .bgc\:tabBackground {
                            background-color: var(--lns-color-tabBackground)
                        }

                        .bgc\:discoveryBackground {
                            background-color: var(--lns-color-discoveryBackground)
                        }

                        .bgc\:discoveryLightBackground {
                            background-color: var(--lns-color-discoveryLightBackground)
                        }

                        .bgc\:discoveryTitle {
                            background-color: var(--lns-color-discoveryTitle)
                        }

                        .bgc\:discoveryHighlight {
                            background-color: var(--lns-color-discoveryHighlight)
                        }

                        .m\:0 {
                            margin: 0
                        }

                        .m\:auto {
                            margin: auto
                        }

                        .m\:xsmall {
                            margin: var(--lns-space-xsmall)
                        }

                        .m\:small {
                            margin: var(--lns-space-small)
                        }

                        .m\:medium {
                            margin: var(--lns-space-medium)
                        }

                        .m\:large {
                            margin: var(--lns-space-large)
                        }

                        .m\:xlarge {
                            margin: var(--lns-space-xlarge)
                        }

                        .m\:xxlarge {
                            margin: var(--lns-space-xxlarge)
                        }

                        .mt\:0 {
                            margin-top: 0
                        }

                        .mt\:auto {
                            margin-top: auto
                        }

                        .mt\:xsmall {
                            margin-top: var(--lns-space-xsmall)
                        }

                        .mt\:small {
                            margin-top: var(--lns-space-small)
                        }

                        .mt\:medium {
                            margin-top: var(--lns-space-medium)
                        }

                        .mt\:large {
                            margin-top: var(--lns-space-large)
                        }

                        .mt\:xlarge {
                            margin-top: var(--lns-space-xlarge)
                        }

                        .mt\:xxlarge {
                            margin-top: var(--lns-space-xxlarge)
                        }

                        .mb\:0 {
                            margin-bottom: 0
                        }

                        .mb\:auto {
                            margin-bottom: auto
                        }

                        .mb\:xsmall {
                            margin-bottom: var(--lns-space-xsmall)
                        }

                        .mb\:small {
                            margin-bottom: var(--lns-space-small)
                        }

                        .mb\:medium {
                            margin-bottom: var(--lns-space-medium)
                        }

                        .mb\:large {
                            margin-bottom: var(--lns-space-large)
                        }

                        .mb\:xlarge {
                            margin-bottom: var(--lns-space-xlarge)
                        }

                        .mb\:xxlarge {
                            margin-bottom: var(--lns-space-xxlarge)
                        }

                        .ml\:0 {
                            margin-left: 0
                        }

                        .ml\:auto {
                            margin-left: auto
                        }

                        .ml\:xsmall {
                            margin-left: var(--lns-space-xsmall)
                        }

                        .ml\:small {
                            margin-left: var(--lns-space-small)
                        }

                        .ml\:medium {
                            margin-left: var(--lns-space-medium)
                        }

                        .ml\:large {
                            margin-left: var(--lns-space-large)
                        }

                        .ml\:xlarge {
                            margin-left: var(--lns-space-xlarge)
                        }

                        .ml\:xxlarge {
                            margin-left: var(--lns-space-xxlarge)
                        }

                        .mr\:0 {
                            margin-right: 0
                        }

                        .mr\:auto {
                            margin-right: auto
                        }

                        .mr\:xsmall {
                            margin-right: var(--lns-space-xsmall)
                        }

                        .mr\:small {
                            margin-right: var(--lns-space-small)
                        }

                        .mr\:medium {
                            margin-right: var(--lns-space-medium)
                        }

                        .mr\:large {
                            margin-right: var(--lns-space-large)
                        }

                        .mr\:xlarge {
                            margin-right: var(--lns-space-xlarge)
                        }

                        .mr\:xxlarge {
                            margin-right: var(--lns-space-xxlarge)
                        }

                        .mx\:0 {
                            margin-left: 0;
                            margin-right: 0
                        }

                        .mx\:auto {
                            margin-left: auto;
                            margin-right: auto
                        }

                        .mx\:xsmall {
                            margin-left: var(--lns-space-xsmall);
                            margin-right: var(--lns-space-xsmall)
                        }

                        .mx\:small {
                            margin-left: var(--lns-space-small);
                            margin-right: var(--lns-space-small)
                        }

                        .mx\:medium {
                            margin-left: var(--lns-space-medium);
                            margin-right: var(--lns-space-medium)
                        }

                        .mx\:large {
                            margin-left: var(--lns-space-large);
                            margin-right: var(--lns-space-large)
                        }

                        .mx\:xlarge {
                            margin-left: var(--lns-space-xlarge);
                            margin-right: var(--lns-space-xlarge)
                        }

                        .mx\:xxlarge {
                            margin-left: var(--lns-space-xxlarge);
                            margin-right: var(--lns-space-xxlarge)
                        }

                        .my\:0 {
                            margin-top: 0;
                            margin-bottom: 0
                        }

                        .my\:auto {
                            margin-top: auto;
                            margin-bottom: auto
                        }

                        .my\:xsmall {
                            margin-top: var(--lns-space-xsmall);
                            margin-bottom: var(--lns-space-xsmall)
                        }

                        .my\:small {
                            margin-top: var(--lns-space-small);
                            margin-bottom: var(--lns-space-small)
                        }

                        .my\:medium {
                            margin-top: var(--lns-space-medium);
                            margin-bottom: var(--lns-space-medium)
                        }

                        .my\:large {
                            margin-top: var(--lns-space-large);
                            margin-bottom: var(--lns-space-large)
                        }

                        .my\:xlarge {
                            margin-top: var(--lns-space-xlarge);
                            margin-bottom: var(--lns-space-xlarge)
                        }

                        .my\:xxlarge {
                            margin-top: var(--lns-space-xxlarge);
                            margin-bottom: var(--lns-space-xxlarge)
                        }

                        .p\:0 {
                            padding: 0
                        }

                        .p\:xsmall {
                            padding: var(--lns-space-xsmall)
                        }

                        .p\:small {
                            padding: var(--lns-space-small)
                        }

                        .p\:medium {
                            padding: var(--lns-space-medium)
                        }

                        .p\:large {
                            padding: var(--lns-space-large)
                        }

                        .p\:xlarge {
                            padding: var(--lns-space-xlarge)
                        }

                        .p\:xxlarge {
                            padding: var(--lns-space-xxlarge)
                        }

                        .pt\:0 {
                            padding-top: 0
                        }

                        .pt\:xsmall {
                            padding-top: var(--lns-space-xsmall)
                        }

                        .pt\:small {
                            padding-top: var(--lns-space-small)
                        }

                        .pt\:medium {
                            padding-top: var(--lns-space-medium)
                        }

                        .pt\:large {
                            padding-top: var(--lns-space-large)
                        }

                        .pt\:xlarge {
                            padding-top: var(--lns-space-xlarge)
                        }

                        .pt\:xxlarge {
                            padding-top: var(--lns-space-xxlarge)
                        }

                        .pb\:0 {
                            padding-bottom: 0
                        }

                        .pb\:xsmall {
                            padding-bottom: var(--lns-space-xsmall)
                        }

                        .pb\:small {
                            padding-bottom: var(--lns-space-small)
                        }

                        .pb\:medium {
                            padding-bottom: var(--lns-space-medium)
                        }

                        .pb\:large {
                            padding-bottom: var(--lns-space-large)
                        }

                        .pb\:xlarge {
                            padding-bottom: var(--lns-space-xlarge)
                        }

                        .pb\:xxlarge {
                            padding-bottom: var(--lns-space-xxlarge)
                        }

                        .pl\:0 {
                            padding-left: 0
                        }

                        .pl\:xsmall {
                            padding-left: var(--lns-space-xsmall)
                        }

                        .pl\:small {
                            padding-left: var(--lns-space-small)
                        }

                        .pl\:medium {
                            padding-left: var(--lns-space-medium)
                        }

                        .pl\:large {
                            padding-left: var(--lns-space-large)
                        }

                        .pl\:xlarge {
                            padding-left: var(--lns-space-xlarge)
                        }

                        .pl\:xxlarge {
                            padding-left: var(--lns-space-xxlarge)
                        }

                        .pr\:0 {
                            padding-right: 0
                        }

                        .pr\:xsmall {
                            padding-right: var(--lns-space-xsmall)
                        }

                        .pr\:small {
                            padding-right: var(--lns-space-small)
                        }

                        .pr\:medium {
                            padding-right: var(--lns-space-medium)
                        }

                        .pr\:large {
                            padding-right: var(--lns-space-large)
                        }

                        .pr\:xlarge {
                            padding-right: var(--lns-space-xlarge)
                        }

                        .pr\:xxlarge {
                            padding-right: var(--lns-space-xxlarge)
                        }

                        .px\:0 {
                            padding-left: 0;
                            padding-right: 0
                        }

                        .px\:xsmall {
                            padding-left: var(--lns-space-xsmall);
                            padding-right: var(--lns-space-xsmall)
                        }

                        .px\:small {
                            padding-left: var(--lns-space-small);
                            padding-right: var(--lns-space-small)
                        }

                        .px\:medium {
                            padding-left: var(--lns-space-medium);
                            padding-right: var(--lns-space-medium)
                        }

                        .px\:large {
                            padding-left: var(--lns-space-large);
                            padding-right: var(--lns-space-large)
                        }

                        .px\:xlarge {
                            padding-left: var(--lns-space-xlarge);
                            padding-right: var(--lns-space-xlarge)
                        }

                        .px\:xxlarge {
                            padding-left: var(--lns-space-xxlarge);
                            padding-right: var(--lns-space-xxlarge)
                        }

                        .py\:0 {
                            padding-top: 0;
                            padding-bottom: 0
                        }

                        .py\:xsmall {
                            padding-top: var(--lns-space-xsmall);
                            padding-bottom: var(--lns-space-xsmall)
                        }

                        .py\:small {
                            padding-top: var(--lns-space-small);
                            padding-bottom: var(--lns-space-small)
                        }

                        .py\:medium {
                            padding-top: var(--lns-space-medium);
                            padding-bottom: var(--lns-space-medium)
                        }

                        .py\:large {
                            padding-top: var(--lns-space-large);
                            padding-bottom: var(--lns-space-large)
                        }

                        .py\:xlarge {
                            padding-top: var(--lns-space-xlarge);
                            padding-bottom: var(--lns-space-xlarge)
                        }

                        .py\:xxlarge {
                            padding-top: var(--lns-space-xxlarge);
                            padding-bottom: var(--lns-space-xxlarge)
                        }

                        .text\:small {
                            font-size: var(--lns-fontSize-small);
                            line-height: var(--lns-lineHeight-small)
                        }

                        .text\:body-sm {
                            font-size: var(--lns-fontSize-body-sm);
                            line-height: var(--lns-lineHeight-body-sm)
                        }

                        .text\:medium {
                            font-size: var(--lns-fontSize-medium);
                            line-height: var(--lns-lineHeight-medium)
                        }

                        .text\:body-md {
                            font-size: var(--lns-fontSize-body-md);
                            line-height: var(--lns-lineHeight-body-md)
                        }

                        .text\:large {
                            font-size: var(--lns-fontSize-large);
                            line-height: var(--lns-lineHeight-large)
                        }

                        .text\:body-lg {
                            font-size: var(--lns-fontSize-body-lg);
                            line-height: var(--lns-lineHeight-body-lg)
                        }

                        .text\:xlarge {
                            font-size: var(--lns-fontSize-xlarge);
                            line-height: var(--lns-lineHeight-xlarge)
                        }

                        .text\:heading-sm {
                            font-size: var(--lns-fontSize-heading-sm);
                            line-height: var(--lns-lineHeight-heading-sm)
                        }

                        .text\:xxlarge {
                            font-size: var(--lns-fontSize-xxlarge);
                            line-height: var(--lns-lineHeight-xxlarge)
                        }

                        .text\:heading-md {
                            font-size: var(--lns-fontSize-heading-md);
                            line-height: var(--lns-lineHeight-heading-md)
                        }

                        .text\:xxxlarge {
                            font-size: var(--lns-fontSize-xxxlarge);
                            line-height: var(--lns-lineHeight-xxxlarge)
                        }

                        .text\:heading-lg {
                            font-size: var(--lns-fontSize-heading-lg);
                            line-height: var(--lns-lineHeight-heading-lg)
                        }

                        .weight\:book {
                            font-weight: var(--lns-fontWeight-book)
                        }

                        .weight\:bold {
                            font-weight: var(--lns-fontWeight-bold)
                        }

                        .text\:body {
                            font-size: var(--lns-fontSize-body-md);
                            line-height: var(--lns-lineHeight-body-md);
                            font-weight: var(--lns-fontWeight-book)
                        }

                        .text\:title {
                            font-size: var(--lns-fontSize-body-lg);
                            line-height: var(--lns-lineHeight-body-lg);
                            font-weight: var(--lns-fontWeight-bold)
                        }

                        .text\:mainTitle {
                            font-size: var(--lns-fontSize-heading-md);
                            line-height: var(--lns-lineHeight-heading-md);
                            font-weight: var(--lns-fontWeight-bold)
                        }

                        .text\:left {
                            text-align: left
                        }

                        .text\:right {
                            text-align: right
                        }

                        .text\:center {
                            text-align: center
                        }

                        .border {
                            border: 1px solid var(--lns-color-border)
                        }

                        .borderTop {
                            border-top: 1px solid var(--lns-color-border)
                        }

                        .borderBottom {
                            border-bottom: 1px solid var(--lns-color-border)
                        }

                        .borderLeft {
                            border-left: 1px solid var(--lns-color-border)
                        }

                        .borderRight {
                            border-right: 1px solid var(--lns-color-border)
                        }

                        .inline {
                            display: inline
                        }

                        .block {
                            display: block
                        }

                        .flex {
                            display: flex
                        }

                        .inlineBlock {
                            display: inline-block
                        }

                        .inlineFlex {
                            display: inline-flex
                        }

                        .none {
                            display: none
                        }

                        .flexWrap {
                            flex-wrap: wrap
                        }

                        .flexDirection\:column {
                            flex-direction: column
                        }

                        .flexDirection\:row {
                            flex-direction: row
                        }

                        .items\:stretch {
                            align-items: stretch
                        }

                        .items\:center {
                            align-items: center
                        }

                        .items\:baseline {
                            align-items: baseline
                        }

                        .items\:flexStart {
                            align-items: flex-start
                        }

                        .items\:flexEnd {
                            align-items: flex-end
                        }

                        .items\:selfStart {
                            align-items: self-start
                        }

                        .items\:selfEnd {
                            align-items: self-end
                        }

                        .justify\:flexStart {
                            justify-content: flex-start
                        }

                        .justify\:flexEnd {
                            justify-content: flex-end
                        }

                        .justify\:center {
                            justify-content: center
                        }

                        .justify\:spaceBetween {
                            justify-content: space-between
                        }

                        .justify\:spaceAround {
                            justify-content: space-around
                        }

                        .justify\:spaceEvenly {
                            justify-content: space-evenly
                        }

                        .grow\:0 {
                            flex-grow: 0
                        }

                        .grow\:1 {
                            flex-grow: 1
                        }

                        .shrink\:0 {
                            flex-shrink: 0
                        }

                        .shrink\:1 {
                            flex-shrink: 1
                        }

                        .self\:auto {
                            align-self: auto
                        }

                        .self\:flexStart {
                            align-self: flex-start
                        }

                        .self\:flexEnd {
                            align-self: flex-end
                        }

                        .self\:center {
                            align-self: center
                        }

                        .self\:baseline {
                            align-self: baseline
                        }

                        .self\:stretch {
                            align-self: stretch
                        }

                        .overflow\:hidden {
                            overflow: hidden
                        }

                        .overflow\:auto {
                            overflow: auto
                        }

                        .relative {
                            position: relative
                        }

                        .absolute {
                            position: absolute
                        }

                        .sticky {
                            position: sticky
                        }

                        .fixed {
                            position: fixed
                        }

                        .top\:0 {
                            top: 0
                        }

                        .top\:auto {
                            top: auto
                        }

                        .top\:xsmall {
                            top: var(--lns-space-xsmall)
                        }

                        .top\:small {
                            top: var(--lns-space-small)
                        }

                        .top\:medium {
                            top: var(--lns-space-medium)
                        }

                        .top\:large {
                            top: var(--lns-space-large)
                        }

                        .top\:xlarge {
                            top: var(--lns-space-xlarge)
                        }

                        .top\:xxlarge {
                            top: var(--lns-space-xxlarge)
                        }

                        .bottom\:0 {
                            bottom: 0
                        }

                        .bottom\:auto {
                            bottom: auto
                        }

                        .bottom\:xsmall {
                            bottom: var(--lns-space-xsmall)
                        }

                        .bottom\:small {
                            bottom: var(--lns-space-small)
                        }

                        .bottom\:medium {
                            bottom: var(--lns-space-medium)
                        }

                        .bottom\:large {
                            bottom: var(--lns-space-large)
                        }

                        .bottom\:xlarge {
                            bottom: var(--lns-space-xlarge)
                        }

                        .bottom\:xxlarge {
                            bottom: var(--lns-space-xxlarge)
                        }

                        .left\:0 {
                            left: 0
                        }

                        .left\:auto {
                            left: auto
                        }

                        .left\:xsmall {
                            left: var(--lns-space-xsmall)
                        }

                        .left\:small {
                            left: var(--lns-space-small)
                        }

                        .left\:medium {
                            left: var(--lns-space-medium)
                        }

                        .left\:large {
                            left: var(--lns-space-large)
                        }

                        .left\:xlarge {
                            left: var(--lns-space-xlarge)
                        }

                        .left\:xxlarge {
                            left: var(--lns-space-xxlarge)
                        }

                        .right\:0 {
                            right: 0
                        }

                        .right\:auto {
                            right: auto
                        }

                        .right\:xsmall {
                            right: var(--lns-space-xsmall)
                        }

                        .right\:small {
                            right: var(--lns-space-small)
                        }

                        .right\:medium {
                            right: var(--lns-space-medium)
                        }

                        .right\:large {
                            right: var(--lns-space-large)
                        }

                        .right\:xlarge {
                            right: var(--lns-space-xlarge)
                        }

                        .right\:xxlarge {
                            right: var(--lns-space-xxlarge)
                        }

                        .width\:auto {
                            width: auto
                        }

                        .width\:full {
                            width: 100%
                        }

                        .width\:0 {
                            width: 0
                        }

                        .minWidth\:0 {
                            min-width: 0
                        }

                        .height\:auto {
                            height: auto
                        }

                        .height\:full {
                            height: 100%
                        }

                        .height\:0 {
                            height: 0
                        }

                        .ellipsis {
                            overflow: hidden;
                            text-overflow: ellipsis;
                            white-space: nowrap
                        }

                        .srOnly {
                            position: absolute;
                            width: 1px;
                            height: 1px;
                            padding: 0;
                            margin: -1px;
                            overflow: hidden;
                            clip: rect(0, 0, 0, 0);
                            white-space: nowrap;
                            border-width: 0
                        }

                        @media(min-width:31em) {
                            .xs-c\:red {
                                color: var(--lns-color-red)
                            }

                            .xs-c\:blurpleLight {
                                color: var(--lns-color-blurpleLight)
                            }

                            .xs-c\:blurpleMedium {
                                color: var(--lns-color-blurpleMedium)
                            }

                            .xs-c\:blurple {
                                color: var(--lns-color-blurple)
                            }

                            .xs-c\:blurpleDark {
                                color: var(--lns-color-blurpleDark)
                            }

                            .xs-c\:blurpleStrong {
                                color: var(--lns-color-blurpleStrong)
                            }

                            .xs-c\:offWhite {
                                color: var(--lns-color-offWhite)
                            }

                            .xs-c\:blueLight {
                                color: var(--lns-color-blueLight)
                            }

                            .xs-c\:blue {
                                color: var(--lns-color-blue)
                            }

                            .xs-c\:blueDark {
                                color: var(--lns-color-blueDark)
                            }

                            .xs-c\:orangeLight {
                                color: var(--lns-color-orangeLight)
                            }

                            .xs-c\:orange {
                                color: var(--lns-color-orange)
                            }

                            .xs-c\:orangeDark {
                                color: var(--lns-color-orangeDark)
                            }

                            .xs-c\:tealLight {
                                color: var(--lns-color-tealLight)
                            }

                            .xs-c\:teal {
                                color: var(--lns-color-teal)
                            }

                            .xs-c\:tealDark {
                                color: var(--lns-color-tealDark)
                            }

                            .xs-c\:yellowLight {
                                color: var(--lns-color-yellowLight)
                            }

                            .xs-c\:yellow {
                                color: var(--lns-color-yellow)
                            }

                            .xs-c\:yellowDark {
                                color: var(--lns-color-yellowDark)
                            }

                            .xs-c\:grey8 {
                                color: var(--lns-color-grey8)
                            }

                            .xs-c\:grey7 {
                                color: var(--lns-color-grey7)
                            }

                            .xs-c\:grey6 {
                                color: var(--lns-color-grey6)
                            }

                            .xs-c\:grey5 {
                                color: var(--lns-color-grey5)
                            }

                            .xs-c\:grey4 {
                                color: var(--lns-color-grey4)
                            }

                            .xs-c\:grey3 {
                                color: var(--lns-color-grey3)
                            }

                            .xs-c\:grey2 {
                                color: var(--lns-color-grey2)
                            }

                            .xs-c\:grey1 {
                                color: var(--lns-color-grey1)
                            }

                            .xs-c\:white {
                                color: var(--lns-color-white)
                            }

                            .xs-c\:primary {
                                color: var(--lns-color-primary)
                            }

                            .xs-c\:primaryHover {
                                color: var(--lns-color-primaryHover)
                            }

                            .xs-c\:primaryActive {
                                color: var(--lns-color-primaryActive)
                            }

                            .xs-c\:body {
                                color: var(--lns-color-body)
                            }

                            .xs-c\:bodyDimmed {
                                color: var(--lns-color-bodyDimmed)
                            }

                            .xs-c\:background {
                                color: var(--lns-color-background)
                            }

                            .xs-c\:backgroundHover {
                                color: var(--lns-color-backgroundHover)
                            }

                            .xs-c\:backgroundActive {
                                color: var(--lns-color-backgroundActive)
                            }

                            .xs-c\:backgroundSecondary {
                                color: var(--lns-color-backgroundSecondary)
                            }

                            .xs-c\:backgroundSecondary2 {
                                color: var(--lns-color-backgroundSecondary2)
                            }

                            .xs-c\:overlay {
                                color: var(--lns-color-overlay)
                            }

                            .xs-c\:border {
                                color: var(--lns-color-border)
                            }

                            .xs-c\:focusRing {
                                color: var(--lns-color-focusRing)
                            }

                            .xs-c\:record {
                                color: var(--lns-color-record)
                            }

                            .xs-c\:recordHover {
                                color: var(--lns-color-recordHover)
                            }

                            .xs-c\:recordActive {
                                color: var(--lns-color-recordActive)
                            }

                            .xs-c\:info {
                                color: var(--lns-color-info)
                            }

                            .xs-c\:success {
                                color: var(--lns-color-success)
                            }

                            .xs-c\:warning {
                                color: var(--lns-color-warning)
                            }

                            .xs-c\:danger {
                                color: var(--lns-color-danger)
                            }

                            .xs-c\:dangerHover {
                                color: var(--lns-color-dangerHover)
                            }

                            .xs-c\:dangerActive {
                                color: var(--lns-color-dangerActive)
                            }

                            .xs-c\:backdrop {
                                color: var(--lns-color-backdrop)
                            }

                            .xs-c\:backdropDark {
                                color: var(--lns-color-backdropDark)
                            }

                            .xs-c\:backdropTwilight {
                                color: var(--lns-color-backdropTwilight)
                            }

                            .xs-c\:disabledContent {
                                color: var(--lns-color-disabledContent)
                            }

                            .xs-c\:highlight {
                                color: var(--lns-color-highlight)
                            }

                            .xs-c\:disabledBackground {
                                color: var(--lns-color-disabledBackground)
                            }

                            .xs-c\:formFieldBorder {
                                color: var(--lns-color-formFieldBorder)
                            }

                            .xs-c\:formFieldBackground {
                                color: var(--lns-color-formFieldBackground)
                            }

                            .xs-c\:buttonBorder {
                                color: var(--lns-color-buttonBorder)
                            }

                            .xs-c\:upgrade {
                                color: var(--lns-color-upgrade)
                            }

                            .xs-c\:upgradeHover {
                                color: var(--lns-color-upgradeHover)
                            }

                            .xs-c\:upgradeActive {
                                color: var(--lns-color-upgradeActive)
                            }

                            .xs-c\:tabBackground {
                                color: var(--lns-color-tabBackground)
                            }

                            .xs-c\:discoveryBackground {
                                color: var(--lns-color-discoveryBackground)
                            }

                            .xs-c\:discoveryLightBackground {
                                color: var(--lns-color-discoveryLightBackground)
                            }

                            .xs-c\:discoveryTitle {
                                color: var(--lns-color-discoveryTitle)
                            }

                            .xs-c\:discoveryHighlight {
                                color: var(--lns-color-discoveryHighlight)
                            }

                            .xs-shadow\:small {
                                box-shadow: var(--lns-shadow-small)
                            }

                            .xs-shadow\:medium {
                                box-shadow: var(--lns-shadow-medium)
                            }

                            .xs-shadow\:large {
                                box-shadow: var(--lns-shadow-large)
                            }

                            .xs-radius\:medium {
                                border-radius: var(--lns-radius-medium)
                            }

                            .xs-radius\:large {
                                border-radius: var(--lns-radius-large)
                            }

                            .xs-radius\:xlarge {
                                border-radius: var(--lns-radius-xlarge)
                            }

                            .xs-radius\:full {
                                border-radius: var(--lns-radius-full)
                            }

                            .xs-bgc\:red {
                                background-color: var(--lns-color-red)
                            }

                            .xs-bgc\:blurpleLight {
                                background-color: var(--lns-color-blurpleLight)
                            }

                            .xs-bgc\:blurpleMedium {
                                background-color: var(--lns-color-blurpleMedium)
                            }

                            .xs-bgc\:blurple {
                                background-color: var(--lns-color-blurple)
                            }

                            .xs-bgc\:blurpleDark {
                                background-color: var(--lns-color-blurpleDark)
                            }

                            .xs-bgc\:blurpleStrong {
                                background-color: var(--lns-color-blurpleStrong)
                            }

                            .xs-bgc\:offWhite {
                                background-color: var(--lns-color-offWhite)
                            }

                            .xs-bgc\:blueLight {
                                background-color: var(--lns-color-blueLight)
                            }

                            .xs-bgc\:blue {
                                background-color: var(--lns-color-blue)
                            }

                            .xs-bgc\:blueDark {
                                background-color: var(--lns-color-blueDark)
                            }

                            .xs-bgc\:orangeLight {
                                background-color: var(--lns-color-orangeLight)
                            }

                            .xs-bgc\:orange {
                                background-color: var(--lns-color-orange)
                            }

                            .xs-bgc\:orangeDark {
                                background-color: var(--lns-color-orangeDark)
                            }

                            .xs-bgc\:tealLight {
                                background-color: var(--lns-color-tealLight)
                            }

                            .xs-bgc\:teal {
                                background-color: var(--lns-color-teal)
                            }

                            .xs-bgc\:tealDark {
                                background-color: var(--lns-color-tealDark)
                            }

                            .xs-bgc\:yellowLight {
                                background-color: var(--lns-color-yellowLight)
                            }

                            .xs-bgc\:yellow {
                                background-color: var(--lns-color-yellow)
                            }

                            .xs-bgc\:yellowDark {
                                background-color: var(--lns-color-yellowDark)
                            }

                            .xs-bgc\:grey8 {
                                background-color: var(--lns-color-grey8)
                            }

                            .xs-bgc\:grey7 {
                                background-color: var(--lns-color-grey7)
                            }

                            .xs-bgc\:grey6 {
                                background-color: var(--lns-color-grey6)
                            }

                            .xs-bgc\:grey5 {
                                background-color: var(--lns-color-grey5)
                            }

                            .xs-bgc\:grey4 {
                                background-color: var(--lns-color-grey4)
                            }

                            .xs-bgc\:grey3 {
                                background-color: var(--lns-color-grey3)
                            }

                            .xs-bgc\:grey2 {
                                background-color: var(--lns-color-grey2)
                            }

                            .xs-bgc\:grey1 {
                                background-color: var(--lns-color-grey1)
                            }

                            .xs-bgc\:white {
                                background-color: var(--lns-color-white)
                            }

                            .xs-bgc\:primary {
                                background-color: var(--lns-color-primary)
                            }

                            .xs-bgc\:primaryHover {
                                background-color: var(--lns-color-primaryHover)
                            }

                            .xs-bgc\:primaryActive {
                                background-color: var(--lns-color-primaryActive)
                            }

                            .xs-bgc\:body {
                                background-color: var(--lns-color-body)
                            }

                            .xs-bgc\:bodyDimmed {
                                background-color: var(--lns-color-bodyDimmed)
                            }

                            .xs-bgc\:background {
                                background-color: var(--lns-color-background)
                            }

                            .xs-bgc\:backgroundHover {
                                background-color: var(--lns-color-backgroundHover)
                            }

                            .xs-bgc\:backgroundActive {
                                background-color: var(--lns-color-backgroundActive)
                            }

                            .xs-bgc\:backgroundSecondary {
                                background-color: var(--lns-color-backgroundSecondary)
                            }

                            .xs-bgc\:backgroundSecondary2 {
                                background-color: var(--lns-color-backgroundSecondary2)
                            }

                            .xs-bgc\:overlay {
                                background-color: var(--lns-color-overlay)
                            }

                            .xs-bgc\:border {
                                background-color: var(--lns-color-border)
                            }

                            .xs-bgc\:focusRing {
                                background-color: var(--lns-color-focusRing)
                            }

                            .xs-bgc\:record {
                                background-color: var(--lns-color-record)
                            }

                            .xs-bgc\:recordHover {
                                background-color: var(--lns-color-recordHover)
                            }

                            .xs-bgc\:recordActive {
                                background-color: var(--lns-color-recordActive)
                            }

                            .xs-bgc\:info {
                                background-color: var(--lns-color-info)
                            }

                            .xs-bgc\:success {
                                background-color: var(--lns-color-success)
                            }

                            .xs-bgc\:warning {
                                background-color: var(--lns-color-warning)
                            }

                            .xs-bgc\:danger {
                                background-color: var(--lns-color-danger)
                            }

                            .xs-bgc\:dangerHover {
                                background-color: var(--lns-color-dangerHover)
                            }

                            .xs-bgc\:dangerActive {
                                background-color: var(--lns-color-dangerActive)
                            }

                            .xs-bgc\:backdrop {
                                background-color: var(--lns-color-backdrop)
                            }

                            .xs-bgc\:backdropDark {
                                background-color: var(--lns-color-backdropDark)
                            }

                            .xs-bgc\:backdropTwilight {
                                background-color: var(--lns-color-backdropTwilight)
                            }

                            .xs-bgc\:disabledContent {
                                background-color: var(--lns-color-disabledContent)
                            }

                            .xs-bgc\:highlight {
                                background-color: var(--lns-color-highlight)
                            }

                            .xs-bgc\:disabledBackground {
                                background-color: var(--lns-color-disabledBackground)
                            }

                            .xs-bgc\:formFieldBorder {
                                background-color: var(--lns-color-formFieldBorder)
                            }

                            .xs-bgc\:formFieldBackground {
                                background-color: var(--lns-color-formFieldBackground)
                            }

                            .xs-bgc\:buttonBorder {
                                background-color: var(--lns-color-buttonBorder)
                            }

                            .xs-bgc\:upgrade {
                                background-color: var(--lns-color-upgrade)
                            }

                            .xs-bgc\:upgradeHover {
                                background-color: var(--lns-color-upgradeHover)
                            }

                            .xs-bgc\:upgradeActive {
                                background-color: var(--lns-color-upgradeActive)
                            }

                            .xs-bgc\:tabBackground {
                                background-color: var(--lns-color-tabBackground)
                            }

                            .xs-bgc\:discoveryBackground {
                                background-color: var(--lns-color-discoveryBackground)
                            }

                            .xs-bgc\:discoveryLightBackground {
                                background-color: var(--lns-color-discoveryLightBackground)
                            }

                            .xs-bgc\:discoveryTitle {
                                background-color: var(--lns-color-discoveryTitle)
                            }

                            .xs-bgc\:discoveryHighlight {
                                background-color: var(--lns-color-discoveryHighlight)
                            }

                            .xs-m\:0 {
                                margin: 0
                            }

                            .xs-m\:auto {
                                margin: auto
                            }

                            .xs-m\:xsmall {
                                margin: var(--lns-space-xsmall)
                            }

                            .xs-m\:small {
                                margin: var(--lns-space-small)
                            }

                            .xs-m\:medium {
                                margin: var(--lns-space-medium)
                            }

                            .xs-m\:large {
                                margin: var(--lns-space-large)
                            }

                            .xs-m\:xlarge {
                                margin: var(--lns-space-xlarge)
                            }

                            .xs-m\:xxlarge {
                                margin: var(--lns-space-xxlarge)
                            }

                            .xs-mt\:0 {
                                margin-top: 0
                            }

                            .xs-mt\:auto {
                                margin-top: auto
                            }

                            .xs-mt\:xsmall {
                                margin-top: var(--lns-space-xsmall)
                            }

                            .xs-mt\:small {
                                margin-top: var(--lns-space-small)
                            }

                            .xs-mt\:medium {
                                margin-top: var(--lns-space-medium)
                            }

                            .xs-mt\:large {
                                margin-top: var(--lns-space-large)
                            }

                            .xs-mt\:xlarge {
                                margin-top: var(--lns-space-xlarge)
                            }

                            .xs-mt\:xxlarge {
                                margin-top: var(--lns-space-xxlarge)
                            }

                            .xs-mb\:0 {
                                margin-bottom: 0
                            }

                            .xs-mb\:auto {
                                margin-bottom: auto
                            }

                            .xs-mb\:xsmall {
                                margin-bottom: var(--lns-space-xsmall)
                            }

                            .xs-mb\:small {
                                margin-bottom: var(--lns-space-small)
                            }

                            .xs-mb\:medium {
                                margin-bottom: var(--lns-space-medium)
                            }

                            .xs-mb\:large {
                                margin-bottom: var(--lns-space-large)
                            }

                            .xs-mb\:xlarge {
                                margin-bottom: var(--lns-space-xlarge)
                            }

                            .xs-mb\:xxlarge {
                                margin-bottom: var(--lns-space-xxlarge)
                            }

                            .xs-ml\:0 {
                                margin-left: 0
                            }

                            .xs-ml\:auto {
                                margin-left: auto
                            }

                            .xs-ml\:xsmall {
                                margin-left: var(--lns-space-xsmall)
                            }

                            .xs-ml\:small {
                                margin-left: var(--lns-space-small)
                            }

                            .xs-ml\:medium {
                                margin-left: var(--lns-space-medium)
                            }

                            .xs-ml\:large {
                                margin-left: var(--lns-space-large)
                            }

                            .xs-ml\:xlarge {
                                margin-left: var(--lns-space-xlarge)
                            }

                            .xs-ml\:xxlarge {
                                margin-left: var(--lns-space-xxlarge)
                            }

                            .xs-mr\:0 {
                                margin-right: 0
                            }

                            .xs-mr\:auto {
                                margin-right: auto
                            }

                            .xs-mr\:xsmall {
                                margin-right: var(--lns-space-xsmall)
                            }

                            .xs-mr\:small {
                                margin-right: var(--lns-space-small)
                            }

                            .xs-mr\:medium {
                                margin-right: var(--lns-space-medium)
                            }

                            .xs-mr\:large {
                                margin-right: var(--lns-space-large)
                            }

                            .xs-mr\:xlarge {
                                margin-right: var(--lns-space-xlarge)
                            }

                            .xs-mr\:xxlarge {
                                margin-right: var(--lns-space-xxlarge)
                            }

                            .xs-mx\:0 {
                                margin-left: 0;
                                margin-right: 0
                            }

                            .xs-mx\:auto {
                                margin-left: auto;
                                margin-right: auto
                            }

                            .xs-mx\:xsmall {
                                margin-left: var(--lns-space-xsmall);
                                margin-right: var(--lns-space-xsmall)
                            }

                            .xs-mx\:small {
                                margin-left: var(--lns-space-small);
                                margin-right: var(--lns-space-small)
                            }

                            .xs-mx\:medium {
                                margin-left: var(--lns-space-medium);
                                margin-right: var(--lns-space-medium)
                            }

                            .xs-mx\:large {
                                margin-left: var(--lns-space-large);
                                margin-right: var(--lns-space-large)
                            }

                            .xs-mx\:xlarge {
                                margin-left: var(--lns-space-xlarge);
                                margin-right: var(--lns-space-xlarge)
                            }

                            .xs-mx\:xxlarge {
                                margin-left: var(--lns-space-xxlarge);
                                margin-right: var(--lns-space-xxlarge)
                            }

                            .xs-my\:0 {
                                margin-top: 0;
                                margin-bottom: 0
                            }

                            .xs-my\:auto {
                                margin-top: auto;
                                margin-bottom: auto
                            }

                            .xs-my\:xsmall {
                                margin-top: var(--lns-space-xsmall);
                                margin-bottom: var(--lns-space-xsmall)
                            }

                            .xs-my\:small {
                                margin-top: var(--lns-space-small);
                                margin-bottom: var(--lns-space-small)
                            }

                            .xs-my\:medium {
                                margin-top: var(--lns-space-medium);
                                margin-bottom: var(--lns-space-medium)
                            }

                            .xs-my\:large {
                                margin-top: var(--lns-space-large);
                                margin-bottom: var(--lns-space-large)
                            }

                            .xs-my\:xlarge {
                                margin-top: var(--lns-space-xlarge);
                                margin-bottom: var(--lns-space-xlarge)
                            }

                            .xs-my\:xxlarge {
                                margin-top: var(--lns-space-xxlarge);
                                margin-bottom: var(--lns-space-xxlarge)
                            }

                            .xs-p\:0 {
                                padding: 0
                            }

                            .xs-p\:xsmall {
                                padding: var(--lns-space-xsmall)
                            }

                            .xs-p\:small {
                                padding: var(--lns-space-small)
                            }

                            .xs-p\:medium {
                                padding: var(--lns-space-medium)
                            }

                            .xs-p\:large {
                                padding: var(--lns-space-large)
                            }

                            .xs-p\:xlarge {
                                padding: var(--lns-space-xlarge)
                            }

                            .xs-p\:xxlarge {
                                padding: var(--lns-space-xxlarge)
                            }

                            .xs-pt\:0 {
                                padding-top: 0
                            }

                            .xs-pt\:xsmall {
                                padding-top: var(--lns-space-xsmall)
                            }

                            .xs-pt\:small {
                                padding-top: var(--lns-space-small)
                            }

                            .xs-pt\:medium {
                                padding-top: var(--lns-space-medium)
                            }

                            .xs-pt\:large {
                                padding-top: var(--lns-space-large)
                            }

                            .xs-pt\:xlarge {
                                padding-top: var(--lns-space-xlarge)
                            }

                            .xs-pt\:xxlarge {
                                padding-top: var(--lns-space-xxlarge)
                            }

                            .xs-pb\:0 {
                                padding-bottom: 0
                            }

                            .xs-pb\:xsmall {
                                padding-bottom: var(--lns-space-xsmall)
                            }

                            .xs-pb\:small {
                                padding-bottom: var(--lns-space-small)
                            }

                            .xs-pb\:medium {
                                padding-bottom: var(--lns-space-medium)
                            }

                            .xs-pb\:large {
                                padding-bottom: var(--lns-space-large)
                            }

                            .xs-pb\:xlarge {
                                padding-bottom: var(--lns-space-xlarge)
                            }

                            .xs-pb\:xxlarge {
                                padding-bottom: var(--lns-space-xxlarge)
                            }

                            .xs-pl\:0 {
                                padding-left: 0
                            }

                            .xs-pl\:xsmall {
                                padding-left: var(--lns-space-xsmall)
                            }

                            .xs-pl\:small {
                                padding-left: var(--lns-space-small)
                            }

                            .xs-pl\:medium {
                                padding-left: var(--lns-space-medium)
                            }

                            .xs-pl\:large {
                                padding-left: var(--lns-space-large)
                            }

                            .xs-pl\:xlarge {
                                padding-left: var(--lns-space-xlarge)
                            }

                            .xs-pl\:xxlarge {
                                padding-left: var(--lns-space-xxlarge)
                            }

                            .xs-pr\:0 {
                                padding-right: 0
                            }

                            .xs-pr\:xsmall {
                                padding-right: var(--lns-space-xsmall)
                            }

                            .xs-pr\:small {
                                padding-right: var(--lns-space-small)
                            }

                            .xs-pr\:medium {
                                padding-right: var(--lns-space-medium)
                            }

                            .xs-pr\:large {
                                padding-right: var(--lns-space-large)
                            }

                            .xs-pr\:xlarge {
                                padding-right: var(--lns-space-xlarge)
                            }

                            .xs-pr\:xxlarge {
                                padding-right: var(--lns-space-xxlarge)
                            }

                            .xs-px\:0 {
                                padding-left: 0;
                                padding-right: 0
                            }

                            .xs-px\:xsmall {
                                padding-left: var(--lns-space-xsmall);
                                padding-right: var(--lns-space-xsmall)
                            }

                            .xs-px\:small {
                                padding-left: var(--lns-space-small);
                                padding-right: var(--lns-space-small)
                            }

                            .xs-px\:medium {
                                padding-left: var(--lns-space-medium);
                                padding-right: var(--lns-space-medium)
                            }

                            .xs-px\:large {
                                padding-left: var(--lns-space-large);
                                padding-right: var(--lns-space-large)
                            }

                            .xs-px\:xlarge {
                                padding-left: var(--lns-space-xlarge);
                                padding-right: var(--lns-space-xlarge)
                            }

                            .xs-px\:xxlarge {
                                padding-left: var(--lns-space-xxlarge);
                                padding-right: var(--lns-space-xxlarge)
                            }

                            .xs-py\:0 {
                                padding-top: 0;
                                padding-bottom: 0
                            }

                            .xs-py\:xsmall {
                                padding-top: var(--lns-space-xsmall);
                                padding-bottom: var(--lns-space-xsmall)
                            }

                            .xs-py\:small {
                                padding-top: var(--lns-space-small);
                                padding-bottom: var(--lns-space-small)
                            }

                            .xs-py\:medium {
                                padding-top: var(--lns-space-medium);
                                padding-bottom: var(--lns-space-medium)
                            }

                            .xs-py\:large {
                                padding-top: var(--lns-space-large);
                                padding-bottom: var(--lns-space-large)
                            }

                            .xs-py\:xlarge {
                                padding-top: var(--lns-space-xlarge);
                                padding-bottom: var(--lns-space-xlarge)
                            }

                            .xs-py\:xxlarge {
                                padding-top: var(--lns-space-xxlarge);
                                padding-bottom: var(--lns-space-xxlarge)
                            }

                            .xs-text\:small {
                                font-size: var(--lns-fontSize-small);
                                line-height: var(--lns-lineHeight-small)
                            }

                            .xs-text\:body-sm {
                                font-size: var(--lns-fontSize-body-sm);
                                line-height: var(--lns-lineHeight-body-sm)
                            }

                            .xs-text\:medium {
                                font-size: var(--lns-fontSize-medium);
                                line-height: var(--lns-lineHeight-medium)
                            }

                            .xs-text\:body-md {
                                font-size: var(--lns-fontSize-body-md);
                                line-height: var(--lns-lineHeight-body-md)
                            }

                            .xs-text\:large {
                                font-size: var(--lns-fontSize-large);
                                line-height: var(--lns-lineHeight-large)
                            }

                            .xs-text\:body-lg {
                                font-size: var(--lns-fontSize-body-lg);
                                line-height: var(--lns-lineHeight-body-lg)
                            }

                            .xs-text\:xlarge {
                                font-size: var(--lns-fontSize-xlarge);
                                line-height: var(--lns-lineHeight-xlarge)
                            }

                            .xs-text\:heading-sm {
                                font-size: var(--lns-fontSize-heading-sm);
                                line-height: var(--lns-lineHeight-heading-sm)
                            }

                            .xs-text\:xxlarge {
                                font-size: var(--lns-fontSize-xxlarge);
                                line-height: var(--lns-lineHeight-xxlarge)
                            }

                            .xs-text\:heading-md {
                                font-size: var(--lns-fontSize-heading-md);
                                line-height: var(--lns-lineHeight-heading-md)
                            }

                            .xs-text\:xxxlarge {
                                font-size: var(--lns-fontSize-xxxlarge);
                                line-height: var(--lns-lineHeight-xxxlarge)
                            }

                            .xs-text\:heading-lg {
                                font-size: var(--lns-fontSize-heading-lg);
                                line-height: var(--lns-lineHeight-heading-lg)
                            }

                            .xs-weight\:book {
                                font-weight: var(--lns-fontWeight-book)
                            }

                            .xs-weight\:bold {
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .xs-text\:body {
                                font-size: var(--lns-fontSize-body-md);
                                line-height: var(--lns-lineHeight-body-md);
                                font-weight: var(--lns-fontWeight-book)
                            }

                            .xs-text\:title {
                                font-size: var(--lns-fontSize-body-lg);
                                line-height: var(--lns-lineHeight-body-lg);
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .xs-text\:mainTitle {
                                font-size: var(--lns-fontSize-heading-md);
                                line-height: var(--lns-lineHeight-heading-md);
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .xs-text\:left {
                                text-align: left
                            }

                            .xs-text\:right {
                                text-align: right
                            }

                            .xs-text\:center {
                                text-align: center
                            }

                            .xs-border {
                                border: 1px solid var(--lns-color-border)
                            }

                            .xs-borderTop {
                                border-top: 1px solid var(--lns-color-border)
                            }

                            .xs-borderBottom {
                                border-bottom: 1px solid var(--lns-color-border)
                            }

                            .xs-borderLeft {
                                border-left: 1px solid var(--lns-color-border)
                            }

                            .xs-borderRight {
                                border-right: 1px solid var(--lns-color-border)
                            }

                            .xs-inline {
                                display: inline
                            }

                            .xs-block {
                                display: block
                            }

                            .xs-flex {
                                display: flex
                            }

                            .xs-inlineBlock {
                                display: inline-block
                            }

                            .xs-inlineFlex {
                                display: inline-flex
                            }

                            .xs-none {
                                display: none
                            }

                            .xs-flexWrap {
                                flex-wrap: wrap
                            }

                            .xs-flexDirection\:column {
                                flex-direction: column
                            }

                            .xs-flexDirection\:row {
                                flex-direction: row
                            }

                            .xs-items\:stretch {
                                align-items: stretch
                            }

                            .xs-items\:center {
                                align-items: center
                            }

                            .xs-items\:baseline {
                                align-items: baseline
                            }

                            .xs-items\:flexStart {
                                align-items: flex-start
                            }

                            .xs-items\:flexEnd {
                                align-items: flex-end
                            }

                            .xs-items\:selfStart {
                                align-items: self-start
                            }

                            .xs-items\:selfEnd {
                                align-items: self-end
                            }

                            .xs-justify\:flexStart {
                                justify-content: flex-start
                            }

                            .xs-justify\:flexEnd {
                                justify-content: flex-end
                            }

                            .xs-justify\:center {
                                justify-content: center
                            }

                            .xs-justify\:spaceBetween {
                                justify-content: space-between
                            }

                            .xs-justify\:spaceAround {
                                justify-content: space-around
                            }

                            .xs-justify\:spaceEvenly {
                                justify-content: space-evenly
                            }

                            .xs-grow\:0 {
                                flex-grow: 0
                            }

                            .xs-grow\:1 {
                                flex-grow: 1
                            }

                            .xs-shrink\:0 {
                                flex-shrink: 0
                            }

                            .xs-shrink\:1 {
                                flex-shrink: 1
                            }

                            .xs-self\:auto {
                                align-self: auto
                            }

                            .xs-self\:flexStart {
                                align-self: flex-start
                            }

                            .xs-self\:flexEnd {
                                align-self: flex-end
                            }

                            .xs-self\:center {
                                align-self: center
                            }

                            .xs-self\:baseline {
                                align-self: baseline
                            }

                            .xs-self\:stretch {
                                align-self: stretch
                            }

                            .xs-overflow\:hidden {
                                overflow: hidden
                            }

                            .xs-overflow\:auto {
                                overflow: auto
                            }

                            .xs-relative {
                                position: relative
                            }

                            .xs-absolute {
                                position: absolute
                            }

                            .xs-sticky {
                                position: sticky
                            }

                            .xs-fixed {
                                position: fixed
                            }

                            .xs-top\:0 {
                                top: 0
                            }

                            .xs-top\:auto {
                                top: auto
                            }

                            .xs-top\:xsmall {
                                top: var(--lns-space-xsmall)
                            }

                            .xs-top\:small {
                                top: var(--lns-space-small)
                            }

                            .xs-top\:medium {
                                top: var(--lns-space-medium)
                            }

                            .xs-top\:large {
                                top: var(--lns-space-large)
                            }

                            .xs-top\:xlarge {
                                top: var(--lns-space-xlarge)
                            }

                            .xs-top\:xxlarge {
                                top: var(--lns-space-xxlarge)
                            }

                            .xs-bottom\:0 {
                                bottom: 0
                            }

                            .xs-bottom\:auto {
                                bottom: auto
                            }

                            .xs-bottom\:xsmall {
                                bottom: var(--lns-space-xsmall)
                            }

                            .xs-bottom\:small {
                                bottom: var(--lns-space-small)
                            }

                            .xs-bottom\:medium {
                                bottom: var(--lns-space-medium)
                            }

                            .xs-bottom\:large {
                                bottom: var(--lns-space-large)
                            }

                            .xs-bottom\:xlarge {
                                bottom: var(--lns-space-xlarge)
                            }

                            .xs-bottom\:xxlarge {
                                bottom: var(--lns-space-xxlarge)
                            }

                            .xs-left\:0 {
                                left: 0
                            }

                            .xs-left\:auto {
                                left: auto
                            }

                            .xs-left\:xsmall {
                                left: var(--lns-space-xsmall)
                            }

                            .xs-left\:small {
                                left: var(--lns-space-small)
                            }

                            .xs-left\:medium {
                                left: var(--lns-space-medium)
                            }

                            .xs-left\:large {
                                left: var(--lns-space-large)
                            }

                            .xs-left\:xlarge {
                                left: var(--lns-space-xlarge)
                            }

                            .xs-left\:xxlarge {
                                left: var(--lns-space-xxlarge)
                            }

                            .xs-right\:0 {
                                right: 0
                            }

                            .xs-right\:auto {
                                right: auto
                            }

                            .xs-right\:xsmall {
                                right: var(--lns-space-xsmall)
                            }

                            .xs-right\:small {
                                right: var(--lns-space-small)
                            }

                            .xs-right\:medium {
                                right: var(--lns-space-medium)
                            }

                            .xs-right\:large {
                                right: var(--lns-space-large)
                            }

                            .xs-right\:xlarge {
                                right: var(--lns-space-xlarge)
                            }

                            .xs-right\:xxlarge {
                                right: var(--lns-space-xxlarge)
                            }

                            .xs-width\:auto {
                                width: auto
                            }

                            .xs-width\:full {
                                width: 100%
                            }

                            .xs-width\:0 {
                                width: 0
                            }

                            .xs-minWidth\:0 {
                                min-width: 0
                            }

                            .xs-height\:auto {
                                height: auto
                            }

                            .xs-height\:full {
                                height: 100%
                            }

                            .xs-height\:0 {
                                height: 0
                            }

                            .xs-ellipsis {
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap
                            }

                            .xs-srOnly {
                                position: absolute;
                                width: 1px;
                                height: 1px;
                                padding: 0;
                                margin: -1px;
                                overflow: hidden;
                                clip: rect(0, 0, 0, 0);
                                white-space: nowrap;
                                border-width: 0
                            }
                        }

                        @media(min-width:48em) {
                            .sm-c\:red {
                                color: var(--lns-color-red)
                            }

                            .sm-c\:blurpleLight {
                                color: var(--lns-color-blurpleLight)
                            }

                            .sm-c\:blurpleMedium {
                                color: var(--lns-color-blurpleMedium)
                            }

                            .sm-c\:blurple {
                                color: var(--lns-color-blurple)
                            }

                            .sm-c\:blurpleDark {
                                color: var(--lns-color-blurpleDark)
                            }

                            .sm-c\:blurpleStrong {
                                color: var(--lns-color-blurpleStrong)
                            }

                            .sm-c\:offWhite {
                                color: var(--lns-color-offWhite)
                            }

                            .sm-c\:blueLight {
                                color: var(--lns-color-blueLight)
                            }

                            .sm-c\:blue {
                                color: var(--lns-color-blue)
                            }

                            .sm-c\:blueDark {
                                color: var(--lns-color-blueDark)
                            }

                            .sm-c\:orangeLight {
                                color: var(--lns-color-orangeLight)
                            }

                            .sm-c\:orange {
                                color: var(--lns-color-orange)
                            }

                            .sm-c\:orangeDark {
                                color: var(--lns-color-orangeDark)
                            }

                            .sm-c\:tealLight {
                                color: var(--lns-color-tealLight)
                            }

                            .sm-c\:teal {
                                color: var(--lns-color-teal)
                            }

                            .sm-c\:tealDark {
                                color: var(--lns-color-tealDark)
                            }

                            .sm-c\:yellowLight {
                                color: var(--lns-color-yellowLight)
                            }

                            .sm-c\:yellow {
                                color: var(--lns-color-yellow)
                            }

                            .sm-c\:yellowDark {
                                color: var(--lns-color-yellowDark)
                            }

                            .sm-c\:grey8 {
                                color: var(--lns-color-grey8)
                            }

                            .sm-c\:grey7 {
                                color: var(--lns-color-grey7)
                            }

                            .sm-c\:grey6 {
                                color: var(--lns-color-grey6)
                            }

                            .sm-c\:grey5 {
                                color: var(--lns-color-grey5)
                            }

                            .sm-c\:grey4 {
                                color: var(--lns-color-grey4)
                            }

                            .sm-c\:grey3 {
                                color: var(--lns-color-grey3)
                            }

                            .sm-c\:grey2 {
                                color: var(--lns-color-grey2)
                            }

                            .sm-c\:grey1 {
                                color: var(--lns-color-grey1)
                            }

                            .sm-c\:white {
                                color: var(--lns-color-white)
                            }

                            .sm-c\:primary {
                                color: var(--lns-color-primary)
                            }

                            .sm-c\:primaryHover {
                                color: var(--lns-color-primaryHover)
                            }

                            .sm-c\:primaryActive {
                                color: var(--lns-color-primaryActive)
                            }

                            .sm-c\:body {
                                color: var(--lns-color-body)
                            }

                            .sm-c\:bodyDimmed {
                                color: var(--lns-color-bodyDimmed)
                            }

                            .sm-c\:background {
                                color: var(--lns-color-background)
                            }

                            .sm-c\:backgroundHover {
                                color: var(--lns-color-backgroundHover)
                            }

                            .sm-c\:backgroundActive {
                                color: var(--lns-color-backgroundActive)
                            }

                            .sm-c\:backgroundSecondary {
                                color: var(--lns-color-backgroundSecondary)
                            }

                            .sm-c\:backgroundSecondary2 {
                                color: var(--lns-color-backgroundSecondary2)
                            }

                            .sm-c\:overlay {
                                color: var(--lns-color-overlay)
                            }

                            .sm-c\:border {
                                color: var(--lns-color-border)
                            }

                            .sm-c\:focusRing {
                                color: var(--lns-color-focusRing)
                            }

                            .sm-c\:record {
                                color: var(--lns-color-record)
                            }

                            .sm-c\:recordHover {
                                color: var(--lns-color-recordHover)
                            }

                            .sm-c\:recordActive {
                                color: var(--lns-color-recordActive)
                            }

                            .sm-c\:info {
                                color: var(--lns-color-info)
                            }

                            .sm-c\:success {
                                color: var(--lns-color-success)
                            }

                            .sm-c\:warning {
                                color: var(--lns-color-warning)
                            }

                            .sm-c\:danger {
                                color: var(--lns-color-danger)
                            }

                            .sm-c\:dangerHover {
                                color: var(--lns-color-dangerHover)
                            }

                            .sm-c\:dangerActive {
                                color: var(--lns-color-dangerActive)
                            }

                            .sm-c\:backdrop {
                                color: var(--lns-color-backdrop)
                            }

                            .sm-c\:backdropDark {
                                color: var(--lns-color-backdropDark)
                            }

                            .sm-c\:backdropTwilight {
                                color: var(--lns-color-backdropTwilight)
                            }

                            .sm-c\:disabledContent {
                                color: var(--lns-color-disabledContent)
                            }

                            .sm-c\:highlight {
                                color: var(--lns-color-highlight)
                            }

                            .sm-c\:disabledBackground {
                                color: var(--lns-color-disabledBackground)
                            }

                            .sm-c\:formFieldBorder {
                                color: var(--lns-color-formFieldBorder)
                            }

                            .sm-c\:formFieldBackground {
                                color: var(--lns-color-formFieldBackground)
                            }

                            .sm-c\:buttonBorder {
                                color: var(--lns-color-buttonBorder)
                            }

                            .sm-c\:upgrade {
                                color: var(--lns-color-upgrade)
                            }

                            .sm-c\:upgradeHover {
                                color: var(--lns-color-upgradeHover)
                            }

                            .sm-c\:upgradeActive {
                                color: var(--lns-color-upgradeActive)
                            }

                            .sm-c\:tabBackground {
                                color: var(--lns-color-tabBackground)
                            }

                            .sm-c\:discoveryBackground {
                                color: var(--lns-color-discoveryBackground)
                            }

                            .sm-c\:discoveryLightBackground {
                                color: var(--lns-color-discoveryLightBackground)
                            }

                            .sm-c\:discoveryTitle {
                                color: var(--lns-color-discoveryTitle)
                            }

                            .sm-c\:discoveryHighlight {
                                color: var(--lns-color-discoveryHighlight)
                            }

                            .sm-shadow\:small {
                                box-shadow: var(--lns-shadow-small)
                            }

                            .sm-shadow\:medium {
                                box-shadow: var(--lns-shadow-medium)
                            }

                            .sm-shadow\:large {
                                box-shadow: var(--lns-shadow-large)
                            }

                            .sm-radius\:medium {
                                border-radius: var(--lns-radius-medium)
                            }

                            .sm-radius\:large {
                                border-radius: var(--lns-radius-large)
                            }

                            .sm-radius\:xlarge {
                                border-radius: var(--lns-radius-xlarge)
                            }

                            .sm-radius\:full {
                                border-radius: var(--lns-radius-full)
                            }

                            .sm-bgc\:red {
                                background-color: var(--lns-color-red)
                            }

                            .sm-bgc\:blurpleLight {
                                background-color: var(--lns-color-blurpleLight)
                            }

                            .sm-bgc\:blurpleMedium {
                                background-color: var(--lns-color-blurpleMedium)
                            }

                            .sm-bgc\:blurple {
                                background-color: var(--lns-color-blurple)
                            }

                            .sm-bgc\:blurpleDark {
                                background-color: var(--lns-color-blurpleDark)
                            }

                            .sm-bgc\:blurpleStrong {
                                background-color: var(--lns-color-blurpleStrong)
                            }

                            .sm-bgc\:offWhite {
                                background-color: var(--lns-color-offWhite)
                            }

                            .sm-bgc\:blueLight {
                                background-color: var(--lns-color-blueLight)
                            }

                            .sm-bgc\:blue {
                                background-color: var(--lns-color-blue)
                            }

                            .sm-bgc\:blueDark {
                                background-color: var(--lns-color-blueDark)
                            }

                            .sm-bgc\:orangeLight {
                                background-color: var(--lns-color-orangeLight)
                            }

                            .sm-bgc\:orange {
                                background-color: var(--lns-color-orange)
                            }

                            .sm-bgc\:orangeDark {
                                background-color: var(--lns-color-orangeDark)
                            }

                            .sm-bgc\:tealLight {
                                background-color: var(--lns-color-tealLight)
                            }

                            .sm-bgc\:teal {
                                background-color: var(--lns-color-teal)
                            }

                            .sm-bgc\:tealDark {
                                background-color: var(--lns-color-tealDark)
                            }

                            .sm-bgc\:yellowLight {
                                background-color: var(--lns-color-yellowLight)
                            }

                            .sm-bgc\:yellow {
                                background-color: var(--lns-color-yellow)
                            }

                            .sm-bgc\:yellowDark {
                                background-color: var(--lns-color-yellowDark)
                            }

                            .sm-bgc\:grey8 {
                                background-color: var(--lns-color-grey8)
                            }

                            .sm-bgc\:grey7 {
                                background-color: var(--lns-color-grey7)
                            }

                            .sm-bgc\:grey6 {
                                background-color: var(--lns-color-grey6)
                            }

                            .sm-bgc\:grey5 {
                                background-color: var(--lns-color-grey5)
                            }

                            .sm-bgc\:grey4 {
                                background-color: var(--lns-color-grey4)
                            }

                            .sm-bgc\:grey3 {
                                background-color: var(--lns-color-grey3)
                            }

                            .sm-bgc\:grey2 {
                                background-color: var(--lns-color-grey2)
                            }

                            .sm-bgc\:grey1 {
                                background-color: var(--lns-color-grey1)
                            }

                            .sm-bgc\:white {
                                background-color: var(--lns-color-white)
                            }

                            .sm-bgc\:primary {
                                background-color: var(--lns-color-primary)
                            }

                            .sm-bgc\:primaryHover {
                                background-color: var(--lns-color-primaryHover)
                            }

                            .sm-bgc\:primaryActive {
                                background-color: var(--lns-color-primaryActive)
                            }

                            .sm-bgc\:body {
                                background-color: var(--lns-color-body)
                            }

                            .sm-bgc\:bodyDimmed {
                                background-color: var(--lns-color-bodyDimmed)
                            }

                            .sm-bgc\:background {
                                background-color: var(--lns-color-background)
                            }

                            .sm-bgc\:backgroundHover {
                                background-color: var(--lns-color-backgroundHover)
                            }

                            .sm-bgc\:backgroundActive {
                                background-color: var(--lns-color-backgroundActive)
                            }

                            .sm-bgc\:backgroundSecondary {
                                background-color: var(--lns-color-backgroundSecondary)
                            }

                            .sm-bgc\:backgroundSecondary2 {
                                background-color: var(--lns-color-backgroundSecondary2)
                            }

                            .sm-bgc\:overlay {
                                background-color: var(--lns-color-overlay)
                            }

                            .sm-bgc\:border {
                                background-color: var(--lns-color-border)
                            }

                            .sm-bgc\:focusRing {
                                background-color: var(--lns-color-focusRing)
                            }

                            .sm-bgc\:record {
                                background-color: var(--lns-color-record)
                            }

                            .sm-bgc\:recordHover {
                                background-color: var(--lns-color-recordHover)
                            }

                            .sm-bgc\:recordActive {
                                background-color: var(--lns-color-recordActive)
                            }

                            .sm-bgc\:info {
                                background-color: var(--lns-color-info)
                            }

                            .sm-bgc\:success {
                                background-color: var(--lns-color-success)
                            }

                            .sm-bgc\:warning {
                                background-color: var(--lns-color-warning)
                            }

                            .sm-bgc\:danger {
                                background-color: var(--lns-color-danger)
                            }

                            .sm-bgc\:dangerHover {
                                background-color: var(--lns-color-dangerHover)
                            }

                            .sm-bgc\:dangerActive {
                                background-color: var(--lns-color-dangerActive)
                            }

                            .sm-bgc\:backdrop {
                                background-color: var(--lns-color-backdrop)
                            }

                            .sm-bgc\:backdropDark {
                                background-color: var(--lns-color-backdropDark)
                            }

                            .sm-bgc\:backdropTwilight {
                                background-color: var(--lns-color-backdropTwilight)
                            }

                            .sm-bgc\:disabledContent {
                                background-color: var(--lns-color-disabledContent)
                            }

                            .sm-bgc\:highlight {
                                background-color: var(--lns-color-highlight)
                            }

                            .sm-bgc\:disabledBackground {
                                background-color: var(--lns-color-disabledBackground)
                            }

                            .sm-bgc\:formFieldBorder {
                                background-color: var(--lns-color-formFieldBorder)
                            }

                            .sm-bgc\:formFieldBackground {
                                background-color: var(--lns-color-formFieldBackground)
                            }

                            .sm-bgc\:buttonBorder {
                                background-color: var(--lns-color-buttonBorder)
                            }

                            .sm-bgc\:upgrade {
                                background-color: var(--lns-color-upgrade)
                            }

                            .sm-bgc\:upgradeHover {
                                background-color: var(--lns-color-upgradeHover)
                            }

                            .sm-bgc\:upgradeActive {
                                background-color: var(--lns-color-upgradeActive)
                            }

                            .sm-bgc\:tabBackground {
                                background-color: var(--lns-color-tabBackground)
                            }

                            .sm-bgc\:discoveryBackground {
                                background-color: var(--lns-color-discoveryBackground)
                            }

                            .sm-bgc\:discoveryLightBackground {
                                background-color: var(--lns-color-discoveryLightBackground)
                            }

                            .sm-bgc\:discoveryTitle {
                                background-color: var(--lns-color-discoveryTitle)
                            }

                            .sm-bgc\:discoveryHighlight {
                                background-color: var(--lns-color-discoveryHighlight)
                            }

                            .sm-m\:0 {
                                margin: 0
                            }

                            .sm-m\:auto {
                                margin: auto
                            }

                            .sm-m\:xsmall {
                                margin: var(--lns-space-xsmall)
                            }

                            .sm-m\:small {
                                margin: var(--lns-space-small)
                            }

                            .sm-m\:medium {
                                margin: var(--lns-space-medium)
                            }

                            .sm-m\:large {
                                margin: var(--lns-space-large)
                            }

                            .sm-m\:xlarge {
                                margin: var(--lns-space-xlarge)
                            }

                            .sm-m\:xxlarge {
                                margin: var(--lns-space-xxlarge)
                            }

                            .sm-mt\:0 {
                                margin-top: 0
                            }

                            .sm-mt\:auto {
                                margin-top: auto
                            }

                            .sm-mt\:xsmall {
                                margin-top: var(--lns-space-xsmall)
                            }

                            .sm-mt\:small {
                                margin-top: var(--lns-space-small)
                            }

                            .sm-mt\:medium {
                                margin-top: var(--lns-space-medium)
                            }

                            .sm-mt\:large {
                                margin-top: var(--lns-space-large)
                            }

                            .sm-mt\:xlarge {
                                margin-top: var(--lns-space-xlarge)
                            }

                            .sm-mt\:xxlarge {
                                margin-top: var(--lns-space-xxlarge)
                            }

                            .sm-mb\:0 {
                                margin-bottom: 0
                            }

                            .sm-mb\:auto {
                                margin-bottom: auto
                            }

                            .sm-mb\:xsmall {
                                margin-bottom: var(--lns-space-xsmall)
                            }

                            .sm-mb\:small {
                                margin-bottom: var(--lns-space-small)
                            }

                            .sm-mb\:medium {
                                margin-bottom: var(--lns-space-medium)
                            }

                            .sm-mb\:large {
                                margin-bottom: var(--lns-space-large)
                            }

                            .sm-mb\:xlarge {
                                margin-bottom: var(--lns-space-xlarge)
                            }

                            .sm-mb\:xxlarge {
                                margin-bottom: var(--lns-space-xxlarge)
                            }

                            .sm-ml\:0 {
                                margin-left: 0
                            }

                            .sm-ml\:auto {
                                margin-left: auto
                            }

                            .sm-ml\:xsmall {
                                margin-left: var(--lns-space-xsmall)
                            }

                            .sm-ml\:small {
                                margin-left: var(--lns-space-small)
                            }

                            .sm-ml\:medium {
                                margin-left: var(--lns-space-medium)
                            }

                            .sm-ml\:large {
                                margin-left: var(--lns-space-large)
                            }

                            .sm-ml\:xlarge {
                                margin-left: var(--lns-space-xlarge)
                            }

                            .sm-ml\:xxlarge {
                                margin-left: var(--lns-space-xxlarge)
                            }

                            .sm-mr\:0 {
                                margin-right: 0
                            }

                            .sm-mr\:auto {
                                margin-right: auto
                            }

                            .sm-mr\:xsmall {
                                margin-right: var(--lns-space-xsmall)
                            }

                            .sm-mr\:small {
                                margin-right: var(--lns-space-small)
                            }

                            .sm-mr\:medium {
                                margin-right: var(--lns-space-medium)
                            }

                            .sm-mr\:large {
                                margin-right: var(--lns-space-large)
                            }

                            .sm-mr\:xlarge {
                                margin-right: var(--lns-space-xlarge)
                            }

                            .sm-mr\:xxlarge {
                                margin-right: var(--lns-space-xxlarge)
                            }

                            .sm-mx\:0 {
                                margin-left: 0;
                                margin-right: 0
                            }

                            .sm-mx\:auto {
                                margin-left: auto;
                                margin-right: auto
                            }

                            .sm-mx\:xsmall {
                                margin-left: var(--lns-space-xsmall);
                                margin-right: var(--lns-space-xsmall)
                            }

                            .sm-mx\:small {
                                margin-left: var(--lns-space-small);
                                margin-right: var(--lns-space-small)
                            }

                            .sm-mx\:medium {
                                margin-left: var(--lns-space-medium);
                                margin-right: var(--lns-space-medium)
                            }

                            .sm-mx\:large {
                                margin-left: var(--lns-space-large);
                                margin-right: var(--lns-space-large)
                            }

                            .sm-mx\:xlarge {
                                margin-left: var(--lns-space-xlarge);
                                margin-right: var(--lns-space-xlarge)
                            }

                            .sm-mx\:xxlarge {
                                margin-left: var(--lns-space-xxlarge);
                                margin-right: var(--lns-space-xxlarge)
                            }

                            .sm-my\:0 {
                                margin-top: 0;
                                margin-bottom: 0
                            }

                            .sm-my\:auto {
                                margin-top: auto;
                                margin-bottom: auto
                            }

                            .sm-my\:xsmall {
                                margin-top: var(--lns-space-xsmall);
                                margin-bottom: var(--lns-space-xsmall)
                            }

                            .sm-my\:small {
                                margin-top: var(--lns-space-small);
                                margin-bottom: var(--lns-space-small)
                            }

                            .sm-my\:medium {
                                margin-top: var(--lns-space-medium);
                                margin-bottom: var(--lns-space-medium)
                            }

                            .sm-my\:large {
                                margin-top: var(--lns-space-large);
                                margin-bottom: var(--lns-space-large)
                            }

                            .sm-my\:xlarge {
                                margin-top: var(--lns-space-xlarge);
                                margin-bottom: var(--lns-space-xlarge)
                            }

                            .sm-my\:xxlarge {
                                margin-top: var(--lns-space-xxlarge);
                                margin-bottom: var(--lns-space-xxlarge)
                            }

                            .sm-p\:0 {
                                padding: 0
                            }

                            .sm-p\:xsmall {
                                padding: var(--lns-space-xsmall)
                            }

                            .sm-p\:small {
                                padding: var(--lns-space-small)
                            }

                            .sm-p\:medium {
                                padding: var(--lns-space-medium)
                            }

                            .sm-p\:large {
                                padding: var(--lns-space-large)
                            }

                            .sm-p\:xlarge {
                                padding: var(--lns-space-xlarge)
                            }

                            .sm-p\:xxlarge {
                                padding: var(--lns-space-xxlarge)
                            }

                            .sm-pt\:0 {
                                padding-top: 0
                            }

                            .sm-pt\:xsmall {
                                padding-top: var(--lns-space-xsmall)
                            }

                            .sm-pt\:small {
                                padding-top: var(--lns-space-small)
                            }

                            .sm-pt\:medium {
                                padding-top: var(--lns-space-medium)
                            }

                            .sm-pt\:large {
                                padding-top: var(--lns-space-large)
                            }

                            .sm-pt\:xlarge {
                                padding-top: var(--lns-space-xlarge)
                            }

                            .sm-pt\:xxlarge {
                                padding-top: var(--lns-space-xxlarge)
                            }

                            .sm-pb\:0 {
                                padding-bottom: 0
                            }

                            .sm-pb\:xsmall {
                                padding-bottom: var(--lns-space-xsmall)
                            }

                            .sm-pb\:small {
                                padding-bottom: var(--lns-space-small)
                            }

                            .sm-pb\:medium {
                                padding-bottom: var(--lns-space-medium)
                            }

                            .sm-pb\:large {
                                padding-bottom: var(--lns-space-large)
                            }

                            .sm-pb\:xlarge {
                                padding-bottom: var(--lns-space-xlarge)
                            }

                            .sm-pb\:xxlarge {
                                padding-bottom: var(--lns-space-xxlarge)
                            }

                            .sm-pl\:0 {
                                padding-left: 0
                            }

                            .sm-pl\:xsmall {
                                padding-left: var(--lns-space-xsmall)
                            }

                            .sm-pl\:small {
                                padding-left: var(--lns-space-small)
                            }

                            .sm-pl\:medium {
                                padding-left: var(--lns-space-medium)
                            }

                            .sm-pl\:large {
                                padding-left: var(--lns-space-large)
                            }

                            .sm-pl\:xlarge {
                                padding-left: var(--lns-space-xlarge)
                            }

                            .sm-pl\:xxlarge {
                                padding-left: var(--lns-space-xxlarge)
                            }

                            .sm-pr\:0 {
                                padding-right: 0
                            }

                            .sm-pr\:xsmall {
                                padding-right: var(--lns-space-xsmall)
                            }

                            .sm-pr\:small {
                                padding-right: var(--lns-space-small)
                            }

                            .sm-pr\:medium {
                                padding-right: var(--lns-space-medium)
                            }

                            .sm-pr\:large {
                                padding-right: var(--lns-space-large)
                            }

                            .sm-pr\:xlarge {
                                padding-right: var(--lns-space-xlarge)
                            }

                            .sm-pr\:xxlarge {
                                padding-right: var(--lns-space-xxlarge)
                            }

                            .sm-px\:0 {
                                padding-left: 0;
                                padding-right: 0
                            }

                            .sm-px\:xsmall {
                                padding-left: var(--lns-space-xsmall);
                                padding-right: var(--lns-space-xsmall)
                            }

                            .sm-px\:small {
                                padding-left: var(--lns-space-small);
                                padding-right: var(--lns-space-small)
                            }

                            .sm-px\:medium {
                                padding-left: var(--lns-space-medium);
                                padding-right: var(--lns-space-medium)
                            }

                            .sm-px\:large {
                                padding-left: var(--lns-space-large);
                                padding-right: var(--lns-space-large)
                            }

                            .sm-px\:xlarge {
                                padding-left: var(--lns-space-xlarge);
                                padding-right: var(--lns-space-xlarge)
                            }

                            .sm-px\:xxlarge {
                                padding-left: var(--lns-space-xxlarge);
                                padding-right: var(--lns-space-xxlarge)
                            }

                            .sm-py\:0 {
                                padding-top: 0;
                                padding-bottom: 0
                            }

                            .sm-py\:xsmall {
                                padding-top: var(--lns-space-xsmall);
                                padding-bottom: var(--lns-space-xsmall)
                            }

                            .sm-py\:small {
                                padding-top: var(--lns-space-small);
                                padding-bottom: var(--lns-space-small)
                            }

                            .sm-py\:medium {
                                padding-top: var(--lns-space-medium);
                                padding-bottom: var(--lns-space-medium)
                            }

                            .sm-py\:large {
                                padding-top: var(--lns-space-large);
                                padding-bottom: var(--lns-space-large)
                            }

                            .sm-py\:xlarge {
                                padding-top: var(--lns-space-xlarge);
                                padding-bottom: var(--lns-space-xlarge)
                            }

                            .sm-py\:xxlarge {
                                padding-top: var(--lns-space-xxlarge);
                                padding-bottom: var(--lns-space-xxlarge)
                            }

                            .sm-text\:small {
                                font-size: var(--lns-fontSize-small);
                                line-height: var(--lns-lineHeight-small)
                            }

                            .sm-text\:body-sm {
                                font-size: var(--lns-fontSize-body-sm);
                                line-height: var(--lns-lineHeight-body-sm)
                            }

                            .sm-text\:medium {
                                font-size: var(--lns-fontSize-medium);
                                line-height: var(--lns-lineHeight-medium)
                            }

                            .sm-text\:body-md {
                                font-size: var(--lns-fontSize-body-md);
                                line-height: var(--lns-lineHeight-body-md)
                            }

                            .sm-text\:large {
                                font-size: var(--lns-fontSize-large);
                                line-height: var(--lns-lineHeight-large)
                            }

                            .sm-text\:body-lg {
                                font-size: var(--lns-fontSize-body-lg);
                                line-height: var(--lns-lineHeight-body-lg)
                            }

                            .sm-text\:xlarge {
                                font-size: var(--lns-fontSize-xlarge);
                                line-height: var(--lns-lineHeight-xlarge)
                            }

                            .sm-text\:heading-sm {
                                font-size: var(--lns-fontSize-heading-sm);
                                line-height: var(--lns-lineHeight-heading-sm)
                            }

                            .sm-text\:xxlarge {
                                font-size: var(--lns-fontSize-xxlarge);
                                line-height: var(--lns-lineHeight-xxlarge)
                            }

                            .sm-text\:heading-md {
                                font-size: var(--lns-fontSize-heading-md);
                                line-height: var(--lns-lineHeight-heading-md)
                            }

                            .sm-text\:xxxlarge {
                                font-size: var(--lns-fontSize-xxxlarge);
                                line-height: var(--lns-lineHeight-xxxlarge)
                            }

                            .sm-text\:heading-lg {
                                font-size: var(--lns-fontSize-heading-lg);
                                line-height: var(--lns-lineHeight-heading-lg)
                            }

                            .sm-weight\:book {
                                font-weight: var(--lns-fontWeight-book)
                            }

                            .sm-weight\:bold {
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .sm-text\:body {
                                font-size: var(--lns-fontSize-body-md);
                                line-height: var(--lns-lineHeight-body-md);
                                font-weight: var(--lns-fontWeight-book)
                            }

                            .sm-text\:title {
                                font-size: var(--lns-fontSize-body-lg);
                                line-height: var(--lns-lineHeight-body-lg);
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .sm-text\:mainTitle {
                                font-size: var(--lns-fontSize-heading-md);
                                line-height: var(--lns-lineHeight-heading-md);
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .sm-text\:left {
                                text-align: left
                            }

                            .sm-text\:right {
                                text-align: right
                            }

                            .sm-text\:center {
                                text-align: center
                            }

                            .sm-border {
                                border: 1px solid var(--lns-color-border)
                            }

                            .sm-borderTop {
                                border-top: 1px solid var(--lns-color-border)
                            }

                            .sm-borderBottom {
                                border-bottom: 1px solid var(--lns-color-border)
                            }

                            .sm-borderLeft {
                                border-left: 1px solid var(--lns-color-border)
                            }

                            .sm-borderRight {
                                border-right: 1px solid var(--lns-color-border)
                            }

                            .sm-inline {
                                display: inline
                            }

                            .sm-block {
                                display: block
                            }

                            .sm-flex {
                                display: flex
                            }

                            .sm-inlineBlock {
                                display: inline-block
                            }

                            .sm-inlineFlex {
                                display: inline-flex
                            }

                            .sm-none {
                                display: none
                            }

                            .sm-flexWrap {
                                flex-wrap: wrap
                            }

                            .sm-flexDirection\:column {
                                flex-direction: column
                            }

                            .sm-flexDirection\:row {
                                flex-direction: row
                            }

                            .sm-items\:stretch {
                                align-items: stretch
                            }

                            .sm-items\:center {
                                align-items: center
                            }

                            .sm-items\:baseline {
                                align-items: baseline
                            }

                            .sm-items\:flexStart {
                                align-items: flex-start
                            }

                            .sm-items\:flexEnd {
                                align-items: flex-end
                            }

                            .sm-items\:selfStart {
                                align-items: self-start
                            }

                            .sm-items\:selfEnd {
                                align-items: self-end
                            }

                            .sm-justify\:flexStart {
                                justify-content: flex-start
                            }

                            .sm-justify\:flexEnd {
                                justify-content: flex-end
                            }

                            .sm-justify\:center {
                                justify-content: center
                            }

                            .sm-justify\:spaceBetween {
                                justify-content: space-between
                            }

                            .sm-justify\:spaceAround {
                                justify-content: space-around
                            }

                            .sm-justify\:spaceEvenly {
                                justify-content: space-evenly
                            }

                            .sm-grow\:0 {
                                flex-grow: 0
                            }

                            .sm-grow\:1 {
                                flex-grow: 1
                            }

                            .sm-shrink\:0 {
                                flex-shrink: 0
                            }

                            .sm-shrink\:1 {
                                flex-shrink: 1
                            }

                            .sm-self\:auto {
                                align-self: auto
                            }

                            .sm-self\:flexStart {
                                align-self: flex-start
                            }

                            .sm-self\:flexEnd {
                                align-self: flex-end
                            }

                            .sm-self\:center {
                                align-self: center
                            }

                            .sm-self\:baseline {
                                align-self: baseline
                            }

                            .sm-self\:stretch {
                                align-self: stretch
                            }

                            .sm-overflow\:hidden {
                                overflow: hidden
                            }

                            .sm-overflow\:auto {
                                overflow: auto
                            }

                            .sm-relative {
                                position: relative
                            }

                            .sm-absolute {
                                position: absolute
                            }

                            .sm-sticky {
                                position: sticky
                            }

                            .sm-fixed {
                                position: fixed
                            }

                            .sm-top\:0 {
                                top: 0
                            }

                            .sm-top\:auto {
                                top: auto
                            }

                            .sm-top\:xsmall {
                                top: var(--lns-space-xsmall)
                            }

                            .sm-top\:small {
                                top: var(--lns-space-small)
                            }

                            .sm-top\:medium {
                                top: var(--lns-space-medium)
                            }

                            .sm-top\:large {
                                top: var(--lns-space-large)
                            }

                            .sm-top\:xlarge {
                                top: var(--lns-space-xlarge)
                            }

                            .sm-top\:xxlarge {
                                top: var(--lns-space-xxlarge)
                            }

                            .sm-bottom\:0 {
                                bottom: 0
                            }

                            .sm-bottom\:auto {
                                bottom: auto
                            }

                            .sm-bottom\:xsmall {
                                bottom: var(--lns-space-xsmall)
                            }

                            .sm-bottom\:small {
                                bottom: var(--lns-space-small)
                            }

                            .sm-bottom\:medium {
                                bottom: var(--lns-space-medium)
                            }

                            .sm-bottom\:large {
                                bottom: var(--lns-space-large)
                            }

                            .sm-bottom\:xlarge {
                                bottom: var(--lns-space-xlarge)
                            }

                            .sm-bottom\:xxlarge {
                                bottom: var(--lns-space-xxlarge)
                            }

                            .sm-left\:0 {
                                left: 0
                            }

                            .sm-left\:auto {
                                left: auto
                            }

                            .sm-left\:xsmall {
                                left: var(--lns-space-xsmall)
                            }

                            .sm-left\:small {
                                left: var(--lns-space-small)
                            }

                            .sm-left\:medium {
                                left: var(--lns-space-medium)
                            }

                            .sm-left\:large {
                                left: var(--lns-space-large)
                            }

                            .sm-left\:xlarge {
                                left: var(--lns-space-xlarge)
                            }

                            .sm-left\:xxlarge {
                                left: var(--lns-space-xxlarge)
                            }

                            .sm-right\:0 {
                                right: 0
                            }

                            .sm-right\:auto {
                                right: auto
                            }

                            .sm-right\:xsmall {
                                right: var(--lns-space-xsmall)
                            }

                            .sm-right\:small {
                                right: var(--lns-space-small)
                            }

                            .sm-right\:medium {
                                right: var(--lns-space-medium)
                            }

                            .sm-right\:large {
                                right: var(--lns-space-large)
                            }

                            .sm-right\:xlarge {
                                right: var(--lns-space-xlarge)
                            }

                            .sm-right\:xxlarge {
                                right: var(--lns-space-xxlarge)
                            }

                            .sm-width\:auto {
                                width: auto
                            }

                            .sm-width\:full {
                                width: 100%
                            }

                            .sm-width\:0 {
                                width: 0
                            }

                            .sm-minWidth\:0 {
                                min-width: 0
                            }

                            .sm-height\:auto {
                                height: auto
                            }

                            .sm-height\:full {
                                height: 100%
                            }

                            .sm-height\:0 {
                                height: 0
                            }

                            .sm-ellipsis {
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap
                            }

                            .sm-srOnly {
                                position: absolute;
                                width: 1px;
                                height: 1px;
                                padding: 0;
                                margin: -1px;
                                overflow: hidden;
                                clip: rect(0, 0, 0, 0);
                                white-space: nowrap;
                                border-width: 0
                            }
                        }

                        @media(min-width:64em) {
                            .md-c\:red {
                                color: var(--lns-color-red)
                            }

                            .md-c\:blurpleLight {
                                color: var(--lns-color-blurpleLight)
                            }

                            .md-c\:blurpleMedium {
                                color: var(--lns-color-blurpleMedium)
                            }

                            .md-c\:blurple {
                                color: var(--lns-color-blurple)
                            }

                            .md-c\:blurpleDark {
                                color: var(--lns-color-blurpleDark)
                            }

                            .md-c\:blurpleStrong {
                                color: var(--lns-color-blurpleStrong)
                            }

                            .md-c\:offWhite {
                                color: var(--lns-color-offWhite)
                            }

                            .md-c\:blueLight {
                                color: var(--lns-color-blueLight)
                            }

                            .md-c\:blue {
                                color: var(--lns-color-blue)
                            }

                            .md-c\:blueDark {
                                color: var(--lns-color-blueDark)
                            }

                            .md-c\:orangeLight {
                                color: var(--lns-color-orangeLight)
                            }

                            .md-c\:orange {
                                color: var(--lns-color-orange)
                            }

                            .md-c\:orangeDark {
                                color: var(--lns-color-orangeDark)
                            }

                            .md-c\:tealLight {
                                color: var(--lns-color-tealLight)
                            }

                            .md-c\:teal {
                                color: var(--lns-color-teal)
                            }

                            .md-c\:tealDark {
                                color: var(--lns-color-tealDark)
                            }

                            .md-c\:yellowLight {
                                color: var(--lns-color-yellowLight)
                            }

                            .md-c\:yellow {
                                color: var(--lns-color-yellow)
                            }

                            .md-c\:yellowDark {
                                color: var(--lns-color-yellowDark)
                            }

                            .md-c\:grey8 {
                                color: var(--lns-color-grey8)
                            }

                            .md-c\:grey7 {
                                color: var(--lns-color-grey7)
                            }

                            .md-c\:grey6 {
                                color: var(--lns-color-grey6)
                            }

                            .md-c\:grey5 {
                                color: var(--lns-color-grey5)
                            }

                            .md-c\:grey4 {
                                color: var(--lns-color-grey4)
                            }

                            .md-c\:grey3 {
                                color: var(--lns-color-grey3)
                            }

                            .md-c\:grey2 {
                                color: var(--lns-color-grey2)
                            }

                            .md-c\:grey1 {
                                color: var(--lns-color-grey1)
                            }

                            .md-c\:white {
                                color: var(--lns-color-white)
                            }

                            .md-c\:primary {
                                color: var(--lns-color-primary)
                            }

                            .md-c\:primaryHover {
                                color: var(--lns-color-primaryHover)
                            }

                            .md-c\:primaryActive {
                                color: var(--lns-color-primaryActive)
                            }

                            .md-c\:body {
                                color: var(--lns-color-body)
                            }

                            .md-c\:bodyDimmed {
                                color: var(--lns-color-bodyDimmed)
                            }

                            .md-c\:background {
                                color: var(--lns-color-background)
                            }

                            .md-c\:backgroundHover {
                                color: var(--lns-color-backgroundHover)
                            }

                            .md-c\:backgroundActive {
                                color: var(--lns-color-backgroundActive)
                            }

                            .md-c\:backgroundSecondary {
                                color: var(--lns-color-backgroundSecondary)
                            }

                            .md-c\:backgroundSecondary2 {
                                color: var(--lns-color-backgroundSecondary2)
                            }

                            .md-c\:overlay {
                                color: var(--lns-color-overlay)
                            }

                            .md-c\:border {
                                color: var(--lns-color-border)
                            }

                            .md-c\:focusRing {
                                color: var(--lns-color-focusRing)
                            }

                            .md-c\:record {
                                color: var(--lns-color-record)
                            }

                            .md-c\:recordHover {
                                color: var(--lns-color-recordHover)
                            }

                            .md-c\:recordActive {
                                color: var(--lns-color-recordActive)
                            }

                            .md-c\:info {
                                color: var(--lns-color-info)
                            }

                            .md-c\:success {
                                color: var(--lns-color-success)
                            }

                            .md-c\:warning {
                                color: var(--lns-color-warning)
                            }

                            .md-c\:danger {
                                color: var(--lns-color-danger)
                            }

                            .md-c\:dangerHover {
                                color: var(--lns-color-dangerHover)
                            }

                            .md-c\:dangerActive {
                                color: var(--lns-color-dangerActive)
                            }

                            .md-c\:backdrop {
                                color: var(--lns-color-backdrop)
                            }

                            .md-c\:backdropDark {
                                color: var(--lns-color-backdropDark)
                            }

                            .md-c\:backdropTwilight {
                                color: var(--lns-color-backdropTwilight)
                            }

                            .md-c\:disabledContent {
                                color: var(--lns-color-disabledContent)
                            }

                            .md-c\:highlight {
                                color: var(--lns-color-highlight)
                            }

                            .md-c\:disabledBackground {
                                color: var(--lns-color-disabledBackground)
                            }

                            .md-c\:formFieldBorder {
                                color: var(--lns-color-formFieldBorder)
                            }

                            .md-c\:formFieldBackground {
                                color: var(--lns-color-formFieldBackground)
                            }

                            .md-c\:buttonBorder {
                                color: var(--lns-color-buttonBorder)
                            }

                            .md-c\:upgrade {
                                color: var(--lns-color-upgrade)
                            }

                            .md-c\:upgradeHover {
                                color: var(--lns-color-upgradeHover)
                            }

                            .md-c\:upgradeActive {
                                color: var(--lns-color-upgradeActive)
                            }

                            .md-c\:tabBackground {
                                color: var(--lns-color-tabBackground)
                            }

                            .md-c\:discoveryBackground {
                                color: var(--lns-color-discoveryBackground)
                            }

                            .md-c\:discoveryLightBackground {
                                color: var(--lns-color-discoveryLightBackground)
                            }

                            .md-c\:discoveryTitle {
                                color: var(--lns-color-discoveryTitle)
                            }

                            .md-c\:discoveryHighlight {
                                color: var(--lns-color-discoveryHighlight)
                            }

                            .md-shadow\:small {
                                box-shadow: var(--lns-shadow-small)
                            }

                            .md-shadow\:medium {
                                box-shadow: var(--lns-shadow-medium)
                            }

                            .md-shadow\:large {
                                box-shadow: var(--lns-shadow-large)
                            }

                            .md-radius\:medium {
                                border-radius: var(--lns-radius-medium)
                            }

                            .md-radius\:large {
                                border-radius: var(--lns-radius-large)
                            }

                            .md-radius\:xlarge {
                                border-radius: var(--lns-radius-xlarge)
                            }

                            .md-radius\:full {
                                border-radius: var(--lns-radius-full)
                            }

                            .md-bgc\:red {
                                background-color: var(--lns-color-red)
                            }

                            .md-bgc\:blurpleLight {
                                background-color: var(--lns-color-blurpleLight)
                            }

                            .md-bgc\:blurpleMedium {
                                background-color: var(--lns-color-blurpleMedium)
                            }

                            .md-bgc\:blurple {
                                background-color: var(--lns-color-blurple)
                            }

                            .md-bgc\:blurpleDark {
                                background-color: var(--lns-color-blurpleDark)
                            }

                            .md-bgc\:blurpleStrong {
                                background-color: var(--lns-color-blurpleStrong)
                            }

                            .md-bgc\:offWhite {
                                background-color: var(--lns-color-offWhite)
                            }

                            .md-bgc\:blueLight {
                                background-color: var(--lns-color-blueLight)
                            }

                            .md-bgc\:blue {
                                background-color: var(--lns-color-blue)
                            }

                            .md-bgc\:blueDark {
                                background-color: var(--lns-color-blueDark)
                            }

                            .md-bgc\:orangeLight {
                                background-color: var(--lns-color-orangeLight)
                            }

                            .md-bgc\:orange {
                                background-color: var(--lns-color-orange)
                            }

                            .md-bgc\:orangeDark {
                                background-color: var(--lns-color-orangeDark)
                            }

                            .md-bgc\:tealLight {
                                background-color: var(--lns-color-tealLight)
                            }

                            .md-bgc\:teal {
                                background-color: var(--lns-color-teal)
                            }

                            .md-bgc\:tealDark {
                                background-color: var(--lns-color-tealDark)
                            }

                            .md-bgc\:yellowLight {
                                background-color: var(--lns-color-yellowLight)
                            }

                            .md-bgc\:yellow {
                                background-color: var(--lns-color-yellow)
                            }

                            .md-bgc\:yellowDark {
                                background-color: var(--lns-color-yellowDark)
                            }

                            .md-bgc\:grey8 {
                                background-color: var(--lns-color-grey8)
                            }

                            .md-bgc\:grey7 {
                                background-color: var(--lns-color-grey7)
                            }

                            .md-bgc\:grey6 {
                                background-color: var(--lns-color-grey6)
                            }

                            .md-bgc\:grey5 {
                                background-color: var(--lns-color-grey5)
                            }

                            .md-bgc\:grey4 {
                                background-color: var(--lns-color-grey4)
                            }

                            .md-bgc\:grey3 {
                                background-color: var(--lns-color-grey3)
                            }

                            .md-bgc\:grey2 {
                                background-color: var(--lns-color-grey2)
                            }

                            .md-bgc\:grey1 {
                                background-color: var(--lns-color-grey1)
                            }

                            .md-bgc\:white {
                                background-color: var(--lns-color-white)
                            }

                            .md-bgc\:primary {
                                background-color: var(--lns-color-primary)
                            }

                            .md-bgc\:primaryHover {
                                background-color: var(--lns-color-primaryHover)
                            }

                            .md-bgc\:primaryActive {
                                background-color: var(--lns-color-primaryActive)
                            }

                            .md-bgc\:body {
                                background-color: var(--lns-color-body)
                            }

                            .md-bgc\:bodyDimmed {
                                background-color: var(--lns-color-bodyDimmed)
                            }

                            .md-bgc\:background {
                                background-color: var(--lns-color-background)
                            }

                            .md-bgc\:backgroundHover {
                                background-color: var(--lns-color-backgroundHover)
                            }

                            .md-bgc\:backgroundActive {
                                background-color: var(--lns-color-backgroundActive)
                            }

                            .md-bgc\:backgroundSecondary {
                                background-color: var(--lns-color-backgroundSecondary)
                            }

                            .md-bgc\:backgroundSecondary2 {
                                background-color: var(--lns-color-backgroundSecondary2)
                            }

                            .md-bgc\:overlay {
                                background-color: var(--lns-color-overlay)
                            }

                            .md-bgc\:border {
                                background-color: var(--lns-color-border)
                            }

                            .md-bgc\:focusRing {
                                background-color: var(--lns-color-focusRing)
                            }

                            .md-bgc\:record {
                                background-color: var(--lns-color-record)
                            }

                            .md-bgc\:recordHover {
                                background-color: var(--lns-color-recordHover)
                            }

                            .md-bgc\:recordActive {
                                background-color: var(--lns-color-recordActive)
                            }

                            .md-bgc\:info {
                                background-color: var(--lns-color-info)
                            }

                            .md-bgc\:success {
                                background-color: var(--lns-color-success)
                            }

                            .md-bgc\:warning {
                                background-color: var(--lns-color-warning)
                            }

                            .md-bgc\:danger {
                                background-color: var(--lns-color-danger)
                            }

                            .md-bgc\:dangerHover {
                                background-color: var(--lns-color-dangerHover)
                            }

                            .md-bgc\:dangerActive {
                                background-color: var(--lns-color-dangerActive)
                            }

                            .md-bgc\:backdrop {
                                background-color: var(--lns-color-backdrop)
                            }

                            .md-bgc\:backdropDark {
                                background-color: var(--lns-color-backdropDark)
                            }

                            .md-bgc\:backdropTwilight {
                                background-color: var(--lns-color-backdropTwilight)
                            }

                            .md-bgc\:disabledContent {
                                background-color: var(--lns-color-disabledContent)
                            }

                            .md-bgc\:highlight {
                                background-color: var(--lns-color-highlight)
                            }

                            .md-bgc\:disabledBackground {
                                background-color: var(--lns-color-disabledBackground)
                            }

                            .md-bgc\:formFieldBorder {
                                background-color: var(--lns-color-formFieldBorder)
                            }

                            .md-bgc\:formFieldBackground {
                                background-color: var(--lns-color-formFieldBackground)
                            }

                            .md-bgc\:buttonBorder {
                                background-color: var(--lns-color-buttonBorder)
                            }

                            .md-bgc\:upgrade {
                                background-color: var(--lns-color-upgrade)
                            }

                            .md-bgc\:upgradeHover {
                                background-color: var(--lns-color-upgradeHover)
                            }

                            .md-bgc\:upgradeActive {
                                background-color: var(--lns-color-upgradeActive)
                            }

                            .md-bgc\:tabBackground {
                                background-color: var(--lns-color-tabBackground)
                            }

                            .md-bgc\:discoveryBackground {
                                background-color: var(--lns-color-discoveryBackground)
                            }

                            .md-bgc\:discoveryLightBackground {
                                background-color: var(--lns-color-discoveryLightBackground)
                            }

                            .md-bgc\:discoveryTitle {
                                background-color: var(--lns-color-discoveryTitle)
                            }

                            .md-bgc\:discoveryHighlight {
                                background-color: var(--lns-color-discoveryHighlight)
                            }

                            .md-m\:0 {
                                margin: 0
                            }

                            .md-m\:auto {
                                margin: auto
                            }

                            .md-m\:xsmall {
                                margin: var(--lns-space-xsmall)
                            }

                            .md-m\:small {
                                margin: var(--lns-space-small)
                            }

                            .md-m\:medium {
                                margin: var(--lns-space-medium)
                            }

                            .md-m\:large {
                                margin: var(--lns-space-large)
                            }

                            .md-m\:xlarge {
                                margin: var(--lns-space-xlarge)
                            }

                            .md-m\:xxlarge {
                                margin: var(--lns-space-xxlarge)
                            }

                            .md-mt\:0 {
                                margin-top: 0
                            }

                            .md-mt\:auto {
                                margin-top: auto
                            }

                            .md-mt\:xsmall {
                                margin-top: var(--lns-space-xsmall)
                            }

                            .md-mt\:small {
                                margin-top: var(--lns-space-small)
                            }

                            .md-mt\:medium {
                                margin-top: var(--lns-space-medium)
                            }

                            .md-mt\:large {
                                margin-top: var(--lns-space-large)
                            }

                            .md-mt\:xlarge {
                                margin-top: var(--lns-space-xlarge)
                            }

                            .md-mt\:xxlarge {
                                margin-top: var(--lns-space-xxlarge)
                            }

                            .md-mb\:0 {
                                margin-bottom: 0
                            }

                            .md-mb\:auto {
                                margin-bottom: auto
                            }

                            .md-mb\:xsmall {
                                margin-bottom: var(--lns-space-xsmall)
                            }

                            .md-mb\:small {
                                margin-bottom: var(--lns-space-small)
                            }

                            .md-mb\:medium {
                                margin-bottom: var(--lns-space-medium)
                            }

                            .md-mb\:large {
                                margin-bottom: var(--lns-space-large)
                            }

                            .md-mb\:xlarge {
                                margin-bottom: var(--lns-space-xlarge)
                            }

                            .md-mb\:xxlarge {
                                margin-bottom: var(--lns-space-xxlarge)
                            }

                            .md-ml\:0 {
                                margin-left: 0
                            }

                            .md-ml\:auto {
                                margin-left: auto
                            }

                            .md-ml\:xsmall {
                                margin-left: var(--lns-space-xsmall)
                            }

                            .md-ml\:small {
                                margin-left: var(--lns-space-small)
                            }

                            .md-ml\:medium {
                                margin-left: var(--lns-space-medium)
                            }

                            .md-ml\:large {
                                margin-left: var(--lns-space-large)
                            }

                            .md-ml\:xlarge {
                                margin-left: var(--lns-space-xlarge)
                            }

                            .md-ml\:xxlarge {
                                margin-left: var(--lns-space-xxlarge)
                            }

                            .md-mr\:0 {
                                margin-right: 0
                            }

                            .md-mr\:auto {
                                margin-right: auto
                            }

                            .md-mr\:xsmall {
                                margin-right: var(--lns-space-xsmall)
                            }

                            .md-mr\:small {
                                margin-right: var(--lns-space-small)
                            }

                            .md-mr\:medium {
                                margin-right: var(--lns-space-medium)
                            }

                            .md-mr\:large {
                                margin-right: var(--lns-space-large)
                            }

                            .md-mr\:xlarge {
                                margin-right: var(--lns-space-xlarge)
                            }

                            .md-mr\:xxlarge {
                                margin-right: var(--lns-space-xxlarge)
                            }

                            .md-mx\:0 {
                                margin-left: 0;
                                margin-right: 0
                            }

                            .md-mx\:auto {
                                margin-left: auto;
                                margin-right: auto
                            }

                            .md-mx\:xsmall {
                                margin-left: var(--lns-space-xsmall);
                                margin-right: var(--lns-space-xsmall)
                            }

                            .md-mx\:small {
                                margin-left: var(--lns-space-small);
                                margin-right: var(--lns-space-small)
                            }

                            .md-mx\:medium {
                                margin-left: var(--lns-space-medium);
                                margin-right: var(--lns-space-medium)
                            }

                            .md-mx\:large {
                                margin-left: var(--lns-space-large);
                                margin-right: var(--lns-space-large)
                            }

                            .md-mx\:xlarge {
                                margin-left: var(--lns-space-xlarge);
                                margin-right: var(--lns-space-xlarge)
                            }

                            .md-mx\:xxlarge {
                                margin-left: var(--lns-space-xxlarge);
                                margin-right: var(--lns-space-xxlarge)
                            }

                            .md-my\:0 {
                                margin-top: 0;
                                margin-bottom: 0
                            }

                            .md-my\:auto {
                                margin-top: auto;
                                margin-bottom: auto
                            }

                            .md-my\:xsmall {
                                margin-top: var(--lns-space-xsmall);
                                margin-bottom: var(--lns-space-xsmall)
                            }

                            .md-my\:small {
                                margin-top: var(--lns-space-small);
                                margin-bottom: var(--lns-space-small)
                            }

                            .md-my\:medium {
                                margin-top: var(--lns-space-medium);
                                margin-bottom: var(--lns-space-medium)
                            }

                            .md-my\:large {
                                margin-top: var(--lns-space-large);
                                margin-bottom: var(--lns-space-large)
                            }

                            .md-my\:xlarge {
                                margin-top: var(--lns-space-xlarge);
                                margin-bottom: var(--lns-space-xlarge)
                            }

                            .md-my\:xxlarge {
                                margin-top: var(--lns-space-xxlarge);
                                margin-bottom: var(--lns-space-xxlarge)
                            }

                            .md-p\:0 {
                                padding: 0
                            }

                            .md-p\:xsmall {
                                padding: var(--lns-space-xsmall)
                            }

                            .md-p\:small {
                                padding: var(--lns-space-small)
                            }

                            .md-p\:medium {
                                padding: var(--lns-space-medium)
                            }

                            .md-p\:large {
                                padding: var(--lns-space-large)
                            }

                            .md-p\:xlarge {
                                padding: var(--lns-space-xlarge)
                            }

                            .md-p\:xxlarge {
                                padding: var(--lns-space-xxlarge)
                            }

                            .md-pt\:0 {
                                padding-top: 0
                            }

                            .md-pt\:xsmall {
                                padding-top: var(--lns-space-xsmall)
                            }

                            .md-pt\:small {
                                padding-top: var(--lns-space-small)
                            }

                            .md-pt\:medium {
                                padding-top: var(--lns-space-medium)
                            }

                            .md-pt\:large {
                                padding-top: var(--lns-space-large)
                            }

                            .md-pt\:xlarge {
                                padding-top: var(--lns-space-xlarge)
                            }

                            .md-pt\:xxlarge {
                                padding-top: var(--lns-space-xxlarge)
                            }

                            .md-pb\:0 {
                                padding-bottom: 0
                            }

                            .md-pb\:xsmall {
                                padding-bottom: var(--lns-space-xsmall)
                            }

                            .md-pb\:small {
                                padding-bottom: var(--lns-space-small)
                            }

                            .md-pb\:medium {
                                padding-bottom: var(--lns-space-medium)
                            }

                            .md-pb\:large {
                                padding-bottom: var(--lns-space-large)
                            }

                            .md-pb\:xlarge {
                                padding-bottom: var(--lns-space-xlarge)
                            }

                            .md-pb\:xxlarge {
                                padding-bottom: var(--lns-space-xxlarge)
                            }

                            .md-pl\:0 {
                                padding-left: 0
                            }

                            .md-pl\:xsmall {
                                padding-left: var(--lns-space-xsmall)
                            }

                            .md-pl\:small {
                                padding-left: var(--lns-space-small)
                            }

                            .md-pl\:medium {
                                padding-left: var(--lns-space-medium)
                            }

                            .md-pl\:large {
                                padding-left: var(--lns-space-large)
                            }

                            .md-pl\:xlarge {
                                padding-left: var(--lns-space-xlarge)
                            }

                            .md-pl\:xxlarge {
                                padding-left: var(--lns-space-xxlarge)
                            }

                            .md-pr\:0 {
                                padding-right: 0
                            }

                            .md-pr\:xsmall {
                                padding-right: var(--lns-space-xsmall)
                            }

                            .md-pr\:small {
                                padding-right: var(--lns-space-small)
                            }

                            .md-pr\:medium {
                                padding-right: var(--lns-space-medium)
                            }

                            .md-pr\:large {
                                padding-right: var(--lns-space-large)
                            }

                            .md-pr\:xlarge {
                                padding-right: var(--lns-space-xlarge)
                            }

                            .md-pr\:xxlarge {
                                padding-right: var(--lns-space-xxlarge)
                            }

                            .md-px\:0 {
                                padding-left: 0;
                                padding-right: 0
                            }

                            .md-px\:xsmall {
                                padding-left: var(--lns-space-xsmall);
                                padding-right: var(--lns-space-xsmall)
                            }

                            .md-px\:small {
                                padding-left: var(--lns-space-small);
                                padding-right: var(--lns-space-small)
                            }

                            .md-px\:medium {
                                padding-left: var(--lns-space-medium);
                                padding-right: var(--lns-space-medium)
                            }

                            .md-px\:large {
                                padding-left: var(--lns-space-large);
                                padding-right: var(--lns-space-large)
                            }

                            .md-px\:xlarge {
                                padding-left: var(--lns-space-xlarge);
                                padding-right: var(--lns-space-xlarge)
                            }

                            .md-px\:xxlarge {
                                padding-left: var(--lns-space-xxlarge);
                                padding-right: var(--lns-space-xxlarge)
                            }

                            .md-py\:0 {
                                padding-top: 0;
                                padding-bottom: 0
                            }

                            .md-py\:xsmall {
                                padding-top: var(--lns-space-xsmall);
                                padding-bottom: var(--lns-space-xsmall)
                            }

                            .md-py\:small {
                                padding-top: var(--lns-space-small);
                                padding-bottom: var(--lns-space-small)
                            }

                            .md-py\:medium {
                                padding-top: var(--lns-space-medium);
                                padding-bottom: var(--lns-space-medium)
                            }

                            .md-py\:large {
                                padding-top: var(--lns-space-large);
                                padding-bottom: var(--lns-space-large)
                            }

                            .md-py\:xlarge {
                                padding-top: var(--lns-space-xlarge);
                                padding-bottom: var(--lns-space-xlarge)
                            }

                            .md-py\:xxlarge {
                                padding-top: var(--lns-space-xxlarge);
                                padding-bottom: var(--lns-space-xxlarge)
                            }

                            .md-text\:small {
                                font-size: var(--lns-fontSize-small);
                                line-height: var(--lns-lineHeight-small)
                            }

                            .md-text\:body-sm {
                                font-size: var(--lns-fontSize-body-sm);
                                line-height: var(--lns-lineHeight-body-sm)
                            }

                            .md-text\:medium {
                                font-size: var(--lns-fontSize-medium);
                                line-height: var(--lns-lineHeight-medium)
                            }

                            .md-text\:body-md {
                                font-size: var(--lns-fontSize-body-md);
                                line-height: var(--lns-lineHeight-body-md)
                            }

                            .md-text\:large {
                                font-size: var(--lns-fontSize-large);
                                line-height: var(--lns-lineHeight-large)
                            }

                            .md-text\:body-lg {
                                font-size: var(--lns-fontSize-body-lg);
                                line-height: var(--lns-lineHeight-body-lg)
                            }

                            .md-text\:xlarge {
                                font-size: var(--lns-fontSize-xlarge);
                                line-height: var(--lns-lineHeight-xlarge)
                            }

                            .md-text\:heading-sm {
                                font-size: var(--lns-fontSize-heading-sm);
                                line-height: var(--lns-lineHeight-heading-sm)
                            }

                            .md-text\:xxlarge {
                                font-size: var(--lns-fontSize-xxlarge);
                                line-height: var(--lns-lineHeight-xxlarge)
                            }

                            .md-text\:heading-md {
                                font-size: var(--lns-fontSize-heading-md);
                                line-height: var(--lns-lineHeight-heading-md)
                            }

                            .md-text\:xxxlarge {
                                font-size: var(--lns-fontSize-xxxlarge);
                                line-height: var(--lns-lineHeight-xxxlarge)
                            }

                            .md-text\:heading-lg {
                                font-size: var(--lns-fontSize-heading-lg);
                                line-height: var(--lns-lineHeight-heading-lg)
                            }

                            .md-weight\:book {
                                font-weight: var(--lns-fontWeight-book)
                            }

                            .md-weight\:bold {
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .md-text\:body {
                                font-size: var(--lns-fontSize-body-md);
                                line-height: var(--lns-lineHeight-body-md);
                                font-weight: var(--lns-fontWeight-book)
                            }

                            .md-text\:title {
                                font-size: var(--lns-fontSize-body-lg);
                                line-height: var(--lns-lineHeight-body-lg);
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .md-text\:mainTitle {
                                font-size: var(--lns-fontSize-heading-md);
                                line-height: var(--lns-lineHeight-heading-md);
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .md-text\:left {
                                text-align: left
                            }

                            .md-text\:right {
                                text-align: right
                            }

                            .md-text\:center {
                                text-align: center
                            }

                            .md-border {
                                border: 1px solid var(--lns-color-border)
                            }

                            .md-borderTop {
                                border-top: 1px solid var(--lns-color-border)
                            }

                            .md-borderBottom {
                                border-bottom: 1px solid var(--lns-color-border)
                            }

                            .md-borderLeft {
                                border-left: 1px solid var(--lns-color-border)
                            }

                            .md-borderRight {
                                border-right: 1px solid var(--lns-color-border)
                            }

                            .md-inline {
                                display: inline
                            }

                            .md-block {
                                display: block
                            }

                            .md-flex {
                                display: flex
                            }

                            .md-inlineBlock {
                                display: inline-block
                            }

                            .md-inlineFlex {
                                display: inline-flex
                            }

                            .md-none {
                                display: none
                            }

                            .md-flexWrap {
                                flex-wrap: wrap
                            }

                            .md-flexDirection\:column {
                                flex-direction: column
                            }

                            .md-flexDirection\:row {
                                flex-direction: row
                            }

                            .md-items\:stretch {
                                align-items: stretch
                            }

                            .md-items\:center {
                                align-items: center
                            }

                            .md-items\:baseline {
                                align-items: baseline
                            }

                            .md-items\:flexStart {
                                align-items: flex-start
                            }

                            .md-items\:flexEnd {
                                align-items: flex-end
                            }

                            .md-items\:selfStart {
                                align-items: self-start
                            }

                            .md-items\:selfEnd {
                                align-items: self-end
                            }

                            .md-justify\:flexStart {
                                justify-content: flex-start
                            }

                            .md-justify\:flexEnd {
                                justify-content: flex-end
                            }

                            .md-justify\:center {
                                justify-content: center
                            }

                            .md-justify\:spaceBetween {
                                justify-content: space-between
                            }

                            .md-justify\:spaceAround {
                                justify-content: space-around
                            }

                            .md-justify\:spaceEvenly {
                                justify-content: space-evenly
                            }

                            .md-grow\:0 {
                                flex-grow: 0
                            }

                            .md-grow\:1 {
                                flex-grow: 1
                            }

                            .md-shrink\:0 {
                                flex-shrink: 0
                            }

                            .md-shrink\:1 {
                                flex-shrink: 1
                            }

                            .md-self\:auto {
                                align-self: auto
                            }

                            .md-self\:flexStart {
                                align-self: flex-start
                            }

                            .md-self\:flexEnd {
                                align-self: flex-end
                            }

                            .md-self\:center {
                                align-self: center
                            }

                            .md-self\:baseline {
                                align-self: baseline
                            }

                            .md-self\:stretch {
                                align-self: stretch
                            }

                            .md-overflow\:hidden {
                                overflow: hidden
                            }

                            .md-overflow\:auto {
                                overflow: auto
                            }

                            .md-relative {
                                position: relative
                            }

                            .md-absolute {
                                position: absolute
                            }

                            .md-sticky {
                                position: sticky
                            }

                            .md-fixed {
                                position: fixed
                            }

                            .md-top\:0 {
                                top: 0
                            }

                            .md-top\:auto {
                                top: auto
                            }

                            .md-top\:xsmall {
                                top: var(--lns-space-xsmall)
                            }

                            .md-top\:small {
                                top: var(--lns-space-small)
                            }

                            .md-top\:medium {
                                top: var(--lns-space-medium)
                            }

                            .md-top\:large {
                                top: var(--lns-space-large)
                            }

                            .md-top\:xlarge {
                                top: var(--lns-space-xlarge)
                            }

                            .md-top\:xxlarge {
                                top: var(--lns-space-xxlarge)
                            }

                            .md-bottom\:0 {
                                bottom: 0
                            }

                            .md-bottom\:auto {
                                bottom: auto
                            }

                            .md-bottom\:xsmall {
                                bottom: var(--lns-space-xsmall)
                            }

                            .md-bottom\:small {
                                bottom: var(--lns-space-small)
                            }

                            .md-bottom\:medium {
                                bottom: var(--lns-space-medium)
                            }

                            .md-bottom\:large {
                                bottom: var(--lns-space-large)
                            }

                            .md-bottom\:xlarge {
                                bottom: var(--lns-space-xlarge)
                            }

                            .md-bottom\:xxlarge {
                                bottom: var(--lns-space-xxlarge)
                            }

                            .md-left\:0 {
                                left: 0
                            }

                            .md-left\:auto {
                                left: auto
                            }

                            .md-left\:xsmall {
                                left: var(--lns-space-xsmall)
                            }

                            .md-left\:small {
                                left: var(--lns-space-small)
                            }

                            .md-left\:medium {
                                left: var(--lns-space-medium)
                            }

                            .md-left\:large {
                                left: var(--lns-space-large)
                            }

                            .md-left\:xlarge {
                                left: var(--lns-space-xlarge)
                            }

                            .md-left\:xxlarge {
                                left: var(--lns-space-xxlarge)
                            }

                            .md-right\:0 {
                                right: 0
                            }

                            .md-right\:auto {
                                right: auto
                            }

                            .md-right\:xsmall {
                                right: var(--lns-space-xsmall)
                            }

                            .md-right\:small {
                                right: var(--lns-space-small)
                            }

                            .md-right\:medium {
                                right: var(--lns-space-medium)
                            }

                            .md-right\:large {
                                right: var(--lns-space-large)
                            }

                            .md-right\:xlarge {
                                right: var(--lns-space-xlarge)
                            }

                            .md-right\:xxlarge {
                                right: var(--lns-space-xxlarge)
                            }

                            .md-width\:auto {
                                width: auto
                            }

                            .md-width\:full {
                                width: 100%
                            }

                            .md-width\:0 {
                                width: 0
                            }

                            .md-minWidth\:0 {
                                min-width: 0
                            }

                            .md-height\:auto {
                                height: auto
                            }

                            .md-height\:full {
                                height: 100%
                            }

                            .md-height\:0 {
                                height: 0
                            }

                            .md-ellipsis {
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap
                            }

                            .md-srOnly {
                                position: absolute;
                                width: 1px;
                                height: 1px;
                                padding: 0;
                                margin: -1px;
                                overflow: hidden;
                                clip: rect(0, 0, 0, 0);
                                white-space: nowrap;
                                border-width: 0
                            }
                        }

                        @media(min-width:75em) {
                            .lg-c\:red {
                                color: var(--lns-color-red)
                            }

                            .lg-c\:blurpleLight {
                                color: var(--lns-color-blurpleLight)
                            }

                            .lg-c\:blurpleMedium {
                                color: var(--lns-color-blurpleMedium)
                            }

                            .lg-c\:blurple {
                                color: var(--lns-color-blurple)
                            }

                            .lg-c\:blurpleDark {
                                color: var(--lns-color-blurpleDark)
                            }

                            .lg-c\:blurpleStrong {
                                color: var(--lns-color-blurpleStrong)
                            }

                            .lg-c\:offWhite {
                                color: var(--lns-color-offWhite)
                            }

                            .lg-c\:blueLight {
                                color: var(--lns-color-blueLight)
                            }

                            .lg-c\:blue {
                                color: var(--lns-color-blue)
                            }

                            .lg-c\:blueDark {
                                color: var(--lns-color-blueDark)
                            }

                            .lg-c\:orangeLight {
                                color: var(--lns-color-orangeLight)
                            }

                            .lg-c\:orange {
                                color: var(--lns-color-orange)
                            }

                            .lg-c\:orangeDark {
                                color: var(--lns-color-orangeDark)
                            }

                            .lg-c\:tealLight {
                                color: var(--lns-color-tealLight)
                            }

                            .lg-c\:teal {
                                color: var(--lns-color-teal)
                            }

                            .lg-c\:tealDark {
                                color: var(--lns-color-tealDark)
                            }

                            .lg-c\:yellowLight {
                                color: var(--lns-color-yellowLight)
                            }

                            .lg-c\:yellow {
                                color: var(--lns-color-yellow)
                            }

                            .lg-c\:yellowDark {
                                color: var(--lns-color-yellowDark)
                            }

                            .lg-c\:grey8 {
                                color: var(--lns-color-grey8)
                            }

                            .lg-c\:grey7 {
                                color: var(--lns-color-grey7)
                            }

                            .lg-c\:grey6 {
                                color: var(--lns-color-grey6)
                            }

                            .lg-c\:grey5 {
                                color: var(--lns-color-grey5)
                            }

                            .lg-c\:grey4 {
                                color: var(--lns-color-grey4)
                            }

                            .lg-c\:grey3 {
                                color: var(--lns-color-grey3)
                            }

                            .lg-c\:grey2 {
                                color: var(--lns-color-grey2)
                            }

                            .lg-c\:grey1 {
                                color: var(--lns-color-grey1)
                            }

                            .lg-c\:white {
                                color: var(--lns-color-white)
                            }

                            .lg-c\:primary {
                                color: var(--lns-color-primary)
                            }

                            .lg-c\:primaryHover {
                                color: var(--lns-color-primaryHover)
                            }

                            .lg-c\:primaryActive {
                                color: var(--lns-color-primaryActive)
                            }

                            .lg-c\:body {
                                color: var(--lns-color-body)
                            }

                            .lg-c\:bodyDimmed {
                                color: var(--lns-color-bodyDimmed)
                            }

                            .lg-c\:background {
                                color: var(--lns-color-background)
                            }

                            .lg-c\:backgroundHover {
                                color: var(--lns-color-backgroundHover)
                            }

                            .lg-c\:backgroundActive {
                                color: var(--lns-color-backgroundActive)
                            }

                            .lg-c\:backgroundSecondary {
                                color: var(--lns-color-backgroundSecondary)
                            }

                            .lg-c\:backgroundSecondary2 {
                                color: var(--lns-color-backgroundSecondary2)
                            }

                            .lg-c\:overlay {
                                color: var(--lns-color-overlay)
                            }

                            .lg-c\:border {
                                color: var(--lns-color-border)
                            }

                            .lg-c\:focusRing {
                                color: var(--lns-color-focusRing)
                            }

                            .lg-c\:record {
                                color: var(--lns-color-record)
                            }

                            .lg-c\:recordHover {
                                color: var(--lns-color-recordHover)
                            }

                            .lg-c\:recordActive {
                                color: var(--lns-color-recordActive)
                            }

                            .lg-c\:info {
                                color: var(--lns-color-info)
                            }

                            .lg-c\:success {
                                color: var(--lns-color-success)
                            }

                            .lg-c\:warning {
                                color: var(--lns-color-warning)
                            }

                            .lg-c\:danger {
                                color: var(--lns-color-danger)
                            }

                            .lg-c\:dangerHover {
                                color: var(--lns-color-dangerHover)
                            }

                            .lg-c\:dangerActive {
                                color: var(--lns-color-dangerActive)
                            }

                            .lg-c\:backdrop {
                                color: var(--lns-color-backdrop)
                            }

                            .lg-c\:backdropDark {
                                color: var(--lns-color-backdropDark)
                            }

                            .lg-c\:backdropTwilight {
                                color: var(--lns-color-backdropTwilight)
                            }

                            .lg-c\:disabledContent {
                                color: var(--lns-color-disabledContent)
                            }

                            .lg-c\:highlight {
                                color: var(--lns-color-highlight)
                            }

                            .lg-c\:disabledBackground {
                                color: var(--lns-color-disabledBackground)
                            }

                            .lg-c\:formFieldBorder {
                                color: var(--lns-color-formFieldBorder)
                            }

                            .lg-c\:formFieldBackground {
                                color: var(--lns-color-formFieldBackground)
                            }

                            .lg-c\:buttonBorder {
                                color: var(--lns-color-buttonBorder)
                            }

                            .lg-c\:upgrade {
                                color: var(--lns-color-upgrade)
                            }

                            .lg-c\:upgradeHover {
                                color: var(--lns-color-upgradeHover)
                            }

                            .lg-c\:upgradeActive {
                                color: var(--lns-color-upgradeActive)
                            }

                            .lg-c\:tabBackground {
                                color: var(--lns-color-tabBackground)
                            }

                            .lg-c\:discoveryBackground {
                                color: var(--lns-color-discoveryBackground)
                            }

                            .lg-c\:discoveryLightBackground {
                                color: var(--lns-color-discoveryLightBackground)
                            }

                            .lg-c\:discoveryTitle {
                                color: var(--lns-color-discoveryTitle)
                            }

                            .lg-c\:discoveryHighlight {
                                color: var(--lns-color-discoveryHighlight)
                            }

                            .lg-shadow\:small {
                                box-shadow: var(--lns-shadow-small)
                            }

                            .lg-shadow\:medium {
                                box-shadow: var(--lns-shadow-medium)
                            }

                            .lg-shadow\:large {
                                box-shadow: var(--lns-shadow-large)
                            }

                            .lg-radius\:medium {
                                border-radius: var(--lns-radius-medium)
                            }

                            .lg-radius\:large {
                                border-radius: var(--lns-radius-large)
                            }

                            .lg-radius\:xlarge {
                                border-radius: var(--lns-radius-xlarge)
                            }

                            .lg-radius\:full {
                                border-radius: var(--lns-radius-full)
                            }

                            .lg-bgc\:red {
                                background-color: var(--lns-color-red)
                            }

                            .lg-bgc\:blurpleLight {
                                background-color: var(--lns-color-blurpleLight)
                            }

                            .lg-bgc\:blurpleMedium {
                                background-color: var(--lns-color-blurpleMedium)
                            }

                            .lg-bgc\:blurple {
                                background-color: var(--lns-color-blurple)
                            }

                            .lg-bgc\:blurpleDark {
                                background-color: var(--lns-color-blurpleDark)
                            }

                            .lg-bgc\:blurpleStrong {
                                background-color: var(--lns-color-blurpleStrong)
                            }

                            .lg-bgc\:offWhite {
                                background-color: var(--lns-color-offWhite)
                            }

                            .lg-bgc\:blueLight {
                                background-color: var(--lns-color-blueLight)
                            }

                            .lg-bgc\:blue {
                                background-color: var(--lns-color-blue)
                            }

                            .lg-bgc\:blueDark {
                                background-color: var(--lns-color-blueDark)
                            }

                            .lg-bgc\:orangeLight {
                                background-color: var(--lns-color-orangeLight)
                            }

                            .lg-bgc\:orange {
                                background-color: var(--lns-color-orange)
                            }

                            .lg-bgc\:orangeDark {
                                background-color: var(--lns-color-orangeDark)
                            }

                            .lg-bgc\:tealLight {
                                background-color: var(--lns-color-tealLight)
                            }

                            .lg-bgc\:teal {
                                background-color: var(--lns-color-teal)
                            }

                            .lg-bgc\:tealDark {
                                background-color: var(--lns-color-tealDark)
                            }

                            .lg-bgc\:yellowLight {
                                background-color: var(--lns-color-yellowLight)
                            }

                            .lg-bgc\:yellow {
                                background-color: var(--lns-color-yellow)
                            }

                            .lg-bgc\:yellowDark {
                                background-color: var(--lns-color-yellowDark)
                            }

                            .lg-bgc\:grey8 {
                                background-color: var(--lns-color-grey8)
                            }

                            .lg-bgc\:grey7 {
                                background-color: var(--lns-color-grey7)
                            }

                            .lg-bgc\:grey6 {
                                background-color: var(--lns-color-grey6)
                            }

                            .lg-bgc\:grey5 {
                                background-color: var(--lns-color-grey5)
                            }

                            .lg-bgc\:grey4 {
                                background-color: var(--lns-color-grey4)
                            }

                            .lg-bgc\:grey3 {
                                background-color: var(--lns-color-grey3)
                            }

                            .lg-bgc\:grey2 {
                                background-color: var(--lns-color-grey2)
                            }

                            .lg-bgc\:grey1 {
                                background-color: var(--lns-color-grey1)
                            }

                            .lg-bgc\:white {
                                background-color: var(--lns-color-white)
                            }

                            .lg-bgc\:primary {
                                background-color: var(--lns-color-primary)
                            }

                            .lg-bgc\:primaryHover {
                                background-color: var(--lns-color-primaryHover)
                            }

                            .lg-bgc\:primaryActive {
                                background-color: var(--lns-color-primaryActive)
                            }

                            .lg-bgc\:body {
                                background-color: var(--lns-color-body)
                            }

                            .lg-bgc\:bodyDimmed {
                                background-color: var(--lns-color-bodyDimmed)
                            }

                            .lg-bgc\:background {
                                background-color: var(--lns-color-background)
                            }

                            .lg-bgc\:backgroundHover {
                                background-color: var(--lns-color-backgroundHover)
                            }

                            .lg-bgc\:backgroundActive {
                                background-color: var(--lns-color-backgroundActive)
                            }

                            .lg-bgc\:backgroundSecondary {
                                background-color: var(--lns-color-backgroundSecondary)
                            }

                            .lg-bgc\:backgroundSecondary2 {
                                background-color: var(--lns-color-backgroundSecondary2)
                            }

                            .lg-bgc\:overlay {
                                background-color: var(--lns-color-overlay)
                            }

                            .lg-bgc\:border {
                                background-color: var(--lns-color-border)
                            }

                            .lg-bgc\:focusRing {
                                background-color: var(--lns-color-focusRing)
                            }

                            .lg-bgc\:record {
                                background-color: var(--lns-color-record)
                            }

                            .lg-bgc\:recordHover {
                                background-color: var(--lns-color-recordHover)
                            }

                            .lg-bgc\:recordActive {
                                background-color: var(--lns-color-recordActive)
                            }

                            .lg-bgc\:info {
                                background-color: var(--lns-color-info)
                            }

                            .lg-bgc\:success {
                                background-color: var(--lns-color-success)
                            }

                            .lg-bgc\:warning {
                                background-color: var(--lns-color-warning)
                            }

                            .lg-bgc\:danger {
                                background-color: var(--lns-color-danger)
                            }

                            .lg-bgc\:dangerHover {
                                background-color: var(--lns-color-dangerHover)
                            }

                            .lg-bgc\:dangerActive {
                                background-color: var(--lns-color-dangerActive)
                            }

                            .lg-bgc\:backdrop {
                                background-color: var(--lns-color-backdrop)
                            }

                            .lg-bgc\:backdropDark {
                                background-color: var(--lns-color-backdropDark)
                            }

                            .lg-bgc\:backdropTwilight {
                                background-color: var(--lns-color-backdropTwilight)
                            }

                            .lg-bgc\:disabledContent {
                                background-color: var(--lns-color-disabledContent)
                            }

                            .lg-bgc\:highlight {
                                background-color: var(--lns-color-highlight)
                            }

                            .lg-bgc\:disabledBackground {
                                background-color: var(--lns-color-disabledBackground)
                            }

                            .lg-bgc\:formFieldBorder {
                                background-color: var(--lns-color-formFieldBorder)
                            }

                            .lg-bgc\:formFieldBackground {
                                background-color: var(--lns-color-formFieldBackground)
                            }

                            .lg-bgc\:buttonBorder {
                                background-color: var(--lns-color-buttonBorder)
                            }

                            .lg-bgc\:upgrade {
                                background-color: var(--lns-color-upgrade)
                            }

                            .lg-bgc\:upgradeHover {
                                background-color: var(--lns-color-upgradeHover)
                            }

                            .lg-bgc\:upgradeActive {
                                background-color: var(--lns-color-upgradeActive)
                            }

                            .lg-bgc\:tabBackground {
                                background-color: var(--lns-color-tabBackground)
                            }

                            .lg-bgc\:discoveryBackground {
                                background-color: var(--lns-color-discoveryBackground)
                            }

                            .lg-bgc\:discoveryLightBackground {
                                background-color: var(--lns-color-discoveryLightBackground)
                            }

                            .lg-bgc\:discoveryTitle {
                                background-color: var(--lns-color-discoveryTitle)
                            }

                            .lg-bgc\:discoveryHighlight {
                                background-color: var(--lns-color-discoveryHighlight)
                            }

                            .lg-m\:0 {
                                margin: 0
                            }

                            .lg-m\:auto {
                                margin: auto
                            }

                            .lg-m\:xsmall {
                                margin: var(--lns-space-xsmall)
                            }

                            .lg-m\:small {
                                margin: var(--lns-space-small)
                            }

                            .lg-m\:medium {
                                margin: var(--lns-space-medium)
                            }

                            .lg-m\:large {
                                margin: var(--lns-space-large)
                            }

                            .lg-m\:xlarge {
                                margin: var(--lns-space-xlarge)
                            }

                            .lg-m\:xxlarge {
                                margin: var(--lns-space-xxlarge)
                            }

                            .lg-mt\:0 {
                                margin-top: 0
                            }

                            .lg-mt\:auto {
                                margin-top: auto
                            }

                            .lg-mt\:xsmall {
                                margin-top: var(--lns-space-xsmall)
                            }

                            .lg-mt\:small {
                                margin-top: var(--lns-space-small)
                            }

                            .lg-mt\:medium {
                                margin-top: var(--lns-space-medium)
                            }

                            .lg-mt\:large {
                                margin-top: var(--lns-space-large)
                            }

                            .lg-mt\:xlarge {
                                margin-top: var(--lns-space-xlarge)
                            }

                            .lg-mt\:xxlarge {
                                margin-top: var(--lns-space-xxlarge)
                            }

                            .lg-mb\:0 {
                                margin-bottom: 0
                            }

                            .lg-mb\:auto {
                                margin-bottom: auto
                            }

                            .lg-mb\:xsmall {
                                margin-bottom: var(--lns-space-xsmall)
                            }

                            .lg-mb\:small {
                                margin-bottom: var(--lns-space-small)
                            }

                            .lg-mb\:medium {
                                margin-bottom: var(--lns-space-medium)
                            }

                            .lg-mb\:large {
                                margin-bottom: var(--lns-space-large)
                            }

                            .lg-mb\:xlarge {
                                margin-bottom: var(--lns-space-xlarge)
                            }

                            .lg-mb\:xxlarge {
                                margin-bottom: var(--lns-space-xxlarge)
                            }

                            .lg-ml\:0 {
                                margin-left: 0
                            }

                            .lg-ml\:auto {
                                margin-left: auto
                            }

                            .lg-ml\:xsmall {
                                margin-left: var(--lns-space-xsmall)
                            }

                            .lg-ml\:small {
                                margin-left: var(--lns-space-small)
                            }

                            .lg-ml\:medium {
                                margin-left: var(--lns-space-medium)
                            }

                            .lg-ml\:large {
                                margin-left: var(--lns-space-large)
                            }

                            .lg-ml\:xlarge {
                                margin-left: var(--lns-space-xlarge)
                            }

                            .lg-ml\:xxlarge {
                                margin-left: var(--lns-space-xxlarge)
                            }

                            .lg-mr\:0 {
                                margin-right: 0
                            }

                            .lg-mr\:auto {
                                margin-right: auto
                            }

                            .lg-mr\:xsmall {
                                margin-right: var(--lns-space-xsmall)
                            }

                            .lg-mr\:small {
                                margin-right: var(--lns-space-small)
                            }

                            .lg-mr\:medium {
                                margin-right: var(--lns-space-medium)
                            }

                            .lg-mr\:large {
                                margin-right: var(--lns-space-large)
                            }

                            .lg-mr\:xlarge {
                                margin-right: var(--lns-space-xlarge)
                            }

                            .lg-mr\:xxlarge {
                                margin-right: var(--lns-space-xxlarge)
                            }

                            .lg-mx\:0 {
                                margin-left: 0;
                                margin-right: 0
                            }

                            .lg-mx\:auto {
                                margin-left: auto;
                                margin-right: auto
                            }

                            .lg-mx\:xsmall {
                                margin-left: var(--lns-space-xsmall);
                                margin-right: var(--lns-space-xsmall)
                            }

                            .lg-mx\:small {
                                margin-left: var(--lns-space-small);
                                margin-right: var(--lns-space-small)
                            }

                            .lg-mx\:medium {
                                margin-left: var(--lns-space-medium);
                                margin-right: var(--lns-space-medium)
                            }

                            .lg-mx\:large {
                                margin-left: var(--lns-space-large);
                                margin-right: var(--lns-space-large)
                            }

                            .lg-mx\:xlarge {
                                margin-left: var(--lns-space-xlarge);
                                margin-right: var(--lns-space-xlarge)
                            }

                            .lg-mx\:xxlarge {
                                margin-left: var(--lns-space-xxlarge);
                                margin-right: var(--lns-space-xxlarge)
                            }

                            .lg-my\:0 {
                                margin-top: 0;
                                margin-bottom: 0
                            }

                            .lg-my\:auto {
                                margin-top: auto;
                                margin-bottom: auto
                            }

                            .lg-my\:xsmall {
                                margin-top: var(--lns-space-xsmall);
                                margin-bottom: var(--lns-space-xsmall)
                            }

                            .lg-my\:small {
                                margin-top: var(--lns-space-small);
                                margin-bottom: var(--lns-space-small)
                            }

                            .lg-my\:medium {
                                margin-top: var(--lns-space-medium);
                                margin-bottom: var(--lns-space-medium)
                            }

                            .lg-my\:large {
                                margin-top: var(--lns-space-large);
                                margin-bottom: var(--lns-space-large)
                            }

                            .lg-my\:xlarge {
                                margin-top: var(--lns-space-xlarge);
                                margin-bottom: var(--lns-space-xlarge)
                            }

                            .lg-my\:xxlarge {
                                margin-top: var(--lns-space-xxlarge);
                                margin-bottom: var(--lns-space-xxlarge)
                            }

                            .lg-p\:0 {
                                padding: 0
                            }

                            .lg-p\:xsmall {
                                padding: var(--lns-space-xsmall)
                            }

                            .lg-p\:small {
                                padding: var(--lns-space-small)
                            }

                            .lg-p\:medium {
                                padding: var(--lns-space-medium)
                            }

                            .lg-p\:large {
                                padding: var(--lns-space-large)
                            }

                            .lg-p\:xlarge {
                                padding: var(--lns-space-xlarge)
                            }

                            .lg-p\:xxlarge {
                                padding: var(--lns-space-xxlarge)
                            }

                            .lg-pt\:0 {
                                padding-top: 0
                            }

                            .lg-pt\:xsmall {
                                padding-top: var(--lns-space-xsmall)
                            }

                            .lg-pt\:small {
                                padding-top: var(--lns-space-small)
                            }

                            .lg-pt\:medium {
                                padding-top: var(--lns-space-medium)
                            }

                            .lg-pt\:large {
                                padding-top: var(--lns-space-large)
                            }

                            .lg-pt\:xlarge {
                                padding-top: var(--lns-space-xlarge)
                            }

                            .lg-pt\:xxlarge {
                                padding-top: var(--lns-space-xxlarge)
                            }

                            .lg-pb\:0 {
                                padding-bottom: 0
                            }

                            .lg-pb\:xsmall {
                                padding-bottom: var(--lns-space-xsmall)
                            }

                            .lg-pb\:small {
                                padding-bottom: var(--lns-space-small)
                            }

                            .lg-pb\:medium {
                                padding-bottom: var(--lns-space-medium)
                            }

                            .lg-pb\:large {
                                padding-bottom: var(--lns-space-large)
                            }

                            .lg-pb\:xlarge {
                                padding-bottom: var(--lns-space-xlarge)
                            }

                            .lg-pb\:xxlarge {
                                padding-bottom: var(--lns-space-xxlarge)
                            }

                            .lg-pl\:0 {
                                padding-left: 0
                            }

                            .lg-pl\:xsmall {
                                padding-left: var(--lns-space-xsmall)
                            }

                            .lg-pl\:small {
                                padding-left: var(--lns-space-small)
                            }

                            .lg-pl\:medium {
                                padding-left: var(--lns-space-medium)
                            }

                            .lg-pl\:large {
                                padding-left: var(--lns-space-large)
                            }

                            .lg-pl\:xlarge {
                                padding-left: var(--lns-space-xlarge)
                            }

                            .lg-pl\:xxlarge {
                                padding-left: var(--lns-space-xxlarge)
                            }

                            .lg-pr\:0 {
                                padding-right: 0
                            }

                            .lg-pr\:xsmall {
                                padding-right: var(--lns-space-xsmall)
                            }

                            .lg-pr\:small {
                                padding-right: var(--lns-space-small)
                            }

                            .lg-pr\:medium {
                                padding-right: var(--lns-space-medium)
                            }

                            .lg-pr\:large {
                                padding-right: var(--lns-space-large)
                            }

                            .lg-pr\:xlarge {
                                padding-right: var(--lns-space-xlarge)
                            }

                            .lg-pr\:xxlarge {
                                padding-right: var(--lns-space-xxlarge)
                            }

                            .lg-px\:0 {
                                padding-left: 0;
                                padding-right: 0
                            }

                            .lg-px\:xsmall {
                                padding-left: var(--lns-space-xsmall);
                                padding-right: var(--lns-space-xsmall)
                            }

                            .lg-px\:small {
                                padding-left: var(--lns-space-small);
                                padding-right: var(--lns-space-small)
                            }

                            .lg-px\:medium {
                                padding-left: var(--lns-space-medium);
                                padding-right: var(--lns-space-medium)
                            }

                            .lg-px\:large {
                                padding-left: var(--lns-space-large);
                                padding-right: var(--lns-space-large)
                            }

                            .lg-px\:xlarge {
                                padding-left: var(--lns-space-xlarge);
                                padding-right: var(--lns-space-xlarge)
                            }

                            .lg-px\:xxlarge {
                                padding-left: var(--lns-space-xxlarge);
                                padding-right: var(--lns-space-xxlarge)
                            }

                            .lg-py\:0 {
                                padding-top: 0;
                                padding-bottom: 0
                            }

                            .lg-py\:xsmall {
                                padding-top: var(--lns-space-xsmall);
                                padding-bottom: var(--lns-space-xsmall)
                            }

                            .lg-py\:small {
                                padding-top: var(--lns-space-small);
                                padding-bottom: var(--lns-space-small)
                            }

                            .lg-py\:medium {
                                padding-top: var(--lns-space-medium);
                                padding-bottom: var(--lns-space-medium)
                            }

                            .lg-py\:large {
                                padding-top: var(--lns-space-large);
                                padding-bottom: var(--lns-space-large)
                            }

                            .lg-py\:xlarge {
                                padding-top: var(--lns-space-xlarge);
                                padding-bottom: var(--lns-space-xlarge)
                            }

                            .lg-py\:xxlarge {
                                padding-top: var(--lns-space-xxlarge);
                                padding-bottom: var(--lns-space-xxlarge)
                            }

                            .lg-text\:small {
                                font-size: var(--lns-fontSize-small);
                                line-height: var(--lns-lineHeight-small)
                            }

                            .lg-text\:body-sm {
                                font-size: var(--lns-fontSize-body-sm);
                                line-height: var(--lns-lineHeight-body-sm)
                            }

                            .lg-text\:medium {
                                font-size: var(--lns-fontSize-medium);
                                line-height: var(--lns-lineHeight-medium)
                            }

                            .lg-text\:body-md {
                                font-size: var(--lns-fontSize-body-md);
                                line-height: var(--lns-lineHeight-body-md)
                            }

                            .lg-text\:large {
                                font-size: var(--lns-fontSize-large);
                                line-height: var(--lns-lineHeight-large)
                            }

                            .lg-text\:body-lg {
                                font-size: var(--lns-fontSize-body-lg);
                                line-height: var(--lns-lineHeight-body-lg)
                            }

                            .lg-text\:xlarge {
                                font-size: var(--lns-fontSize-xlarge);
                                line-height: var(--lns-lineHeight-xlarge)
                            }

                            .lg-text\:heading-sm {
                                font-size: var(--lns-fontSize-heading-sm);
                                line-height: var(--lns-lineHeight-heading-sm)
                            }

                            .lg-text\:xxlarge {
                                font-size: var(--lns-fontSize-xxlarge);
                                line-height: var(--lns-lineHeight-xxlarge)
                            }

                            .lg-text\:heading-md {
                                font-size: var(--lns-fontSize-heading-md);
                                line-height: var(--lns-lineHeight-heading-md)
                            }

                            .lg-text\:xxxlarge {
                                font-size: var(--lns-fontSize-xxxlarge);
                                line-height: var(--lns-lineHeight-xxxlarge)
                            }

                            .lg-text\:heading-lg {
                                font-size: var(--lns-fontSize-heading-lg);
                                line-height: var(--lns-lineHeight-heading-lg)
                            }

                            .lg-weight\:book {
                                font-weight: var(--lns-fontWeight-book)
                            }

                            .lg-weight\:bold {
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .lg-text\:body {
                                font-size: var(--lns-fontSize-body-md);
                                line-height: var(--lns-lineHeight-body-md);
                                font-weight: var(--lns-fontWeight-book)
                            }

                            .lg-text\:title {
                                font-size: var(--lns-fontSize-body-lg);
                                line-height: var(--lns-lineHeight-body-lg);
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .lg-text\:mainTitle {
                                font-size: var(--lns-fontSize-heading-md);
                                line-height: var(--lns-lineHeight-heading-md);
                                font-weight: var(--lns-fontWeight-bold)
                            }

                            .lg-text\:left {
                                text-align: left
                            }

                            .lg-text\:right {
                                text-align: right
                            }

                            .lg-text\:center {
                                text-align: center
                            }

                            .lg-border {
                                border: 1px solid var(--lns-color-border)
                            }

                            .lg-borderTop {
                                border-top: 1px solid var(--lns-color-border)
                            }

                            .lg-borderBottom {
                                border-bottom: 1px solid var(--lns-color-border)
                            }

                            .lg-borderLeft {
                                border-left: 1px solid var(--lns-color-border)
                            }

                            .lg-borderRight {
                                border-right: 1px solid var(--lns-color-border)
                            }

                            .lg-inline {
                                display: inline
                            }

                            .lg-block {
                                display: block
                            }

                            .lg-flex {
                                display: flex
                            }

                            .lg-inlineBlock {
                                display: inline-block
                            }

                            .lg-inlineFlex {
                                display: inline-flex
                            }

                            .lg-none {
                                display: none
                            }

                            .lg-flexWrap {
                                flex-wrap: wrap
                            }

                            .lg-flexDirection\:column {
                                flex-direction: column
                            }

                            .lg-flexDirection\:row {
                                flex-direction: row
                            }

                            .lg-items\:stretch {
                                align-items: stretch
                            }

                            .lg-items\:center {
                                align-items: center
                            }

                            .lg-items\:baseline {
                                align-items: baseline
                            }

                            .lg-items\:flexStart {
                                align-items: flex-start
                            }

                            .lg-items\:flexEnd {
                                align-items: flex-end
                            }

                            .lg-items\:selfStart {
                                align-items: self-start
                            }

                            .lg-items\:selfEnd {
                                align-items: self-end
                            }

                            .lg-justify\:flexStart {
                                justify-content: flex-start
                            }

                            .lg-justify\:flexEnd {
                                justify-content: flex-end
                            }

                            .lg-justify\:center {
                                justify-content: center
                            }

                            .lg-justify\:spaceBetween {
                                justify-content: space-between
                            }

                            .lg-justify\:spaceAround {
                                justify-content: space-around
                            }

                            .lg-justify\:spaceEvenly {
                                justify-content: space-evenly
                            }

                            .lg-grow\:0 {
                                flex-grow: 0
                            }

                            .lg-grow\:1 {
                                flex-grow: 1
                            }

                            .lg-shrink\:0 {
                                flex-shrink: 0
                            }

                            .lg-shrink\:1 {
                                flex-shrink: 1
                            }

                            .lg-self\:auto {
                                align-self: auto
                            }

                            .lg-self\:flexStart {
                                align-self: flex-start
                            }

                            .lg-self\:flexEnd {
                                align-self: flex-end
                            }

                            .lg-self\:center {
                                align-self: center
                            }

                            .lg-self\:baseline {
                                align-self: baseline
                            }

                            .lg-self\:stretch {
                                align-self: stretch
                            }

                            .lg-overflow\:hidden {
                                overflow: hidden
                            }

                            .lg-overflow\:auto {
                                overflow: auto
                            }

                            .lg-relative {
                                position: relative
                            }

                            .lg-absolute {
                                position: absolute
                            }

                            .lg-sticky {
                                position: sticky
                            }

                            .lg-fixed {
                                position: fixed
                            }

                            .lg-top\:0 {
                                top: 0
                            }

                            .lg-top\:auto {
                                top: auto
                            }

                            .lg-top\:xsmall {
                                top: var(--lns-space-xsmall)
                            }

                            .lg-top\:small {
                                top: var(--lns-space-small)
                            }

                            .lg-top\:medium {
                                top: var(--lns-space-medium)
                            }

                            .lg-top\:large {
                                top: var(--lns-space-large)
                            }

                            .lg-top\:xlarge {
                                top: var(--lns-space-xlarge)
                            }

                            .lg-top\:xxlarge {
                                top: var(--lns-space-xxlarge)
                            }

                            .lg-bottom\:0 {
                                bottom: 0
                            }

                            .lg-bottom\:auto {
                                bottom: auto
                            }

                            .lg-bottom\:xsmall {
                                bottom: var(--lns-space-xsmall)
                            }

                            .lg-bottom\:small {
                                bottom: var(--lns-space-small)
                            }

                            .lg-bottom\:medium {
                                bottom: var(--lns-space-medium)
                            }

                            .lg-bottom\:large {
                                bottom: var(--lns-space-large)
                            }

                            .lg-bottom\:xlarge {
                                bottom: var(--lns-space-xlarge)
                            }

                            .lg-bottom\:xxlarge {
                                bottom: var(--lns-space-xxlarge)
                            }

                            .lg-left\:0 {
                                left: 0
                            }

                            .lg-left\:auto {
                                left: auto
                            }

                            .lg-left\:xsmall {
                                left: var(--lns-space-xsmall)
                            }

                            .lg-left\:small {
                                left: var(--lns-space-small)
                            }

                            .lg-left\:medium {
                                left: var(--lns-space-medium)
                            }

                            .lg-left\:large {
                                left: var(--lns-space-large)
                            }

                            .lg-left\:xlarge {
                                left: var(--lns-space-xlarge)
                            }

                            .lg-left\:xxlarge {
                                left: var(--lns-space-xxlarge)
                            }

                            .lg-right\:0 {
                                right: 0
                            }

                            .lg-right\:auto {
                                right: auto
                            }

                            .lg-right\:xsmall {
                                right: var(--lns-space-xsmall)
                            }

                            .lg-right\:small {
                                right: var(--lns-space-small)
                            }

                            .lg-right\:medium {
                                right: var(--lns-space-medium)
                            }

                            .lg-right\:large {
                                right: var(--lns-space-large)
                            }

                            .lg-right\:xlarge {
                                right: var(--lns-space-xlarge)
                            }

                            .lg-right\:xxlarge {
                                right: var(--lns-space-xxlarge)
                            }

                            .lg-width\:auto {
                                width: auto
                            }

                            .lg-width\:full {
                                width: 100%
                            }

                            .lg-width\:0 {
                                width: 0
                            }

                            .lg-minWidth\:0 {
                                min-width: 0
                            }

                            .lg-height\:auto {
                                height: auto
                            }

                            .lg-height\:full {
                                height: 100%
                            }

                            .lg-height\:0 {
                                height: 0
                            }

                            .lg-ellipsis {
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap
                            }

                            .lg-srOnly {
                                position: absolute;
                                width: 1px;
                                height: 1px;
                                padding: 0;
                                margin: -1px;
                                overflow: hidden;
                                clip: rect(0, 0, 0, 0);
                                white-space: nowrap;
                                border-width: 0
                            }
                        }

                        #inner-shadow-companion {
                            --lns-unit: 8px;
                            all: initial;
                            font-family: circular, Helvetica, sans-serif;
                            color: var(--lns-color-body);
                        }

                        #tooltip-mount-layer-companion {
                            z-index: 2147483646;
                            position: relative;

                            color: var(--lns-color-body);
                            pointer-events: auto;
                        }
                    </style>
                    <div class="companion-1b6rwsq"></div>
                </div>
            </template></section>
    </div><deepl-input-controller><template shadowrootmode="open">
            <link rel="stylesheet" href="chrome-extension://cofdbpoegempjloogbagkncekinflcnj/build/content.css">
            <div dir="ltr" style="visibility: initial !important;">
                <div class="dl-input-translation-container svelte-95aucy">
                    <div></div>
                </div>
            </div>
        </template></deepl-input-controller>
    <div id="veepn-breach-alert"><template shadowrootmode="open">
            <style>
                .breach-popup {
                    font-family: FigtreeVF, sans-serif;
                    position: fixed;
                    z-index: 2147483638;
                    text-rendering: optimizelegibility;
                    top: 0;
                    left: 0;
                    right: 0;
                    pointer-events: none;
                    padding-inline: 16px;
                    height: 0;
                    overflow: visible;
                    color: #222e3a
                }

                .breach-popup * {
                    box-sizing: border-box
                }

                .breach-popup__inner {
                    background-color: #de4558;
                    width: 100%;
                    border-radius: 16px;
                    margin-inline: auto;
                    pointer-events: all;
                    position: relative;
                    transition: transform .25s ease-in-out, max-width .25s ease-in-out;
                    transform: translateY(16px);
                    max-height: calc(100svh - 80px);
                    display: flex;
                    flex-direction: column
                }

                .breach-popup__header {
                    min-height: 32px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    column-gap: 16px;
                    padding: 4px;
                    cursor: pointer
                }

                .breach-popup__close {
                    cursor: pointer;
                    background-color: transparent;
                    border-style: none;
                    outline: none;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 24px;
                    height: 24px;
                    flex-shrink: 0;
                    opacity: .5
                }

                .breach-popup__wrap {
                    display: grid;
                    grid-template-rows: 0fr;
                    transition: grid-template-rows .25s ease-in-out;
                    overflow: hidden
                }

                .breach-popup__content {
                    overflow: hidden;
                    opacity: 0;
                    transform: translateY(-10px)
                }

                .breach-popup--minimize .breach-popup__inner {
                    max-width: 485px;
                    transform: translateY(-100%)
                }

                .breach-popup--collapse .breach-popup__inner {
                    max-width: 485px
                }

                .breach-popup--expand .breach-popup__inner {
                    max-width: 1120px
                }

                .breach-popup--expand .breach-popup__wrap {
                    grid-template-rows: 1fr
                }

                .breach-popup--expand .breach-popup__content {
                    opacity: 1;
                    transform: translateY(0);
                    transition: transform .25s ease-in-out, opacity .25s ease-in-out;
                    transition-delay: .15s
                }

                .breach-popup--expand .breach-popup__header {
                    cursor: default
                }

                .breach-info {
                    padding: 2px;
                    height: 100%
                }

                .breach-info__inner {
                    padding: 22px 22px 0;
                    background-color: #fff;
                    border-bottom-left-radius: 15px;
                    border-bottom-right-radius: 15px;
                    height: 100%;
                    overflow: auto
                }

                .breach-info__alert {
                    font-size: 24px;
                    line-height: 32px;
                    font-weight: 700;
                    margin: 0
                }

                .breach-info__list {
                    margin-top: 24px;
                    display: flex;
                    flex-wrap: wrap;
                    gap: 24px
                }

                @media only screen and (width >=992px) {
                    .breach-info__list {
                        flex-wrap: nowrap
                    }
                }

                .breach-info__item {
                    width: 100%
                }

                .breach-info__item:nth-child(2) {
                    max-width: 320px
                }

                .breach-info__item:nth-child(3) {
                    max-width: 200px
                }

                .breach-info__title {
                    font-size: 18px;
                    font-weight: 700;
                    line-height: 32px;
                    letter-spacing: -.1px;
                    color: #de4558;
                    margin-top: 0;
                    margin-bottom: 4px
                }

                .breach-info__description {
                    font-size: 16px;
                    line-height: 28px;
                    letter-spacing: -.1px
                }

                .breach-info__description ul {
                    margin: 0
                }

                .breach-info__actions {
                    display: flex;
                    justify-content: center;
                    padding-top: 32px;
                    padding-bottom: 22px;
                    background-color: #fff;
                    position: sticky;
                    bottom: 0
                }

                .breach-info__btn {
                    cursor: pointer;
                    border-style: none;
                    outline: none;
                    display: inline-flex;
                    align-items: center;
                    height: 48px;
                    padding-inline: 20px;
                    border-radius: 12px;
                    text-align: center;
                    font-size: 16px;
                    font-weight: 700;
                    line-height: 28px;
                    letter-spacing: -.1px;
                    color: #fff;
                    background-color: #ff6400
                }

                .button-expand {
                    position: absolute;
                    bottom: 0;
                    left: 50%;
                    transform: translate(-50%, 100%);
                    z-index: 1
                }

                .button-expand__pointer {
                    cursor: pointer
                }

                .button-expand__alert {
                    pointer-events: none;
                    transition: opacity .25s ease-in-out
                }

                .button-expand__arrow {
                    pointer-events: none;
                    transition: transform .25s ease-in-out, opacity .25s ease-in-out;
                    transform-origin: center
                }

                .button-expand--minimize .button-expand__arrow,
                .button-expand--collapse .button-expand__alert,
                .button-expand--expand .button-expand__alert {
                    opacity: 0
                }

                .button-expand--expand .button-expand__arrow {
                    transform: rotate(180deg)
                }

                .header-collapse {
                    display: flex;
                    align-items: center;
                    flex-wrap: wrap;
                    column-gap: 4px;
                    padding-left: 8px;
                    font-size: 14px;
                    line-height: 20px;
                    letter-spacing: -.1px;
                    color: #fff
                }

                .header-expand {
                    display: flex;
                    align-items: center;
                    flex-wrap: wrap;
                    column-gap: 4px;
                    padding-left: 20px;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 20px;
                    letter-spacing: -.1px;
                    color: #fff
                }
            </style>
        </template></div>
    <style>
        @font-face {
            font-family: FigtreeVF;
            src: url(chrome-extension://majdfhpaihoncoakbjgbdhglocklcgno/fonts/FigtreeVF.woff2) format("woff2 supports variations"), url(chrome-extension://majdfhpaihoncoakbjgbdhglocklcgno/fonts/FigtreeVF.woff2) format("woff2-variations");
            font-weight: 100 1000;
            font-display: swap
        }
    </style>
    <div style="position: relative;" id="zp-9-1-1-apollo-root-apollo_everywhere"></div>
</body>

</html>

