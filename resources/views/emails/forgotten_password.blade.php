<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],
        /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img+div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u~div .email-container {
                min-width: 320px !important;
            }
        }

        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u~div .email-container {
                min-width: 375px !important;
            }
        }

        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u~div .email-container {
                min-width: 414px !important;
            }
        }

    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>
        .primary {
            background: #17bebb;
        }

        .bg_white {
            background: #ffffff;
        }

        .bg_light {
            background: #e2e5e5;
            /* background: #f7fafa; */
        }

        .bg_black {
            background: #000000;
        }

        .bg_dark {
            background: rgba(0, 0, 0, .8);
        }

        .email-section {
            padding: 2.5em;
        }

        /*BUTTON*/
        .btn {
            padding: 10px 15px;
            display: inline-block;
        }

        .btn.btn-primary {
            border-radius: 5px;
            background: #17bebb;
            color: #ffffff;
        }

        .btn.btn-white {
            border-radius: 5px;
            background: #ffffff;
            color: #000000;
        }

        .btn.btn-white-outline {
            border-radius: 5px;
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        .btn.btn-black-outline {
            border-radius: 0px;
            background: transparent;
            border: 2px solid #000;
            color: #000;
            font-weight: 700;
        }

        .btn-custom {
            color: rgba(0, 0, 0, .3);
            text-decoration: underline;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            color: #000000;
            margin-top: 0;
            font-weight: 400;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0, 0, 0, .4);
        }

        a {
            color: #17bebb;
        }

        table {}

        /*LOGO*/

        .logo h1 {
            margin: 0;
        }

        .logo h1 a {
            color: #17bebb;
            font-size: 24px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }

        /*HERO*/
        .hero {
            position: relative;
            z-index: 0;
        }

        .hero .text {
            color: rgba(0, 0, 0, .3);
        }

        .hero .text h2 {
            color: #000;
            font-size: 34px;
            margin-bottom: 0;
            font-weight: 200;
            line-height: 1.4;
        }

        .hero .text h3 {
            font-size: 24px;
            font-weight: 300;
        }

        .hero .text h2 span {
            font-weight: 600;
            color: #000;
        }

        .text-author {
            bordeR: 1px solid rgba(0, 0, 0, .05);
            max-width: 50%;
            margin: 0 auto;
            padding: 1em;
        }

        .text-author img {
            border-radius: 50%;
            padding-bottom: 20px;
        }

        .text-author h3 {
            margin-bottom: 0;
        }

        ul.social {
            padding: 0;
        }

        ul.social li {
            display: inline-block;
            margin-right: 10px;
        }

        /*FOOTER*/

        .footer {
            border-top: 1px solid rgba(0, 0, 0, .05);
            color: rgba(0, 0, 0, .5);
        }

        .footer .heading {
            color: #000;
            color: #c40000;
            border-bottom: 1px solid #c40000;
            /* text-decoration: underline; */
            font-size: 16px;
        }

        .footer ul {
            margin: 0;
            padding: 0;
        }

        .footer ul li {
            list-style: none;
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: rgba(0, 0, 0, 1);
        }


        @media screen and (max-width: 500px) {}

    </style>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
    <center style="width: 100%; background-color: #f1f1f1; ">
        <div
            style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
        </div>
        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
            <!-- BEGIN BODY -->
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                style="margin: auto;">
              
                <!-- end tr -->

                <tr>
                    <td valign="middle" class="hero bg_white"
                        style="padding: 2em 0 4em 0; padding-bottom: 0; margin-top: 8px;">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="padding: 0 2.5em; text-align: center; padding-bottom: 3em;">
                                    <div class="text">
                                        <div class="d-flex justify-content-center">
                                            {{-- <span><img src="{{asset('css/icon.jpeg')}}" style="width: 100px; height: 60px;"> --}}
                                            <h2>SmartUniversity</h2></span>
                                        </div>
                                        <hr style="background-color:red;">
                                        <br>
                                        <h3><u> Reset Password</u></h3>
                                        <br>
                                        <div class="card">
                                            <div class="card-body shadow-sm">
                                                <h6 class="px-3" style="text-align: justify">
                                                    Hi <b>, {{$receipt['school']}}</b>
                                                    <br>
                                                    <br>
                                                    Your password was successfully changed. Do not share your credentials with anyone
                                                    <br>        
                                                    <br>
                                                    <b>New Password : </b> {{$receipt['password']}} 
                                                    <br>
                                                    <br>
                                                    <span>Please <a href="https://gitplussandbox.com/smartuniversity">click here</a> to Login</span>
                                                    <br>
                                                    <span class="font-weight-bold">Thank You.</span>
                                                </h6>

                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>

        </div>
    </center>
</body>

</html>
