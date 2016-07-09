<!DOCTYPE html>
<html>
<head>
    <title>WRecite - tag</title>
    <style>
    body{
        padding: 10px 20px;
    }
    .hidden_word {
        color : #FFFFFF;
    }
    .interpretation {
        padding:3px 20px;
        line-height: 1.1;
    }
    </style>
    <link rel='stylesheet' href='/WRecite/css/common.css'/>
    <script type='text/javascript' src='http://cdn.iciba.com/web/js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='/WRecite/js/common.js'></script>

</head>
<body>
<form action="" method="post">
    <table style="margin:3px 10px;">
        <tr>
            <td>单词表</td>
            <td><?=$_GET['name']?></td>
        </tr>
        <tr>
            <td>单词数</td>
            <td><?=count($rows)?></td>
        </tr>
        <tr>
            <td style="padding-right:10px;">添加单词</td>
            <td><input type="text" name="word"  autocomplete="off"/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="submit" /></td>
        </tr>
    </table>
</form>
<br /><br />
<table border="1" id="word_list">
<?php foreach($rows as $row) {?>
    <tr>
    <td ><?=$row['word']?></td>
    <td class="interpretation"><?=$row['interpretation']?></td>
    <td>
        <i class="play_icon" onmouseover="playAudio('<?=$row['word']?>','uk');"></i> 英音
        &nbsp;&nbsp;&nbsp;
        <i class="play_icon" onmouseover="playAudio('<?=$row['word']?>','us');"></i> 美音
    </td>
    </tr>
<?php } ?>
</table>

<br /><br />
<br /><br />
<button onclick="start()">开始默写</button>
<button onclick="next()">下一个单词</button>
<button onclick="playWord()">重复</button>
<br />
<p id="recite_info"></p>
<table id="dictation_list" border="1">

</table>
<script>
var words = <?php
$words = array();
foreach($rows as $row) {
    $words[$row['word']] = $row['interpretation'];
}
echo json_encode($words);
?>;

function start() {
    $targetTable = $('#dictation_list');
    $targetTable.html('');
    var trs = $('#word_list tr td:first-child');
    var trs = shuffle(trs);
    var len = trs.length;
    for (i=0;i<len ;i++) {
        word = trs[i].textContent
        var trHtml = '<tr class="hidden_word"><td>' + (i+1) + '</td>';
        trHtml += '<td>' + word + '</td>';
        trHtml += '<td class="interpretation">' + words[word] + '</td>';
        trHtml += '<td>';
        trHtml += '<i class="play_icon" onmouseover="playAudio(\''+word + '\', \'uk\');"></i> 英音';
        trHtml += '&nbsp;&nbsp;&nbsp;';
        trHtml += '<i class="play_icon" onmouseover="playAudio(\''+word + '\', \'us\');"></i> 美音';
        trHtml += '</td></tr>';

        $targetTable.append(trHtml);
    }

   nowIndex = -1;
   $('#recite_info').html('');
}
var nowIndex = -1;
function next() {
    nowIndex++;
    playWord();
    var infoHtml = '当前序号' + (nowIndex+1) +'。';
    $('#dictation_list tr').eq(nowIndex).removeClass('hidden_word')
    $('#recite_info').html(infoHtml);

}
function playWord() {
    var tr = $('#dictation_list tr').get(nowIndex);
    var word = $(tr).children('td').eq(1).text();

    playAudio(word, 'us');
}

</script>
</body>
</html>