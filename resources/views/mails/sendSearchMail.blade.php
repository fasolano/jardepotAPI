<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }

        /* RESET STYLES */
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MEDIA QUERIES */
        @media screen and (max-width: 480px) {
            .mobile-hide {
                display: none !important;
            }
            .mobile-center {
                text-align: center !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] { margin: 0 !important; }
    </style>
<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">


<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                <tr>
                    <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#969696">
                        <!--[if (gte mso 9)|(IE)]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                            <tr>
                                <td align="left" valign="top" width="300">
                        <![endif]-->
                        <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                <tr>
                                    <td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 36px; font-weight: 800; line-height: 48px;" class="mobile-center">

                                            @if ($tipo == 'busqueda')
                                            <h1 style="font-size: 36px; font-weight: 800; margin: 0; color: #ffffff;">Notificación de Busqueda</h1>
                                            @elseif($tipo == 'duda')
                                            <h1 style="font-size: 36px; font-weight: 800; margin: 0; color: #ffffff;">Notificación de Duda o Comentario</h1>
                                            @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        <td align="right" width="300">
                        <![endif]-->
                        <div style="display:inline-block; max-width:50%; min-width:100px; vertical-align:top; width:100%;" class="mobile-hide">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
                                <tr>
                                    <td align="right" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;">
                                        <table cellspacing="0" cellpadding="0" border="0" align="right">
                                            <tr>
                                                <td style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 24px;">
                                                    <a href="https://www.jardepot.com" target="_blank" style="color: #ffffff; text-decoration: none;"><img src="https://www.jardepot.com/images/logo2.png" width="200" height="23" style="display: block; border: 0px;"/></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 35px; background-color: #ffffff;" bgcolor="#ffffff">
                        <!--[if (gte mso 9)|(IE)]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                            <tr>
                                <td align="center" valign="top" width="600">
                        <![endif]-->
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">

                            <tr>
                                <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">
                                    <p style=" font-weight: 800; line-height: 25px; color: #333333; margin: 0;">
                                        @if ($tipo == 'busqueda')
                                            Un cliente ha realizado la siguiente busqueda: {{$busqueda}}.
                                        @elseif($tipo == 'duda')
                                            Un cliente tiene una duda o comentario sobre este producto: {{$producto}}.
                                        @endif
                                        Ponte en contacto con él, dejó los siguientes datos.
                                    </p>

                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">
                                    <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                                        Datos del cliente
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">
                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td width="40%">
                                                <p style="font-size: 16px; font-weight: 800; line-height: 24px; color: #777777;">
                                                    Nombre:
                                                </p>

                                            </td>
                                            <td>
                                                <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
                                                    {{$nombre}}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">
                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td width="40%">
                                                <p style="font-size: 16px; font-weight: 800; line-height: 24px; color: #777777;">
                                                    Telefono:
                                                </p>

                                            </td>
                                            <td>
                                                <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
                                                    {{$telefono}}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @if ($tipo == 'duda')
                                <tr>
                                    <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">
                                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td width="40%">
                                                    <p style="font-size: 16px; font-weight: 800; line-height: 24px; color: #777777;">
                                                        Whatsapp:
                                                    </p>

                                                </td>
                                                <td>
                                                    <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
                                                        {{$whatsapp}}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">
                                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td width="40%">
                                                    <p style="font-size: 16px; font-weight: 800; line-height: 24px; color: #777777;">
                                                        Email:
                                                    </p>

                                                </td>
                                                <td>
                                                    <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
                                                        {{$email}}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">
                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td width="40%">
                                                <p style="font-size: 16px; font-weight: 800; line-height: 24px; color: #777777;">
                                                    Comentarios:
                                                </p>

                                            </td>
                                            <td>
                                                <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
                                                     {{$comentario}}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>

</body>
</html>
