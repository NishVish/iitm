<?php
$host = '21.157.66.148.host.secureserver.net';
$port = 3306;
$user = 'iitminda_master';
$password = 'gB)%gU}ocn?MCP=}';
$database = 'iitminda_form_data';

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sqlQuery = "SELECT *
FROM (
    SELECT id, company_name, name, mobile
    FROM exhibitor
    ORDER BY id desc
    LIMIT 10
) AS bottom_10
ORDER BY id asc;
";
$visitorResult = mysqli_query($conn, $sqlQuery);

if (mysqli_num_rows($visitorResult) > 0) {
    while ($visitorRow = mysqli_fetch_assoc($visitorResult)) {
        // echo "<div><strong>{$visitorRow['company_name']}</strong> - {$visitorRow['name']} - {$visitorRow['mobile']}</div>";
echo "
<div style='
  display:flex;
  font-family: Arial, sans-serif;
  font-weight: 100;
  color: #222;
  margin: 6px 0;
  align-items: center;
  background: #f9fafb;
  padding: 2px;
  border-radius: 4px;
'>
  <div style='flex:2; color:#111;'>{$visitorRow['name']}</div>
  <div style='flex:2; color:#111;'>{$visitorRow['mobile']}</div>
  <div style='flex:2;'>
    <form method='POST' action='' style='margin:0; display:flex; justify-content:center;'>
      <input type='hidden' name='mobile' value='{$visitorRow['mobile']}' required>
      <button type='submit' style='
        padding: 3px 6px;
        background-color: #3b82f6;
        border: none;
        border-radius: 3px;
        color: white;
        cursor: pointer;
        font-weight: 300;
        transition: background-color 0.3s ease;
      ' onmouseover=\"this.style.backgroundColor='#2563eb'\" onmouseout=\"this.style.backgroundColor='#3b82f6'\">
        Replace
      </button>
    </form>
  </div>
</div>
";

    }

} else {
    echo "No visitors found.";
}

mysqli_close($conn);
?>
