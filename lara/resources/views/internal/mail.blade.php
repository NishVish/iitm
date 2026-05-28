<form action="/send-email" method="post">

    <label>To:</label>
    <input type="email" name="to" required>

    <label>From:</label>
    <input type="email" name="from" required>

    <label>Subject:</label>
    <input type="text" name="subject">

    <label>Message:</label>
    <textarea name="message"></textarea>

    <label>Format:</label>
    <select name="format">
        <option value="text">Text</option>
        <option value="html">HTML</option>
    </select>

    <button type="submit">Send Email</button>
</form>