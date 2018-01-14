<!DOCTYPE html>
<html>
<head>
    <title>WRecite</title>
    <script type='text/javascript' src='http://cdn.iciba.com/web/js/jquery-1.10.2.min.js'></script>
    <script type='text/javascript' src='/WRecite/js/common.js'></script>
    <style>
        body {
            margin:10px 20px;
        }
        #word_input {
            width:200px;
        }
        #word_table {
            margin-top: 10px;
        }
        #word_table td{
            padding:3px 5px;
        }
    </style>
    <link rel='stylesheet' href='/WRecite/css/common.css'/>

</head>
<body>
    <?php include(VIEW_PATH.'common/header.php');?>
    <form>
        <input type="text" id="word_input" /> <input type="submit">
    </form>

    <table border="1" id="word_table" >
        <?php foreach ($rows as $row) { ?>
            <tr>
            <td><?=$row['word']?></td>
            <td><?=$row['create_time']?></td>
            <td>
                <i class="play_icon" onmouseover="playAudio('<?=$row['word']?>','uk');"></i> 英音
                &nbsp;&nbsp;&nbsp;
                <i class="play_icon" onmouseover="playAudio('<?=$row['word']?>','us');"></i> 美音
            </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>


