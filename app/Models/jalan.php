<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jalan extends Model
{
    use HasFactory;
    protected $fillable = [
        'road_segment',
        'longitude',
        'latitude',
        'status',
    ];
    
    public static function observe_prob($current_loc)
    {
        $list = jalan::getBetweenRadius($current_loc);
        foreach($list as $key=>$data){
            // echo $list['latitude'];
            $distance[$key] = sqrt(pow(($data['latitude']-$current_loc['lat']),2)+pow(($data['longitude']-$current_loc['lng']),2))/0.0001*11.1;
        }
        $mu = jalan::mu($distance);
        $dev = jalan::deviation($mu,$distance);
        $pos = [0,0];
        foreach($list as $key=>$data){
            $ncij[$key] = (1/sqrt(2*3.14*$dev))*
            (pow(exp(1),(
                -(
                    ($distance[$key]-$mu)/(2*pow($dev,2))
                )
                )));
            if($ncij[$key]>$pos[1]){
                $pos[1] = $ncij[$key];
                $pos[0] = $key;
            }
        }
        return $list[$pos[0]];
        // return response()->json(['data'=>$list]);
    }

    public static function mu($distance){
        $sigma = 0;
        foreach($distance as $data){
            $sigma = $sigma + $data;
        }
        $mu = $sigma / count($distance);
        return $mu;
    }
    public static function deviation($mu,$distance){
        $dev = 0;
        foreach($distance as $data){
            $dev = $dev + pow(($data-$mu),2);
        }
        $dev = sqrt($dev/count($distance));
        return $dev;
    }

    public static function getBetweenRadius($current_loc)
    {
        $list = jalan::whereRaw('SQRT(POWER((longitude-?),2)+POWER((ABS(latitude)-ABS(?)),2))/0.0001*11.1<30')->setBindings([$current_loc['lng'],$current_loc['lat']])->get();
        return $list;
    }

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
