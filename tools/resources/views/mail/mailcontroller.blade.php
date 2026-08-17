<td width="30%" valign="top" style="border:1px solid #ddd;padding:10px;">

    <form action="{{ url('/sendmail') }}" method="POST" onsubmit="return submitEditor()">
        @csrf

        <input type="text" name="name" placeholder="Name" style="width:100%;margin-bottom:10px;">
        <input type="email" name="email" placeholder="Email" style="width:100%;margin-bottom:10px;">

        <input type="hidden" name="body" id="body">

        <button type="submit" style="padding:10px 15px;background:#28a745;color:#fff;border:none;">
            Send Mail
        </button>
    </form>

</td>