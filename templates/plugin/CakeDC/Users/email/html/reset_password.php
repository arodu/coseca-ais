<?php

/**
 * Copyright 2024 ACGAMES - anthonyzok521@gmail.com
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * 
 * Template html for the email reset password
 * 
 */

?>

<table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" width="100%">
    <tbody>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" width="100%">
                    <tbody>
                        <tr style="background-color: #cfd6f4;">
                            <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" width="600">
                                    <tbody>
                                        <tr>
                                            <td class="column column-1" width="100%">
                                                <table border="0" cellpadding="0" cellspacing="0" class="image_block block-1" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad" style="width: 100%">
                                                            <div align="center" class="alignment">
                                                                <div style="max-width: 600px">
                                                                    <img alt="Card Header with Border and Shadow Animated" height="auto" src="https://i.imgur.com/zH3iIwZ.png" title="Card Header with Border and Shadow Animated" width="600" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" style="background-position: top center;
        background-repeat: repeat;
        background-image: url('https://i.imgur.com/etoKaho.png');" role="presentation" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" width="600">
                                    <tbody>
                                        <tr>
                                            <td class="column column-1" style="
                        padding-bottom: 15px;
                        padding-left: 50px;
                        padding-right: 50px;
                        padding-top: 15px;" width="100%">
                                                <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-1" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div>
                                                                <p>
                                                                    <strong><span>Restablecer contraseña</span></strong>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-2" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div style="
                                color: #40507a;
                                font-size: 16px;
                                mso-line-height-alt: 19.2px;
                            ">
                                                                <p>
                                                                    <span>¡Hola <?= __d('cake_d_c/users', "{0}", isset($first_name) ? $first_name : '') ?>!</span> Hemos recibido
                                                                    una solicitud para restablecer tu
                                                                    contraseña.
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-3" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div style="
                                color: #40507a;
                                font-size: 16px;
                                mso-line-height-alt: 19.2px;">
                                                                <p>
                                                                    <span>Haz click en el botón.</span>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellpadding="0" cellspacing="0" class="button_block block-4" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad" style="
                            padding-bottom: 20px;
                            padding-left: 10px;
                            padding-right: 10px;
                            padding-top: 20px;
                            text-align: left;
                            ">
                                                            <div align="left" class="alignment" style="text-align: -webkit-center;">
                                                                <a href="<?= $this->Url->build($activationUrl) ?>" target="_blank"><span><span><span data-mce-><strong>RESTABLECER CONTRASEÑA</strong></span></span></span></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-5" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div style="
                                color: #40507a;
                                font-size: 14px;
                                mso-line-height-alt: 16.8px;">
                                                                <p>
                                                                    <span>¿Tienes problemas?
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-6" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div style="
                                color: #40507a;
                                font-size: 14px;
                                mso-line-height-alt: 16.8px;">
                                                                <p style="margin: 0">
                                                                    Si no puedes hacer click en el botón,
                                                                    copia y pega el siguiente enlace en un
                                                                    navegador: <?= $this->Url->build($activationUrl) ?>
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" width="600">
                                    <tbody>
                                        <tr>
                                            <td class="column column-1" style="
                        padding-bottom: 5px;
                    " width="100%">
                                                <table border="0" cellpadding="0" cellspacing="0" class="image_block block-1" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad" style="width: 100%">
                                                            <div align="center" class="alignment" style="line-height: 10px">
                                                                <div style="max-width: 600px">
                                                                    <img alt="Card Bottom with Border and Shadow Image" height="auto" src="https://i.imgur.com/1vrhMWO.png" title="Card Bottom with Border and Shadow Image" width="600" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" width="600">
                                    <tbody>
                                        <tr>
                                            <td class="column column-1" style="
                        padding-bottom: 20px;
                        padding-left: 10px;
                        padding-right: 10px;
                        padding-top: 10px;
                    " width="100%">
                                                <table border="0" cellpadding="10" cellspacing="0" class="image_block block-1" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div align="center" class="alignment" style="line-height: 10px;">
                                                                <div style="max-width: 145px;">
                                                                    <img alt="UNERG" height="auto" src="https://i.imgur.com/7RFp3ws.png" title="UNERG" width="145" style="margin: auto;"/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-2" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div style="
                                color: #97a2da;
                                font-size: 14px;
                                text-align: center;
                                mso-line-height-alt: 16.8px;
                            ">
                                                                <p>
                                                                    --------------------------------------
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-3" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div style="
                                color: #97a2da;     font-size: 14px;
                                text-align: center;
                                mso-line-height-alt: 16.8px;
                            ">
                                                                <p>
                                                                    No responder este correo
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table border="0" cellpadding="10" cellspacing="0" class="paragraph_block block-4" role="presentation" width="100%">
                                                    <tr>
                                                        <td class="pad">
                                                            <div style="
                                color: #97a2da;
                                font-size: 12px;
                                line-height: 120%;
                                text-align: center;
                                mso-line-height-alt: 14.399999999999999px;
                            ">
                                                                <p>
                                                                    <span>Copyright© 2024 COSECA AIS</span>
                                                                </p>
                                                                <p style="margin: 0; word-break: break-word">
                                                                     
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" width="600">
                                    <tbody>
                                        <tr>
                                            <td class="column column-1" style="
                        padding-bottom: 5px;
                        padding-top: 5px;
                    " width="100%">
                                                <table border="0" cellpadding="0" cellspacing="0" class="icons_block block-1" role="presentation" style="
                        text-align: center;
                        " width="100%">
                                                    <tr>
                                                        <td class="pad" style="
                            vertical-align: middle;
                            color: #1e0e4b;
                            font-family: 'Inter', sans-serif;
                            font-size: 15px;
                            padding-bottom: 5px;
                            padding-top: 5px;
                            text-align: center;
                            ">
                                                            <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                                                                <tr>
                                                                    <td class="alignment" style="
                                    vertical-align: middle;
                                    text-align: center;
                                ">
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>