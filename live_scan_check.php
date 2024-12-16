<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Scan ID Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        video {
            width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        button[type="button"], button[type="submit"] {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        button[type="button"]:hover, button[type="submit"]:hover {
            background-color: #005f79;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Live Scan ID Check</h1>
        <video id="scanner" autoplay></video>
        <form id="scanForm" action="process_scan.php" method="post">
            <button type="button" onclick="capture()">Scan ID</button>
            <input type="hidden" id="imageData" name="imageData" required>
            <button type="submit" id="submitButton" style="display:none;">Submit</button>
        </form>
    </div>

    <script>
        const scanner = document.getElementById('scanner');
        const imageDataInput = document.getElementById('imageData');
        const submitButton = document.getElementById('submitButton');

        async function capture() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                scanner.srcObject = stream;
                scanner.play();
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Error accessing camera. Please try again.');
            }
        }

        function stopCapture() {
            const stream = scanner.srcObject;
            const tracks = stream.getTracks();

            tracks.forEach(track => track.stop());
            scanner.srcObject = null;
        }

        async function takeSnapshot() {
            const canvas = document.createElement('canvas');
            canvas.width = scanner.videoWidth;
            canvas.height = scanner.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(scanner, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/jpeg');
            imageDataInput.value = dataURL;
            stopCapture();
            submitButton.click();
        }
    </script>
</body>
</html>
