<!DOCTYPE html>
<html>
<head>
    <title>WRecite - Forget</title>
    <link rel='stylesheet' href='/WRecite/css/common.css'/>
</head>
<body>
<table id="forget_word" class="word_table" border='1'>
</table>

<br /><br /><br />

<button onclick="dTable.start()">开始默写</button>
<button onclick="dTable.next()">下一个单词</button>
<button onclick="dTable.playWord()">重复</button>
<br />
<p id="recite_info"></p>
<table id="dictation_list" class="word_table" border="1">
</table>



<script type='text/javascript' src='http://cdn.iciba.com/web/js/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='/WRecite/js/common.js'></script>
<script>
    var words = <?=json_encode($words)?>;
    buildTable('forget_word', words);

    dTable = new DictationTable('dictation_list', shuffle(words), 'recite_info');
</script>
</body>