<style>
    body {
        padding: 0;
        margin: 0;
    }

    html { -webkit-text-size-adjust:none; -ms-text-size-adjust: none;}
    @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
        *[class="table_width_100"] {
            width: 96% !important;
        }
        *[class="border-right_mob"] {
            border-right: 1px solid #dddddd;
        }
        *[class="mob_100"] {
            width: 100% !important;
        }
        *[class="mob_center"] {
            text-align: center !important;
        }
        *[class="mob_center_bl"] {
            float: none !important;
            display: block !important;
            margin: 0px auto;
        }
        .iage_footer a {
            text-decoration: none;
            color: #929ca8;
        }
        img.mob_display_none {
            width: 0px !important;
            height: 0px !important;
            display: none !important;
        }
        img.mob_width_50 {
            width: 40% !important;
            height: auto !important;
        }
    }
    .table_width_100 {
        width: 680px;
    }
</style>



<div id="mailsub" class="notification" align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;"><tr><td align="center" bgcolor="#eff3f8">



                <!-- padding -->
            </td></tr>
        <!--header -->
        <tr><td align="center" bgcolor="#ffffff">
                <!-- padding -->
                <table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr><td align="center">
                            <a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; float:left; width:100%; padding:20px;text-align:center; font-size: 13px;">
                                <font face="Arial, Helvetica, sans-seri; font-size: 13px;" size="3" color="#596167">


                        </td>
                    </tr>
                </table>

            </td></tr>
        <!--header END-->

        <!--content 1 -->
        <tr><td align="center" bgcolor="#fbfcfd">
                <font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;">
                    <table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>

                                Superuser Email:-{{$email??''}}<br/>
                                Superuser password:-{{$password??''}}
                                Subject:- Otp Verification<br/>
                                Code:- The Otp verification code is {{$otp}} <br/>
                                <br/>
                                <br/>
                                <br/>
                                <br/>

                                <br/>
                                <br/>
                                <br/>
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <div style="line-height: 24px;">
                                    Otp Mail
                                </div>
                                <!-- padding --><div style="height: 60px; line-height: 60px; font-size: 10px;"></div>
                            </td>
                        </tr>

                    </table>
                </font>
            </td></tr>
        <!--content 1 END-->



        <!--footer -->
        <tr><td class="iage_footer" align="center" bgcolor="#ffffff">



            </td></tr>
        <!--footer END-->
        <tr><td>

            </td></tr>
    </table>
    <!--[if gte mso 10]>

