<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
            name="description"
            content="SwaggerUI"
    />
    <title>SwaggerUI</title>
    <style>{!! file_get_contents($cssUi) !!}</style>
</head>
<body>
<div id="swagger-ui"></div>
<script> {!! file_get_contents($jsBundle) !!} </script>
<script> {!! file_get_contents($jsStandalone) !!} </script>
<script>
    window.onload = () => {
        window.ui = SwaggerUIBundle({
            url: '{{$url}}',
            dom_id: '#swagger-ui',
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            layout: "StandaloneLayout",
        });
    };
</script>
</body>
</html>
