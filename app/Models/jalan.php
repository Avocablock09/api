<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jalan extends Model
{
    use HasFactory;
    protected $fillable = [
        'longitude',
        'latitude',
        'status',
        
    ];

    public static function NCij($dist){
        
        $current = 115.2605;
        $result = jalan::where('longitude','<',$current+0.0001)->where('longitude','>',$current-0.0001)->get();
        $sum = count($result);
        echo($result.'<br>'.$sum);
        $part1= 1/(sqrt(2*3.14*20));
        $powup = 0-pow(($dist-43.2816),2);
        $powdown = 2*pow(20,2);
        $power = $powup/$powdown;
        $n=($part1*pow(2.7183,$power));
        return $n;
    }

    public static function VCij($dist1,$dist2){
        
    }

    public function hitung(){

    }

    public function obs_prob(){
        
    }
}
