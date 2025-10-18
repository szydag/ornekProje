<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Processes extends BaseConfig
{
    public function getApplicationProcesses()
    {
        return env("APP_PROCESSES_TEMPLATE");
    }

    public function getProcesses()
    {
        $template = $this->getApplicationProcesses();
    
        if (property_exists($this, $template)) {
            return $this->{$template};
        }
    
        return [];
    }
    
    
    public function firstProcesses()
    {
        $processes = $this->getProcesses();

        foreach ($processes as $key => $item) {
            if (isset($item['first']) && $item['first'] == true) {
                return $key;
            }
        }

        return null;
    }


   
    public function nextProcesses($processes_code, $action_code)
    {
        $processes = $this->getProcesses();
        if (isset($processes[$processes_code])) {
            $result = [];
            foreach ($processes[$processes_code]['action'] ?? [] as $item) {
                if ($item['action_code'] == $action_code) {
                    $nextProcessCode = $item['next'];

                    if (isset($processes[$nextProcessCode])) {
                        $result = $processes[$nextProcessCode];
                    } else {
                        return null;
                    }
                }
            }
            if (count($result) > 0) {
                return $result;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }




    #--------------------------------------------------------------------
    # Default Processes
    #--------------------------------------------------------------------


    public $default = [
         'on_inceleme' => [
            'name' => 'Ön İnceleme',
            'icon' => 'fa fa-user-plus',
            'color' => 'primary',
            'visible_role' => [2],//sadece yönetici görebilir
            'action_role' => [2],//sadece yönetici işlem yapabilir
            'first' => true,
            'action' => [
                ['name' => 'Revizyon', 'icon' => 'fa fa-eye', 'color' => 'outline-primary', 'action_code' => 'revizyon', 'next' => 'revizyonok', 'process_code' => 'on_inceleme'],
                ['name' => 'Red', 'icon' => 'fa fa-times', 'color' => 'outline-danger', 'action_code' => 'red', 'next' => 'end', 'process_code' => 'on_inceleme'],
                ['name' => 'Onay', 'icon' => 'fa fa-check', 'color' => 'outline-success', 'action_code' => 'onay', 'next' => 'korhakemlik', 'process_code' => 'on_inceleme'],
            ],
        ],
          'korhakemlik' => [ 
            'name' => 'Hakem Atama',
            'icon' => 'fa fa-gavel',
            'color' => 'primary',
            'visible_role' => [4],//sadece hakem görebilir
            'action_role' => [4],//sadece hakem işlem yapabilir
            'action' => [
                ['name' => 'Revizyon', 'icon' => 'fa fa-eye', 'color' => 'outline-primary', 'action_code' => 'revizyon', 'next' => 'revizyonok', 'process_code' => 'on_inceleme'],
                ['name' => 'Red', 'icon' => 'fa fa-times', 'color' => 'outline-danger', 'action_code' => 'red', 'next' => 'end', 'process_code' => 'on_inceleme'],
                ['name' => 'Onay', 'icon' => 'fa fa-check', 'color' => 'outline-success', 'action_code' => 'onay', 'next' => 'editorkontrol', 'process_code' => 'on_inceleme'],
            ],
        ],
         'editorkontrol' => [ 
            'name' => 'Atama',
            'icon' => 'fa fa-gavel',
            'color' => 'primary',
            'visible_role' => [2],//sadece editör görebilir
            'action_role' => [2],//sadece editör işlem yapabilir
            'action' => [
                ['name' => 'Revizyon', 'icon' => 'fa fa-eye', 'color' => 'outline-primary', 'action_code' => 'revizyon', 'next' => 'revizyonok', 'process_code' => 'on_inceleme'],
                ['name' => 'Red', 'icon' => 'fa fa-times', 'color' => 'outline-danger', 'action_code' => 'red', 'next' => 'end', 'process_code' => 'on_inceleme'],
                ['name' => 'Onizleme', 'icon' => 'fa fa-check', 'color' => 'outline-success', 'action_code' => 'onizleme', 'next' => 'yayinla', 'process_code' => 'on_inceleme'],
            ],
        ],
         'revizyonok' => [ // kullanıcı 
            'name' => 'Düzeltme',
            'icon' => 'fa fa-user-edit',
            'color' => 'warning',
            'visible_role' => [],
            'action_role' => [],
            'action' => [
                ['name' => 'Başvuruyu Düzenle', 'icon' => 'fa fa-check', 'color' => 'outline-success', 'action_code' => 'revizyonok', 'next' => 'on_inceleme', 'process_code' => 'revizyonok'],
            ],
        ],
         'yayinla' => [
            'name' => 'Yayına Alınacak',
            'icon' => 'fa fa-gavel',
            'color' => 'primary',
            'visible_role' => [2],//sadece yönetici görebilir
            'action_role' => [2],//sadece yönetici işlem yapabilir
            'action' => [
                ['name' => 'Yayına Alınacak', 'icon' => 'fa fa-check', 'color' => 'outline-primary', 'action_code' => 'yayinla', 'next' => 'end', 'process_code' => 'yayinla'],
            ],
        ],
    ];
} 
