<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tayangan Seputar BPS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite('resources/css/player.css')
</head>
<body>

<div id="player"></div>

<button id="btnStop"
    style="position:fixed;top:10px;right:10px;z-index:999">
    ⏹ STOP
</button>

<script>
    window.PLAYLIST = @json($contents ?? []);
</script>

@vite('resources/js/player.js')

</body>
</html>
