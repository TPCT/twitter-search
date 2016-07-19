<?php
error_reporting(0);
@unlink('error_log');
$data = "<html xmlns=\"http://www.w3.org/1999/html\"><head><title>TPCT Twitter Search</title><link rel=\"icon\" type=\"image/png\" href=\"https://cdn0.iconfinder.com/data/icons/large-glossy-icons/512/Spy.png\"/><style>
    *{
        outline: none;
    }
    #result{
        padding:5px ;
        margin-top: 5px;
        width: 99%;
        height: 89%;
        max-width: 99%;
        max-height: 89%;
        border-top: 1px  solid greenyellow;
        border-radius: 5px;
        overflow: auto;
    }
    pre{
        word-wrap: break-word;
        word-break: break-all;
        max-height: 93%;
        max-width: 99%;
        overflow: auto;
        border: transparent solid 1px;
    }
    form{
    }
    textarea{resize: none;}
    body{
        text-align: center;
        background-size: cover;
        background: url(\"http://fastpayads.s3.amazonaws.com/blog/wp-content/uploads/2016/02/Hackers.jpg\");
    }
    #query{
        background-color: black;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
        padding: 2px;
    }
    #number{
        background-color: black;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
        padding: 2px;
        max-width: 70px;
    }
    #runtime{
        display: inline;
        background-color: black;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
        padding: 2px;
        max-width: 70px;
    }
    #submit{
        background-color: black;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
        display: inline;
        padding: 3px;
    }
    fieldset{
        position: absolute;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
        text-align: center;
        background: black;
        width: 85%;
        height: 80%;
        max-width: 70%;
        max-height: 80%;
    }
    hr{
        line-height: 7px;
        display: block;
        color:transparent;
        border: none;
    }
    legend{
        text-align: center;
        margin-left: 32%;
    }
</style></head>
<body>
<fieldset>
    <legend>
        Tweeter Search Form
    </legend>
   <center><input placeholder=\"Keyword To search\" type=\"text\" name=\"query\" id=\"query\" />
            <input type='number' name='number' id='number' min='1' value='1'/>
            <input type='checkbox' name='runtime' id='runtime' value='1'/> runtime
        <input type=\"submit\" id=\"submit\" name=\"submit\" value=\"search\" onclick=\"post();\"/><label id='count'></label> <hr/></center>
    <div id=\"result\"><pre id=\"res\"></pre></div>
</fieldset>
<script>
    function dyn() {
                 var dx = '';
        var f = (function () {
                var data = document.getElementById(\"query\").value.split('\\n');
                var xhr = [];
                for (i = 0; i < data.length; i++) {
                    (function (i) {
                                var ln = document.getElementById(\"number\").value;
                                var checked = document.getElementById('runtime').checked;
                                var url = \"nom.php\";
                                xhr[i] = new XMLHttpRequest();
                                var vars = \"query=\" + data[i] + \"&number=\" + ln +\"&runtime=\"+checked.toString();
                                xhr[i].open(\"POST\", url, true);
                                xhr[i].setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded\");
                                xhr[i].onreadystatechange = function () {
                                    if (xhr[i].readyState == 4 && xhr[i].status == 200) {
                                        var return_data = JSON.parse(xhr[i].responseText.replace('\t',''));
                                        return_data.forEach(function (val) {
                                        var main = '=====NEW TWEET=====\\n';
                                        main += val.join(\"\\n\");
                                        main += '\\n=====End TWEET=====\\n';
                                        var s = val[1]+\"\\n\"+val[2]+\"\\n\"+val[3];
                                        if (dx.indexOf(s) < 0) {
                                         dx += main;
                                        }
                                        });
                                        if (document.getElementById(\"res\").innerHTML == 'Initializing') {
                                            document.getElementById(\"res\").innerHTML = '';
                                            document.getElementById(\"res\").innerHTML = dx;
                                        }
                                        else {
                                            document.getElementById(\"res\").innerHTML = dx;
                                        }
                                    }
                                };
                                xhr[i].send(vars);
                            }
                    )(i);
                }
            })();
        setTimeout('dyn()', 1000)
    }
    function post(){
        var dx = '';
        clearTimeout();
        clearInterval();
        document.getElementById(\"res\").innerHTML = 'Initializing';
        if (document.getElementById('runtime').checked == false){
            var f = (function () {
                var data = document.getElementById(\"query\").value.split('\\n');
                var xhr = [];
                for (i = 0; i < data.length; i++) {
                    (function (i) {
                                var ln = document.getElementById(\"number\").value;
                                var checked = document.getElementById('runtime').checked;
                                var url = \"nom.php\";
                                xhr[i] = new XMLHttpRequest();
                                var vars = \"query=\" + data[i] + \"&number=\" + ln +\"&runtime=\"+checked.toString();
                                xhr[i].open(\"POST\", url, true);
                                xhr[i].setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded\");
                                xhr[i].onreadystatechange = function () {
                                    if (xhr[i].readyState == 4 && xhr[i].status == 200) {
                                        var return_data = JSON.parse(xhr[i].responseText.replace('\t',''));
                                        return_data.forEach(function (val) {
                                        var main = '=====NEW TWEET=====\\n';
                                        main += val.join(\"\\n\");
                                        main += '\\n=====End TWEET=====\\n';
                                        var s = val[1]+\"\\n\"+val[2]+\"\\n\"+val[3];
                                        if (dx.indexOf(s) < 0) {
                                         dx += main;
                                        }
                                        });
                                        if (document.getElementById(\"res\").innerHTML == 'Initializing') {
                                            document.getElementById(\"res\").innerHTML = '';
                                            document.getElementById(\"res\").innerHTML = dx;
                                        }
                                        else {
                                            document.getElementById(\"res\").innerHTML = dx;
                                        }
                                    }
                                };
                                xhr[i].send(vars);
                            }
                    )(i);
                }
            })();
        }else{
            dyn();
        }
    }
</script><script>
    function center() {
        var f = document.getElementsByTagName('fieldset')[0],
                width = f.offsetWidth,
                dwidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
                height = f.offsetHeight,
                dheight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        if (f.style.left != Math.floor((dwidth-width)/2)) {
            f.style.left = Math.floor((dwidth - width) / 2);
            if (f.style.top != Math.floor((dheight - height) / 2)) {
                f.style.top = Math.floor((dheight - height) / 2);
                setTimeout(\"center()\", 200);
            }
            else {
                setTimeout(\"center()\", 200);
            }
        }
        else{
            if (f.style.top != Math.floor((dheight-height)/2)){
                f.style.top = Math.floor((dheight-height)/2);
                setTimeout(\"center()\", 200);}
            else{
                setTimeout(\"center()\", 200);
            }
            }
        }
    center();
</script></body>
</html>";
echo $data;

?>
