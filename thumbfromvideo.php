<?php
include "ccrypt.php";
//where you want your thumbnails to go
$thumbs_dir = $_GET['thumbpath'];

if( isset($_POST["name"] )){
   // Grab the MIME type and the data with a regex for convenience
    if (!preg_match('/data:([^;]*);base64,(.*)/', $_POST['data'], $matches)) {
        die( $_POST['data']);
    }

    // Decode the data
    $data = $matches[2];
    $data = str_replace(' ','+',$data);
    $data = base64_decode($data);

    $file = $_POST['name'];
    $data= cryptfile($data, MainKey);
    file_put_contents($thumbs_dir.'/'.$file, $data);

    print 'done ';
    exit;
}
?>
<div id="olFrames"></div>
<script>
function getVideoImage(path, secs, callback) {

  var me = this, video = document.createElement('video');

  video.onloadedmetadata = function() {

    if ('function' === typeof secs) {

      secs = secs(this.duration);

    }

    this.currentTime = Math.min(Math.max(0, (secs < 0 ? this.duration : 0) + secs), this.duration);

  };

  video.onseeked = function(e) {

    var canvas = document.createElement('canvas');

    canvas.height = video.videoHeight;

    canvas.width = video.videoWidth;

    var ctx = canvas.getContext('2d');

    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    var img = new Image();

    img.src = canvas.toDataURL('image/jpeg',1.0);

    callback.call(me, img, this.currentTime, e);

  };

  video.onerror = function(e) {

    callback.call(me, undefined, undefined, e);

  };

  video.src = path;

}


getVideoImage("<?php echo $_GET['filename']; ?>",

    5,

    function(img, secs, event) {

      if (event.type == 'seeked') {

        document.getElementById('olFrames').appendChild(img);

    //send to php script
    var xmlhttp = new XMLHttpRequest;
    var filename =  "<?php echo $_GET['filename']; ?>";
    var res = filename.split("/");
    filename = res[res.length-1];

    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            console.log('saved');
            console.log(xmlhttp.responseText);
        }
    }
    console.log('saving');
    xmlhttp.open("POST", location.href, true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send('name='+encodeURIComponent(filename)+'&data='+img.src);
        }

    }

  );


</script>