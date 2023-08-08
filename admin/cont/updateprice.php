<?php

include '../../config.php';

if(isset($_GET['reset'])){
    $db->truncate('price');
    $db->insert('price',['price'=>1,'name'=>'Letter']);
    $db->insert('price',['price'=>2,'name'=>'Legal']);
    $db->insert('price',['price'=>1,'name'=>'A4']);
    $db->insert('price',['price'=>1,'name'=>'bnw']);
    $db->insert('price',['price'=>2,'name'=>'grayscale']);
    $db->insert('price',['price'=>1,'name'=>'colored']);
    $_SESSION['msg']=[
        'type'=>'success',
        'msg'=>'Price reset successful'
    ];
    header('location:../prices.php');
    return;
}
if(isset($_POST['paper'])){
    if(
        $db->update('price',['price'=>$_POST['Letter']],['name'=>'Letter'])>0 ||
        $db->update('price',['price'=>$_POST['Legal']],['name'=>'Legal'])>0 ||
        $db->update('price',['price'=>$_POST['A4']],['name'=>'A4'])>0 
        ){
        $_SESSION['msg']=[
            'type'=>'success',
            'msg'=>'Price updated successfully'
        ];
        header('location:../prices.php');
        return;
    }else{
        $_SESSION['msg']=[
            'type'=>'error',
            'msg'=>'No changes made'
        ];
        header('location:../prices.php');
        return;
    }
}else if(isset($_POST['type'])){
    if(
        $db->update('price',['price'=>$_POST['bnw']],['name'=>'bnw'])>0 ||
        $db->update('price',['price'=>$_POST['grayscale']],['name'=>'grayscale'])>0 ||
        $db->update('price',['price'=>$_POST['colored']],['name'=>'colored'])>0 
    ){
        $_SESSION['msg']=[
            'type'=>'success',
            'msg'=>'Price updated successfully'
        ];
        header('location:../prices.php');
        return;
    }else{
        $_SESSION['msg']=[
            'type'=>'error',
            'msg'=>'No changes made'
        ];
        header('location:../prices.php');
        return;
    }
}
else{
	$_SESSION['msg']=[
            'type'=>'error',
            'msg'=>'Request error'
        ];
        header('location:../prices.php');
        return;

}