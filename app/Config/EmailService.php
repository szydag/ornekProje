<?php

namespace Config;

use App\Helpers\MailEncryptHelper;
use CodeIgniter\Config\BaseService;
use CodeIgniter\Log\Logger;

class EmailService extends BaseService
{
    function mailGonder($to, $subject, $message,$button = [])
    {
        // MAIL SERVİSİ DEVRE DIŞI - SUNUM İÇİN
        // External API çağrısı kaldırıldı
        
        // Log'a yaz (opsiyonel)
        log_message('info', "Mail gönderimi simüle edildi - To: $to, Subject: $subject");
        
        // Console'a yazdır (development için)
        echo "📧 MAIL SIMULATION: To: $to, Subject: $subject\n";
        
        return true;
    }
}
