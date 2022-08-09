<!DOCTYPE html>
<html>
<head>
    <title>ItsolutionStuff.com</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $body }}</p>

    <p>Thank you</p>
    <script src="/js/qrcode.min.js"></script>
    <div id="qrcode"></div>
    <button id="download"><a target="_blank" href="https://reschoolecology.tech">Login</a></button>

    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "email",
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
        $("#download").click(
            function() {
                var pdf = new jsPDF({
                    orientation: "landscape",
                    unit: "mm",
                    format: [84, 40]
                });

                pdf.setFontSize(15);
                pdf.text('CraveCookie', 43, 20);

                pdf.setFontSize(10);
                pdf.text('Scan For Menu', 43, 25);

                let base64Image = $('#qr_code img').attr('src');
                console.log(base64Image);

                pdf.addImage(base64Image, 'png', 0, 0, 40, 40);
                pdf.save('generated.pdf');
            }
        ); </script>
            <br/>

            <h1>jj</h1>
</body>
</html>
