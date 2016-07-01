<!DOCTYPE html>
<html>
<head>
    <title>WRecite - tag</title>
    <style>
    body{
        padding: 10px 20px;
    }
    </style>
    <link rel='stylesheet' href='/WRecite/css/common.css'/>
    <script type='text/javascript' src='http://cdn.iciba.com/web/js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='/WRecite/js/common.js'></script>

</head>
<body>
<form action="" method="post">
    <table>
        <tr>
            <td>单词</td>
            <td><input type="text" name="word" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" /></td>
        </tr>
    </table>
</form>

<table border="1" id="word_list">
<?php foreach($rows as $row) {?>
    <tr>
    <td ><?=$row['word']?></td>
    <td>
        <i class="play_icon" onmouseover="playAudio('<?=$row['word']?>','uk');"></i> 英音
        &nbsp;&nbsp;&nbsp;
        <i class="play_icon" onmouseover="playAudio('<?=$row['word']?>','us');"></i> 美音
    </td>
    </tr>
<?php } ?>
</table>

<br /><br />
<button onclick="start()">开始默写</button>
<button onclick="next()">下一个单词</button>
<button onclick="playWord()">重复</button>
<br />
<table id="dictation_list" border="1">

</table>
<script>
function start() {
    $targetTable = $('#dictation_list');
    $targetTable.html('');
    var trs = $('#word_list tr');
    var trs = shuffle(trs);
    var len = trs.length;
    for (i=0;i<len ;i++) {
        tr = $(trs[i]).clone();
        tr.prepend('<td>'+(i+1)+'</td>');
        $targetTable.append(tr);
    }
    /*
    for (i=0; i<len; i++) {
        tr = $(trs[i]);
        word = tr.children('td').first().text();
        confirm('下一个');
        playAudio(word, 'us');
    }
    */
   nowIndex = -1;
}
var nowIndex = -1;
function next() {
    nowIndex++;
    playWord()
}
function playWord() {
    var tr = $('#dictation_list tr').get(nowIndex);
    var word = $(tr).children('td').eq(1).text();

    playAudio(word, 'us');   
}

</script>
</body>
</html>