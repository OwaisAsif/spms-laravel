<?php

namespace Database\Seeders;

use App\Models\Utility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UtilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $utilities = [
            ['key' => 'facilities', 'value' => 'Carpark 車場,Convenient 近地鐵,H.celling高樓底,Lobby 冷氣大堂,Sunlight 揚窗,Toilet 內厠,Heater 熱水爐,Sink 鋅盤,Electrical 大電,Wide door 闊門,Ekey 密碼鎖,Bricked 磗牆,Free wifi 送上網,Room 有房,Roof bal天台露台,Shop 地舖,Public Shower 公共淋浴'],
            ['key' => 'types', 'value' => 'Rent 放租,Sales 放售,Subdivided 分間,Independent 獨立單位,Development 發展商,Office 寫字樓,Warehouse 倉庫,Overnight 過夜,Upstairs shop 樓上舖,Party room 派對房,Band 夾,Class 有聲教班,Class 一般教班,Bakery 烘焙,Photos 攝影,Restaurant 餐廳'],
            ['key' => 'decorations', 'value' => 'budget,basic,luxury,classic,chill,grand,modern,premium'],
            ['key' => 'usage', 'value' => 'IND 工業,COM 商業,SHOP 商舖,CPS 車位,RES 住宅,IND,OTH 其他'],
            ['key' => 'district', 'value' => 'yt 油塘,kt 觀塘,klb 九龍灣,spk 新浦崗,csw 長沙灣,lck 荔枝角,kc 葵涌,tw 荃灣,mk 旺角,tst 尖沙咀,tkw 土瓜灣,kat 啟德,hh 紅磡,tkt 大角咀,jd 佐敦,ft 火炭,st 沙田,tp 大埔,ss 上水,tm 屯門,yl 元朗,tko 將軍澳,ty 青衣,wch 黃竹坑,sw 上環,ct 中環,wc 灣仔,cwb 銅鑼灣,np 北角,qb 鰂魚涌,skw 筲箕灣,cw 柴灣,ssw 小西灣'],
        ];

        foreach ($utilities as $utility) {
            Utility::updateOrCreate(['key' => $utility['key']], ['value' => $utility['value']]);
        }
    }
}
