<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { width: 100%; height: 100%; overflow: hidden; background: #404040; }
        iframe { display: block; width: 100%; height: 100vh; border: none; }
    </style>
</head>
<body>
    <iframe src="{{ $fileUrl }}" title="{{ $title }}"></iframe>

    <script>
        const docTitle = {{ Js::from($title) }};

        // Force the title immediately and after any change
        document.title = docTitle;

        // MutationObserver watches for Chrome PDF viewer overriding the <title>
        const observer = new MutationObserver(() => {
            if (document.title !== docTitle) {
                document.title = docTitle;
            }
        });
        observer.observe(
            document.querySelector('title'),
            { childList: true, subtree: true, characterData: true }
        );

        // Belt-and-suspenders: also reset every 200ms for the first 5 seconds
        let count = 0;
        const interval = setInterval(() => {
            document.title = docTitle;
            if (++count >= 25) clearInterval(interval);
        }, 200);
    </script>
</body>
</html>
