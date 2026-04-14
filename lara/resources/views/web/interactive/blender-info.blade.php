<!DOCTYPE html>
<html>

<head>
    <title>Blender Info</title>
</head>

<body>

    <h1>Blender System Check</h1>

    <p><strong>OS:</strong> {{ $result['os'] }}</p>
    <p><strong>PHP Version:</strong> {{ $result['php_version'] }}</p>

    @if($result['blender_found'])
        <p style="color:green;"><strong>Blender Found:</strong> Yes</p>
        <p><strong>Path:</strong> {{ $result['blender_path'] }}</p>
        <pre>{{ $result['blender_version'] }}</pre>
    @else
        <p style="color:red;"><strong>Blender Found:</strong> No</p>
        <p>{{ $result['error'] }}</p>
    @endif

</body>

</html>