<!doctype html>
<html>
<head>
    <!-- <link href="<.?php echo base_url()?>css/style.css" rel="stylesheet" /> -->
    <style>
        h1, h2 { font-family: Arial, sans-serif; font-size: 25px; }
        h2 { font-size: 20px; }
         
        label { font-family: Verdana, sans-serif; font-size: 12px; display: block; }
        input { padding: 3px 5px; width: 250px; margin: 0 0 10px; }
        input[type="file"] { padding-left: 0; }
        input[type="submit"] { width: auto; }
         
        #files { font-family: Verdana, sans-serif; font-size: 11px; }
        #files strong { font-size: 13px; }
        #files a { float: right; margin: 0 0 5px 10px; }
        #files ul { list-style: none; padding-left: 0; }
        #files li { width: 280px; font-size: 12px; padding: 5px 0; border-bottom: 1px solid #CCC; }
    </style>
</head>
<body>
    <h1>Upload File</h1>
    <form method="post" action="" id="upload_file" enctype="multipart/form">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="" />
  
        <label for="userfile">File</label>
        <input type="file" name="userfile" id="userfile" size="20" />
  
        <input type="submit" name="submit" id="submit" />
    </form>

    <h2>Files</h2>
    <div id="files"></div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <!-- <script src="<.?php echo base_url()?>js/site.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.ajaxfileupload.js"></script>
    <script type="text/javascript">
    $(function() {
        $('#upload_file').submit(function(e) {
            e.preventDefault();
            if($('#userfile').val() == ''){
                alert('Pilih file yang akan diupload...');
            }else{
                console.log(new FormData(this));
                
                // $.ajax({
                //     url     : '<?php echo base_url();?>daftaronline/ajax_upload',
                //     method  : 'POST',
                //     data    : new FormData(this),
                //     contentType : false,
                //     cache       : false,
                //     processData : false,
                //     success : function(data){
                //         $('#files').html(data);
                //     }
                // });
            }
        });

    //$(document).ready(function() {
        // function refresh_files(){
        //     $.get('../daftaronline/files/')
        //     //$.get('../assets/upload/')
        //     .success(function (data){
        //         $('#files').html(data);
        //     });
        // }
        // refresh_files();


        //$('#upload_file').submit(function(e) {
        //     e.preventDefault();



            // console.log('./daftaronline/upload_file/');

            //$('#userfile').ajaxFileUpload({
            //$.AjaxFileUpload({


            // $('#userfile').AjaxFileUpload({
            // //$.ajax({
            //     //url             : '../upload/upload_file/', 
            //     //url             : '../daftaronline/upload_file/', 
            //     url             : '../', 
            //     //secureuri       : false,
            //     //fileElementId   : 'userfile',
            //     dataType        : 'json',
            //     // dataType        : 'JSON',
            //     data            : {
            //         'title' : $('#title').val()
            //     },
            //     success : function (data, status){
            //         if(data.status != 'error'){
            //             $('#files').html('<p>Reloading files...</p>');
            //             refresh_files();
            //             $('#title').val('');
            //         }
            //         alert(data.msg);
            //     }
            // });
            // return false;
            
        //});

            // $('#userfile').AjaxFileUpload({
            //     onComplete: function(filename, response){
            //         console.log(filename);
            //         console.log(response);
            //         $("#files").append(
            //             $("<img />").attr("src", filename).attr("width", 200)
            //         );
            //     }

            //     // //url             : '../upload/upload_file/', 
            //     // //url             : '../daftaronline/upload_file/', 
            //     // url             : '../daftaronline/', 
            //     // //secureuri       : false,
            //     // //fileElementId   : 'userfile',
            //     // dataType        : 'json',
            //     // // dataType        : 'JSON',
            //     // data            : {
            //     //     'title' : $('#title').val()
            //     // },
            //     // success : function (data, status){
            //     //     // if(data.status != 'error'){
            //     //     //     $('#files').html('<p>Reloading files...</p>');
            //     //     //     refresh_files();
            //     //     //     $('#title').val('');
            //     //     // }
            //     //     alert(data.msg);
            //     // }
            // });
    });
    </script>
    <!-- <script src="<.?php echo base_url()?>js/ajaxfileupload.js"></script> -->
    
</body>
</html>