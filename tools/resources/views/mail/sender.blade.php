<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>

        <td width="70%" valign="top" style="border:1px solid #ddd;padding:10px;">

            <h4>Templates</h4>

            <ul>
                <li><a href="http://localhost/iitm/lara/sender/buy">Buy Template</a></li>
                <li><a href="http://localhost/iitm/lara/sender/visit">Visit Template</a></li>
            </ul>

            <hr>

            <div id="editor" style="height:300px;background:#fff;"></div>

        </td>

        <td width="30%" valign="top" style="border:1px solid #ddd;padding:10px;">

            <form action="http://localhost/iitm/lara/sendmail" method="POST" onsubmit="return submitEditor()">
                <input type="hidden" name="_token" value="9KSVuQLmxAVE2caps9UfR3Aox5lNDvG9X6mu3utg" autocomplete="off">
                <input type="text" name="name" placeholder="Name" style="width:100%;margin-bottom:10px;">
                <input type="email" name="email" placeholder="Email" style="width:100%;margin-bottom:10px;">

                <input type="hidden" name="body" id="body">

                <button type="submit" style="padding:10px 15px;background:#28a745;color:#fff;border:none;">
                    Send Mail
                </button>
            </form>

        </td>

    </tr>
</table>

<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    quill.clipboard.dangerouslyPasteHTML("0");

    function submitEditor() {
        document.getElementById("body").value = quill.root.innerHTML;
        return true;
    }
</script>