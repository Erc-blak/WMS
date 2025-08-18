<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barcode Scanner</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Barcode Scanner</h1>
    <p><a href="/inventory">← Back to Inventory</a></p>

    <div id="video-container" style="width: 100%; max-width: 400px; margin: 0 auto;">
        <video id="video" style="width: 100%; display: block;"></video>
    </div>
    <div id="result" style="text-align: center; margin-top: 20px;">
        <p>Point your camera at a barcode to scan.</p>
    </div>

    <script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
    <script type="text/javascript">
        window.addEventListener('load', function () {
            const codeReader = new ZXing.BrowserMultiFormatReader();
            const videoElement = document.getElementById('video');

            codeReader.listVideoInputDevices()
                .then((videoInputDevices) => {
                    const selectedDeviceId = videoInputDevices[0].deviceId;
                    
                    codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
                        if (result) {
                            console.log(result);
                            document.getElementById('result').textContent = 'Found Barcode: ' + result.text;
                            
                            // Immediately look up the scanned SKU
                            fetch('/inventory/get-by-sku/' + result.text)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        document.getElementById('result').innerHTML = `
                                            <p>Scanned successfully! Item found:</p>
                                            <p><strong>SKU:</strong> ${data.data.sku}</p>
                                            <p><strong>Name:</strong> ${data.data.name}</p>
                                            <p><strong>Quantity:</strong> ${data.data.quantity}</p>
                                            <p><strong>Location:</strong> ${data.data.location}</p>
                                            <p><a href="/inventory/details/${data.data.id}">View Details Page</a></p>
                                        `;
                                        codeReader.reset();
                                    } else {
                                        document.getElementById('result').innerHTML = `<p style="color:red;">Error: ${data.message}</p>`;
                                    }
                                });
                        }
                    });
                })
                .catch((err) => {
                    console.error(err);
                    document.getElementById('result').innerHTML = `<p style="color:red;">Error accessing the camera: ${err.message}</p>`;
                });
        });
    </script>
</body>
</html>