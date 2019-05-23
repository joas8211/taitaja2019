<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>RoboBisnes-hanke</title>

    <?php foreach ($scripts as $script): ?>
    <script
        <?= (isset($script['type']))
            ? 'type="' . htmlspecialchars($script['type']) . '"'
            : ''; ?>
        <?= isset($script['src'])
            ? 'src="' . htmlspecialchars($script['src']) . '"'
            : ''; ?>>
        <?= $script['content'] ?? ''; ?>
    </script>
    <?php endforeach; ?>
</head>
<body>
    <div id="app"></div>
</body>
</html>