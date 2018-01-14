<!DOCTYPE html>
<html>
<head>
    <title>WRecite - tag</title>
    <link rel='stylesheet' href='/WRecite/css/common.css'/>

</head>
<body>
<?php include(VIEW_PATH.'common/header.php');?>

<form action="" method="post">
    <table style="margin:3px 10px;" >
        <tr>
            <td>单词表</td>
            <td><?=$_GET['name']?>&nbsp;&nbsp;(<?=$taginfo['id']?>)</td>
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
<table border="1" id="word_list" class="word_table">
</table>

<br /><br />
<br /><br />
<button onclick="dTable.start();">开始默写</button>
<button onclick="dTable.next()">下一个单词</button>
<button onclick="dTable.playWord()">重复</button>
<br />
<p id="recite_info"></p>
<table id="dictation_list" border="1" class="word_table">

</table>
<script type='text/javascript' src='/WRecite/js/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='/WRecite/js/common.js'></script>
<script>
var words = <?=json_encode($words)?>;
buildTable('word_list', words);

dTable = new DictationTable('dictation_list', shuffle(words), 'recite_info');
</script>
</body>
</html>