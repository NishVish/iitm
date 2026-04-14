<!DOCTYPE html>
<html>

<head>
    <title>Blender Info</title>
</head>

<body>
    <h2>Blender System Check</h2>

    <p><b>OS:</b> {{ $result['os'] }}</p>
    <p><b>PHP Version:</b> {{ $result['php_version'] }}</p>

    <p><b>Blender Found:</b> {{ $result['blender_found'] ? 'Yes' : 'No' }}</p>

    @if($result['blender_found'])
        <p><b>Path:</b> {{ $result['blender_path'] }}</p>
        <p><b>Version:</b> {{ $result['blender_version'] }}</p>
    @else
        <p style="color:red;">{{ $result['error'] }}</p>
    @endif

</body>

</html>