<?php require 'engine.php'; ?>
<!doctype html>
<html>
<head>
<title>Service backend @</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Poiret+One|Quicksand" rel="stylesheet">
<body>
    <div>
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
                        <td class="valuecol"><input class="" type="checkbox"></input></td>
                    </tr>
                    <tr>
                        <td class="labelcol">console_autoscroll</td>
                        <td class="valuecol"><input id="control_console_autoscroll" type="checkbox"></input></td>
                    </tr>
                    <tr>
                        <td class="labelcol">customize_panes</td>
                        <td class="valuecol"><input id="control_customize_panes" type="checkbox"></input></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="pluginbox plugin-console" >
            <div class="pluginbox-buttons">
                <span class="clear-console">&#10008;</span>
            </div>
            <div class="pluginbox-title">console</div>
            <div class="pluginbox-content scrollable-console">

            </div>
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

        .pluginbox-buttons{
            float:left;
            color:white;
        }

        .pluginbox-buttons span {
            cursor:pointer;
        }

        .panes-manager {
            margin-right:5px;
            color:#999;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    <script src="jquery.color.js"></script>
    <script src="messagebroker.js"></script>
    <script src="serializer.js"></script>
    <script src="serviceconsole.js"></script>

    <script>
        $(function() {
            $("#control_console_autoscroll").change(function() {
                MessageBroker.send("serviceconsole.autoscroll",$(this).prop("checked"));
            });

            function doMoveUp() {
                var pluginBox = parentPluginBox(this);
                if (0 === pluginBox.prev().length) { return;}
                var params = animParams(pluginBox);
                moveFirstAfterSecond(pluginBox.prev(), pluginBox);
                animateTransition(params,pluginBox);
            }

            function doMoveDown() {
                var pluginBox = parentPluginBox(this);
                if (0 === pluginBox.next().length) { return;}
                var params = animParams(pluginBox);
                moveFirstAfterSecond(pluginBox, pluginBox.next());
                animateTransition(params,pluginBox);
            }

            function parentPluginBox(actionButton) {
                return $(actionButton).closest(".pluginbox")
            }

            function moveFirstAfterSecond(first, second) {               
                first.detach().insertAfter(second);
            }

            function animParams(from) {
                var offset = $(from).offset();

                return {
                    top: offset.top,
                    left: offset.left,
                    width: $(from).width(),
                    height: $(from).height(),
                    border: $(from).css("border"),
                    borderRadius: $(from).css("border-radius"),
                    padding: $(from).css("padding")
                };
            }

            function animateTransition(fromParam,to) {
                var animBox = $("<div>").css({
                    position:'absolute',
                    top: fromParam.top,
                    left:fromParam.left,
                    width:fromParam.width,
                    height:fromParam.height,
                    backgroundColor:"#fff",
                    border: fromParam.border,
                    borderRadius: fromParam.borderRadius,
                    padding:fromParam.padding,
                    opacity:0.5
                })


                var toOffset = to.offset();
                var toSize = {width: to.width(), height: to.height()};
                $("body").append(animBox);
                animBox.animate({
                    top:toOffset.top,
                    left:toOffset.left,
                    width:toOffset.width,
                    height:toOffset.height,
                    opacity:0
                }, {complete: function() { animBox.remove(); }});
            }

            function prependPanesManager() {
                var panesManager = $("<div>").addClass("panes-manager pluginbox-buttons");
                
                var moveUp = $("<span>").html("&#9650;").click(doMoveUp);
                var moveDown = $("<span>").html("&#9660;").click(doMoveDown);

                panesManager.append(moveUp).append(" ").append(moveDown);

                $(this).prepend(panesManager);

            }

            $("#control_customize_panes").change(function() {
                if ($(this).prop("checked")) {
                    $(".pluginbox").each(prependPanesManager);
                }
                else {
                    $(".pluginbox .panes-manager").remove();
                }
            });
            MessageBroker.broadcast("appstart");
        });
    </script>
</body>

</html>