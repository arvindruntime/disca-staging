<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <style>
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
        }

        a {
            text-decoration: none;
            color: #000;
        }

        table {
            border: 0px;
            border-spacing: 0;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            cellpadding: 0;
            cellspacing: 0;
            table-layout: fixed;
            max-width: 800px;
        }

        td {
            margin: 0;
            padding: 0;
            max-width: 800px;
        }

        p {
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
    <center class="center" style="width: 100%; background: rgba(0, 0, 0, 0.1); min-height: 100vh;">
        <table>
            <tr>
                <td style="padding: 0 15px;">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"
                        class="email-container"
                        style="margin: 0; padding: 0; width: 100%;max-width: 650px; background-color: #fff;">
                        <tr style="padding: 20px; background-color: #f3f3f3;">
                            <td style="text-align: center; padding: 20px;">
                                <img src="{{ asset('images/Logo.svg') }}" alt="security-quate-bg" width="200" height="100"
                                    style="height: auto; vertical-align: middle;">
                            </td>
                        </tr>

                        <tr>
                            <td width="100%" style="padding: 20px;">
                                {{ $mail_details['body'] }}
                            </td>
                        </tr>

                        <tr>
                            <td align="center" style="padding: 20px; background-color: #f3f3f3;">
                                <table cellpadding="0" cellspacing="0" border="0" align="center"
                                    class="email-container" style="margin: 0; padding: 0; width: 100%;">
                                    <tr>
                                        <td align="center" style="padding-bottom: 20px;">
                                            <p>
                                                <a href="http://www.facebook.com/"
                                                    style="text-decoration: none; padding-right: 15px;">
                                                    <img src="{{ asset('images/facebook.png') }}" alt="facebook" width="40px"
                                                        height="40px">
                                                </a>
                                                <a href="http://www.twitter.com/"
                                                    style="text-decoration: none; padding-right: 15px;">
                                                    <img src="{{ asset('images/twitter.png') }}" alt="twitter" width="40px"
                                                        height="40px">
                                                </a>
                                                <a href="http://www.linkedin.com/" style="text-decoration: none;">
                                                    <img src="{{ asset('images/linkedin.png') }}" alt="linkedin" width="40px"
                                                        height="40px">
                                                </a>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center"
                                            style="border-bottom: 1px solid #dbdbdb; padding-bottom: 15px;">
                                            <p style="margin: 0;">
                                                <a href="http://www.google.com"
                                                    style="color: #58595b; padding-right: 10px;">Privacy Policy</a>
                                                <a href="http://www.google.com"
                                                    style="color: #58595b; padding-right: 10px">Cookie Policy</a>
                                                <a href="http://www.google.com" style="color: #58595b;">Terms and
                                                    Condition</a>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding-top: 15px;">
                                            <p style="margin: 0; font-size: 12px;">
                                                © <?php echo date("Y"); ?> Infra 360 Digital Infrastructure for Social Care. All Rights
                                                Reserved. – Designed by Peak Online
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>

</html>
