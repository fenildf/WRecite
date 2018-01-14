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
    <table border="1" id="word_table" >
        <?php foreach ($tags as $row) { ?>
            <tr>
            <td><a href="/WRecite/word/tag?name=<?=$row['name']?>"><?=$row['id']?></a></td>
            <td><a href="/WRecite/word/tag?name=<?=$row['name']?>"><?=$row['name']?></a></td>
            <td><?=$row['create_time']?></td>
            </tr>
        <?php } ?>
    </table>
    <br /><br />
    <form action="" method="POST">
        <input type="text" name="name"  autocomplete="off"/></td>
        <input type="submit" value='添加'>
    </form>
</body>
</html>