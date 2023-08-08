<?php

function GetClientMac($db){

    $isOnWindows=strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    
    $ip=$_SERVER['REMOTE_ADDR'];
    $mac='admin';
    if($ip!='127.0.0.1'){
        $out=shell_exec('arp -a '.$ip .'');
        // Regular expression to match the MAC address
        $pattern = $isOnWindows?'/([0-9A-Fa-f]{2}-){5}[0-9A-Fa-f]{2}/':'/(([a-f\d]{1,2}\:){5}[a-f\d]{1,2})/i';
        $mac=preg_match($pattern, $out, $matches)?$macAddress = str_replace('-', ':', $matches[0]):false;
    }
    if($mac!==false)
    {
        // $start=strpos($out,'at')+3;
        // $length=strpos($out,' ',$start)-$start;
        // $mac=substr($out,$start,$length);
        $r=$db->run('select credits from clients where mac=:mac',[':mac'=>$mac]);
        $credits=0;
        if($r->rowCount()==0)
            $db->insert('clients',['mac'=>$mac,'ip'=>$ip,'credits'=>0]);
        else
        {
            if($res=$r->fetch())
                $credits=$res['credits'];
        }
        return [
            'ip'=>$ip,
            'mac'=>$mac,
            'credits'=>$credits,
            'dirname'=>str_replace(':','',$mac)
        ];
    }

}
$client=GetClientMac($db); 