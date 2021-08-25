<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{

    protected $settings_data = [
        ['name'=>'title','value'=>'Laravel Base'],
        ['name'=>'address','value'=>''],
        
        ['name'=>'logo','value'=>''],
        ['name'=>'favicon','value'=>''],

        ['name'=>'currency_code','value'=>'BDT'],
        ['name'=>'currency_symbol','value'=>'Tk'],
        ['name'=>'currency_position','value'=>'right'],

        ['name'=>'invoice_prefix','value'=>'INV-'],
        ['name'=>'invoice_number','value'=>'00001'],
        ['name'=>'timezone','value'=>'Asia/Dhaka'],
        ['name'=>'date_format','value'=>'d-m-Y'],

        ['name'=>'mail_mailer','value'=>'smtp'],
        ['name'=>'mail_host','value'=>''],
        ['name'=>'mail_port','value'=>''],
        ['name'=>'mail_username','value'=>''],
        ['name'=>'mail_password','value'=>''],
        ['name'=>'mail_encryption','value'=>''],
        ['name'=>'mail_from_name','value'=>''],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert(
            $this->settings_data
        );
    }
}
