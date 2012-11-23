<?php
$aKanban["name"] = "aKanban";

$aKanban["datafilename"] = basename(__FILE__, '.php').".txt";

if(isset($_GET["save"])){
    if(file_put_contents($aKanban["datafilename"], stripslashes($_POST["data"])))
        echo "ok";
    die();
}
if(isset($_GET["load"])){
    echo file_get_contents($aKanban["datafilename"]);
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>aKanban</title>
    <meta name="description" content="">
    <meta name="author" content="Arthur Puyou">

    <style type="text/css">
    body {
        padding-top: 60px;
        padding-bottom: 40px;
    }
    .sidebar-nav {
        padding: 9px 0;
    }
    #dialog-form {
        display: none;
    }
    #dialog {
        display: none;
        text-align: center;
        font-size: 12px;
    }
    #dialog img {
        margin-top: 30px;
    }
    #dialog-contents, #dialog-title {
        width: 100%;
    }
    #dialog-contents {
        height: 150px;
        font-size: 10px;
    }
    
    .column { width: 170px; float: left; padding-bottom: 100px; }
    .portlet { margin: 0 1em 1em 0; }
    .portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }
    .portlet-header .ui-icon { float: right; }
    .portlet-content { padding: 0.4em; font-size: 12px; }
    .ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
    .ui-sortable-placeholder * { visibility: hidden; }
    </style>
    
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/css/bootstrap.no-responsive.no-icons.min.css" rel="stylesheet">
    
    <script type="text/javascript">
    var currentPortlet;
    
    function nl2br(str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
        return (str + '').replace(/(\r\n|\n\r|\r|\n)/g, breakTag);
    }
    
    function br2nl(varTest){
        return varTest.replace(/<br\s*\/?>/mg,"\n");
    }
    
    function save(){
        $("#dialog").dialog({resizable: false});
        $(".ui-dialog-titlebar").hide();
    
        $.post('?save', {data: $("#holder").html() }, function(data) {
            setTimeout('$("#dialog").dialog("close");', 500);
        });
    }
    
    function initMap(){
        $(".column").sortable({
            connectWith: ".column"
        });

        $(".portlet-header .ui-icon").click(function() {
            currentPortlet = $(this);
            $("#dialog-title").val(currentPortlet.siblings(".title").html());
            $("#dialog-contents").val(br2nl(currentPortlet.parent().parent().find(".portlet-content").html()));
            $("#dialog-form").dialog("open");               
        });

        $(".column").disableSelection();
    }
    
    function load(){
        $("#dialog").dialog({resizable: false});
        $(".ui-dialog-titlebar").hide();
        
        $.get('?load', function(data) {
            $("#holder").html(data);
            
            initMap();
            
            $("#dialog").dialog("close");
        });
    }
    
    $(document).ready(function() {
        $("#save").click(save);
        $("#update").click(load);
        
        load();
        
        $("#dialog-form").dialog({
            autoOpen: false,
            height: 420,
            width: 550,
            modal: true,
            buttons: {
                "OK": function() {
                    currentPortlet.siblings(".title").html($("#dialog-title").val());
                    currentPortlet.parent().parent().find(".portlet-content").html(nl2br($("#dialog-contents").val()));
                    $(this).dialog("close");
                    save();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });
        
        $("#addlink").click(function(){
            $(".column").first().append('<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">'
                +'<div class="portlet-header ui-widget-header ui-corner-all"><span class="ui-icon ui-icon-pencil"></span><span class="title">Title</span></div>'
                +'<div class="portlet-content">Text</div>'
                +'</div>');
                initMap();
        });
        
    });
    </script>
    
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#"><?php echo $aKanban["name"] ?></a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              <a href="#" class="navbar-link" id="update">Update</a>
              <a href="#" class="navbar-link" id="save">Save</a>
              <a href="#" class="navbar-link" id="addlink">New</a>
            </p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div id="dialog">
        <img src="data:image/gif;base64,R0lGODlhGAAYAPYAAP///4Wex/j5+9Xd66u82Jmt0I2kytPb6v39/cbS5I6ly4Wex/L0+J+z056y
0vT2+ZSqzZOpzfH0+Pv7/MTQ5Pf4+s3X58zW56q715yw0YegyIqiyZmu0Ovv9d7l75GnzLbF3fX3
+qi515arzq292dXe64ihyM/Y6O/y9+nt9IujyrvJ38PP49ri7cHO4snU5rPD3Pr6/Juw0ebr89ff
7NLb6rnH3qW31aS21Zesz6K11OPo8ae51sHN4q/A2rXE3djg7ZCnzO7x97zJ4Nvi7gAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/
C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJBQAAACwA
AAAAGAAYAAAHmoAAgoOEhYaHgxUWBA4aCxwkJwKIhBMJBguZmpkqLBOUDw2bo5kKEogMEKSkLYgI
oqubK5QJsZsNCIgCCraZBiiUA72ZJZQABMMgxgAFvRyfxpixGx3LANKxHtbNth8hy8i9IssHwwsX
xgLYsSYpxrXDz5QIDubKlAwR5q2UErC2poxNoLBukwoX0IxVuIAhQ6YRBC5MskaxUCAAIfkECQUA
AAAsAAAAABgAGAAAB6GAAIKDhIWGh4MVFgQOGhsOGAcxiIQTCQYLmZqZGwkIlA8Nm6OaMgyHDBCk
qwsjEoUIoqykNxWFCbOkNoYCCrmaJjWHA7+ZHzOIBMUND5QFvzATlACYsy/TgtWsIpPTz7kyr5TK
v8eUB8ULGzSIAtq/CYi46Qswn7AO9As4toUMEfRcHZIgC9wpRBMovNvU6d60ChcwZFigwYGIAwKw
aUQUCAAh+QQJBQAAACwAAAAAGAAYAAAHooAAgoOEhYaHgxUWBA4aCzkkJwKIhBMJBguZmpkqLAiU
Dw2bo5oyEocMEKSrCxCnhAiirKs3hQmzsy+DAgq4pBogKIMDvpvAwoQExQvHhwW+zYiYrNGU06wN
HpSCz746O5TKyzwzhwfLmgQphQLX6D4dhLfomgmwDvQLOoYMEegRyApJkIWLQ0BDEyi426Six4Rt
gipcwJAhUwQCFypA3IgoEAAh+QQJBQAAACwAAAAAGAAYAAAHrYAAgoOEhYaHgxUWBA4aCxwkJzGI
hBMJBguZmpkGLAiUDw2bo5oZEocMEKSrCxCnhAiirKsZn4MJs7MJgwIKuawqFYIDv7MnggTFozlD
LZMABcpBPjUMhpisJiIJKZQA2KwfP0DPh9HFGjwJQobJypoQK0S2B++kF4IC4PbBt/aaPWA5+Cdj
QiEGEd5FQHFIgqxcHF4dmkBh3yYVLmx5q3ABQ4ZMBUhYEOCtpLdAACH5BAkFAAAALAAAAAAYABgA
AAeegACCg4SFhoeDFRYEDhoaDgQWFYiEEwkGC5mamQYJE5QPDZujmg0PhwwQpKsLEAyFCKKsqw0I
hAmzswmDAgq5rAoCggO/sxaCBMWsBIIFyqsRgpjPoybS1KMqzdibBcjcmswAB+CZxwAC09gGwoK4
3LuDCA7YDp+EDBHPEa+GErK5GkigNIGCulEGKNyjBKDCBQwZMmXAcGESw4uUAgEAIfkECQUAAAAs
AAAAABgAGAAAB62AAIKDhIWGh4MVFgQOGgscJCcxiIQTCQYLmZqZBiwIlA8Nm6OaGRKHDBCkqwsQ
p4QIoqyrGZ+DCbOzCYMCCrmsKhWCA7+zJ4IExaM5Qy2TAAXKQT41DIaYrCYiCSmUANisHz9Az4fR
xRo8CUKGycqaECtEtgfvpBeCAuD2wbf2mj1gOfgnY0IhBhHeRUBxSIKsXBxeHZpAYd8mFS5seatw
AUOGTAVIWBDgraS3QAAh+QQJBQAAACwAAAAAGAAYAAAHooAAgoOEhYaHgxUWBA4aCzkkJwKIhBMJ
BguZmpkqLAiUDw2bo5oyEocMEKSrCxCnhAiirKs3hQmzsy+DAgq4pBogKIMDvpvAwoQExQvHhwW+
zYiYrNGU06wNHpSCz746O5TKyzwzhwfLmgQphQLX6D4dhLfomgmwDvQLOoYMEegRyApJkIWLQ0BD
Eyi426Six4RtgipcwJAhUwQCFypA3IgoEAAh+QQJBQAAACwAAAAAGAAYAAAHoYAAgoOEhYaHgxUW
BA4aGw4YBzGIhBMJBguZmpkbCQiUDw2bo5oyDIcMEKSrCyMShQiirKQ3FYUJs6Q2hgIKuZomNYcD
v5kfM4gExQ0PlAW/MBOUAJizL9OC1awik9PPuTKvlMq/x5QHxQsbNIgC2r8JiLjpCzCfsA70Czi2
hQwR9FwdkiAL3ClEEyi829Tp3rQKFzBkWKDBgYgDArBpRBQIADsAAAAAAAAAAAA=" /><br />Loading...
    </div>

    <div id="dialog-form" title="Edit">
    <form>
    <fieldset>
        <label for="dialog-title">Title</label>
        <input type="text" id="dialog-title" class="text ui-widget-content ui-corner-all" />
        <label for="dialog-contents">Contents</label>
        <textarea class="text ui-widget-content ui-corner-all" id="dialog-contents"></textarea>
    </fieldset>
    </form>
</div>
    
    
    <div class="container-fluid">
        <div class="row-fluid">
            <span class="span3">
                <h3>ToDo</h3>
            </span>
            <span class="span3">
                <h3>Doing</h3>
            </span>
            <span class="span3">
                <h3>Waiting on</h3>
            </span>
            <span class="span3">
                <h3>Done</h3>
            </span>
        </div>
        <div id="holder" class="row-fluid"></div>
        <hr>
        <footer>
            <p>Powered by <a href="https://github.com/apuyou/akanban">aKanban</a></p>
        </footer>
    </div>
  </body>
</html>

