<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>

<script>
    alert('<?=$code?>');
    <?php if ($result == 'ok') { ?>
    //window.parent.submit();
    <?php } elseif ($result == 'fail') { ?>
   // window.parent.error();
    <?php }?>
</script>

<body>
<h1>hello,yanzheng</h1>
</body>
</html>