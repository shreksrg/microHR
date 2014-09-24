<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>

<script>
    <?php if ($result == 'ok') { ?>
    window.parent.submit();
    <?php } elseif ($result == 'fail') { ?>
    window.parent.error();
    <?php }?>
</script>

<body>

</body>
</html>