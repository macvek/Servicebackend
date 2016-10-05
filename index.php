<?php require 'engine.php'; ?>
<!doctype html>
<html>
<head>
<title>Service backend @</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Poiret+One|Quicksand" rel="stylesheet">
<body>
    <div id="pluginbox-container">
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
                        <td class="valuecol"><input id="control_refresh_rate"></input></td>
                    </tr>
                    <tr>
                        <td class="labelcol">fade_on_update</td>
                        <td class="valuecol"><input id="control_fade_on_update" type="checkbox"></input></td>
                    </tr>
                    <tr>
                        <td class="labelcol">console_scroll_lock</td>
                        <td class="valuecol"><input id="control_console_scroll_lock" type="checkbox"></input></td>
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
        <div class="pluginbox">
            <div class="pluginbox-title">debug_pane</div>
            <div class="pluginbox-content">
                <button id="debug-console-hello">Console.Hello</button>
                <button id="debug-serializer-clear">Serializer.Clear</button>
                <button id="debug-serializer-boot">Serializer.Boot</button>
                <button id="debug-serializer-save">Serializer.Save</button>
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
            var pluginboxenum = 1;
            $(".pluginbox").each(function() {
                $(this).attr("X-core-enum", pluginboxenum++);
            });

            MessageBroker.subscribe("serializer.pack", function() {
                 var enumList = [];
                 $(".pluginbox").each(function() {
                     enumList.push($(this).attr("X-core-enum"));
                 });

                 MessageBroker.send("serializer.store", {
                     name:"controlpanel.enum",
                     store: {"enum":enumList}
                 });
            });

            MessageBroker.subscribe("serializer.unpack", function(what, props) {
                MessageBroker.send("serializer.load", "controlpanel.enum",function(loaded) {
                    if (loaded) {
                        onEnumList(loaded.enum);
                    }
                });

                function onEnumList(list) {
                    var enums = {};
                    $(".pluginbox").each(function() {
                        var enumIndex = $(this).attr("X-core-enum");
                        if (!enumIndex) {
                            return;
                        }

                        enums[enumIndex] = $(this).detach();
                    });

                    for (var i=0;i<list.length;i++) {
                        $("#pluginbox-container").append(enums[list[i]]);
                        delete enums[list[i]];
                    }

                    $.each(enums, function(one) {
                        console.log("not loaded enum", one);
                        $("#pluginbox-container").append(one);
                    });
                }

            });
            
            $("#control_console_scroll_lock").change(function() {
                MessageBroker.send("serviceconsole.autoscroll",false === $(this).prop("checked"));
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


            MessageBroker.subscribe("serializer.pack", function() {
                 var controls = {
                     "customize_panes" : $("#control_customize_panes").prop("checked"),
                     "console_scroll_lock" : $("#control_console_scroll_lock").prop("checked"),
                     "fade_on_update" : $("#control_fade_on_update").prop("checked"),
                     "refresh_rate" : $("#control_refresh_rate").val()
                 };

                 MessageBroker.send("serializer.store", {
                     name:"controlpanel.controls",
                     store: controls
                 });
            });

            MessageBroker.subscribe("serializer.unpack", function() {
                MessageBroker.send("serializer.load", "controlpanel.controls", function(controls) {
                    if (controls) {
                        $("#control_customize_panes").prop("checked", controls["customize_panes"]).change();
                        $("#control_console_scroll_lock").prop("checked", controls["console_scroll_lock"]).change();
                        $("#control_fade_on_update").prop("checked", controls["fade_on_update"]).change();
                        $("#control_refresh_rate").val(controls["refresh_rate"]).change();
                    }
                });
            });

            MessageBroker.broadcast("appstart");
            MessageBroker.broadcast("serializer.boot");

            $("#debug-console-hello").click(function() {
                MessageBroker.send("serviceconsole.write", "Console.Hello . "+new Date());
            });

            $("#debug-serializer-clear").click(function() {
                MessageBroker.send("serializer.clear");
            });

            $("#debug-serializer-boot").click(function() {
                MessageBroker.send("serializer.boot");
            });

            $("#debug-serializer-save").click(function() {
                MessageBroker.send("serializer.save");
            });

        });
    </script>
</body>

</html>