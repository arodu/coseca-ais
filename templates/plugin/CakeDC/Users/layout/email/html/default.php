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
 * This file handler styles of templates/plugin/CakeDC/Users/email/html/reset_password.php
 * 
 * */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>
    <style>
          * {
        box-sizing: border-box;
      }

      body {
        margin: 0;
        padding: 0;
		background-color: #d9dffa;
		margin: 0;
		padding: 0;
		-webkit-text-size-adjust: none;
		text-size-adjust: none;
      }

      table{
		    mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
	  }
    
    table img{
      display: block;
      height: auto;
      border: 0;
      width: 100%;
    }
      a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: inherit !important;
      }

      #MessageViewBody a {
        color: inherit;
        text-decoration: none;
      }

      p {
        line-height: inherit;
      }

      .desktop_hide,
      .desktop_hide table {
        mso-hide: all;
        display: none;
        max-height: 0px;
        overflow: hidden;
      }

      .image_block img + div {
        display: none;
      }

      @media (max-width: 620px) {
        .desktop_hide table.icons-inner {
          display: inline-block !important;
        }

        .icons-inner {
          text-align: center;
        }

        .icons-inner td {
          margin: 0 auto;
        }

        .mobile_hide {
          display: none;
        }

        .row-content {
          width: 100% !important;
        }

        .stack .column {
          width: 100%;
          display: block;
        }

        .mobile_hide {
          min-height: 0;
          max-height: 0;
          max-width: 0;
          overflow: hidden;
          font-size: 0px;
        }

        .desktop_hide,
        .desktop_hide table {
          display: table !important;
          max-height: none !important;
        }
      }

	  .nl-container{
		background-color: #d9dffa;
	  }

	  .row .row-1{
		background-color: #cfd6f4;
	  }

    .row .row-2 {
      background-color: #d9dffa;
    }

    .row .row-5{
      background-color: #ffffff;
    }

	  .row-content .stack{
		color: #000000;
		width: 600px;
		margin: 0 auto;
	  }

    .column .column-1{
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
      font-weight: 400;
      text-align: left;
      padding-top: 20px;
      vertical-align: top;
      border-top: 0px;
      border-right: 0px;
      border-bottom: 0px;
      border-left: 0px;
    }
    
    .alignment{
      line-height: 10px
    }

    .paragraph_block .block-1, .block-2, .block-3, .block-5, .block-6{
      word-break: break-word;
    }

    .pad div {
      color: #506bec;
      font-family: Helvetica Neue, Helvetica,
        Arial, sans-serif;
      font-size: 38px;
      line-height: 120%;
      mso-line-height-alt: 45.6px;
    }

    .pad div p {
      margin: 0; word-break: break-word
    }

    .pad .alignment a{
      text-decoration: none;
      display: inline-block;
      color: #ffffff;
      background-color: #506bec;
      border-radius: 16px;
      width: auto;
      border-top: 0px solid TRANSPARENT;
      font-weight: undefined;
      border-right: 0px solid TRANSPARENT;
      border-bottom: 0px solid TRANSPARENT;
      border-left: 0px solid TRANSPARENT;
      padding-top: 8px;
      padding-bottom: 8px;
      font-family: Helvetica Neue, Helvetica,
        Arial, sans-serif;
      font-size: 15px;
      text-align: center;
      mso-border-alt: none;
      word-break: keep-all;
    }

    .pad .alignment a span {
      padding-left: 25px;
      padding-right: 20px;
      font-size: 15px;
      display: inline-block;
      letter-spacing: normal;
    }

    .pad .alignment a span span{
      word-break: break-word
    }

    .pad .alignment a span span span{
      line-height: 30px
    }  
    </style>
</head>
<body>
    <?= $this->fetch('content') ?>
</body>
</html>
