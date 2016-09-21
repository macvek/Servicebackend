<?php require 'engine.php'; ?>
<!doctype html>
<html>
<head>
<title>Service backend @</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Poiret+One|Quicksand" rel="stylesheet">
<body>
    <div class="pluginbox">
        <div class="pluginbox-title">uptime</div>
        <div class="pluginbox-content">2:13  up 1 day,  4:17, 3 users, load averages: 2,10 2,27 1,97</div>
    </div>
    <div class="pluginbox">
        <div class="pluginbox-title">control_panel</div>
        <div class="pluginbox-content">
            <table class="withvalues">
                <tr>
                    <td class="labelcol">refresh_rate</td>
                    <td class="valuecol"><input></input></td>
                </tr>
                <tr>
                    <td class="labelcol">fade_on_update</td>
                    <td class="valuecol"><input type="checkbox"></input></td>
                </tr>
                <tr>
                    <td class="labelcol">console_autoscroll</td>
                    <td class="valuecol"><input type="checkbox"></input></td>
                </tr>
                <tr>
                    <td class="labelcol">customize_panes</td>
                    <td class="valuecol"><input type="checkbox"></input></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="pluginbox">
        <div class="pluginbox-title">console</div>
        <div class="pluginbox-content scrollable-console">
            <div> a </div>
            <div> b </div>
            <div> c </div>
            <div> d </div>
            <div> e </div>
            <div> f </div>
            <div> g </div>
            <div> h </div>
        </div>
    </div>
    
    <style>
        .pluginbox {
            width:500px;
            float:left;
            border:1px solid #58c;
            border-radius: 15px;
            padding:15px;
            margin:10px;
        }

        .pluginbox-title {
            color:#eee;
            text-align:right;
            font-size:1.3em;
            font-family: 'Open Sans Condensed', sans-serif;
        }

        .pluginbox-content {
            color:#eee;
            font-family: 'Poiret One', cursive;
            color:#a9c;
            
        }

        body {
            background-color:#222;
        }

        .withvalues {
            width:100%;
        }

        .withvalues .labelcol {
            width:40%;
            text-align:right;
            padding-right:10px;
        }

        .withvalues .valuecol {
            text-align:left;
            padding-left:10px;
            
        }

        .withvalues .valuecol input {
            background-color:transparent;
            color:#bcf;
            border-radius:5px;
            border:1px solid #58c;
            padding:2px;
            font-family: 'Quicksand', sans-serif;
        }

        .scrollable-console {
            overflow-y:scroll;
            max-height:80px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    <script src="messagebroker.js"></script>
    <script src="serializer.js"></script>
    
</body>

</html>