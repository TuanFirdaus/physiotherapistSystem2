<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    // From Email and Name (this will be your Gmail)
    public string $fromEmail = 'tfirdaus676@gmail.com';  // Gmail email address
    public string $fromName  = 'Admin';  // The name to appear in the "From" field
    public string $recipients = '';  // Leave this empty or set default recipients if needed

    public string $userAgent = 'CodeIgniter';

    // Use SMTP protocol
    public string $protocol = 'smtp';

    // No need to modify mailPath for SMTP usage
    public string $mailPath = '/usr/sbin/sendmail';

    // SMTP Settings for Gmail
    public string $SMTPHost = 'smtp.gmail.com';  // Gmail's SMTP server
    public string $SMTPUser = 'tfirdaus676@gmail.com';  // Gmail address
    public string $SMTPPass = 'hvby czkr eayo mfnc';  // Gmail app password (not your regular Gmail password)
    public int $SMTPPort = 587;  // Port for TLS (587) or SSL (465)
    public int $SMTPTimeout = 5;  // Connection timeout in seconds

    // Enable persistent SMTP connections (usually false for Gmail)
    public bool $SMTPKeepAlive = false;

    // Enable TLS encryption for Gmail
    public string $SMTPCrypto = 'tls';  // Use 'tls' for port 587, or 'ssl' for port 465

    public bool $wordWrap = true;
    public int $wrapChars = 76;
    public string $mailType = 'text';  // Send email as text (or 'html' if you want HTML emails)
    public string $charset = 'UTF-8';

    public bool $validate = false;  // Disable email validation (you can enable if needed)
    public int $priority = 3;  // Normal priority
    public string $CRLF = "\r\n";  // Line breaks for emails
    public string $newline = "\r\n";  // Newline character

    public bool $BCCBatchMode = false;  // No batch mode by default
    public int $BCCBatchSize = 200;  // Batch size if using BCC
    public bool $DSN = false;  // No DSN (delivery status notification)
}
