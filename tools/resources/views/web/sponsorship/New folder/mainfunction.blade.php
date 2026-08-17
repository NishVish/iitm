/* ── XSS-safe escaping ── */
function escHtml(str) {
return String(str)
.replace(/&/g, '&amp;')
.replace(/</g, '&lt;' ) .replace( />/g, '&gt;')
.replace(/"/g, '&quot;');
}

/* ── FETCH AND RENDER ── */
async function loadProspectus() {
try {

const url = "{{ url('sponsor-data') }}";

const res = await fetch(url, {
headers: {
'Accept': 'application/json'
}
});

console.log(res.data);
if (!res.ok) {
throw new Error(`Server returned HTTP ${res.status} (${res.statusText}). Check that the route "${url}" exists and is
accessible.`);
}

let result;
try {
result = await res.json();
} catch {
throw new Error(`Response from "${url}" is not valid JSON. Make sure the endpoint returns JSON, not HTML.`);
}

if (!result.success) {
throw new Error(`API returned success: false. Message: ${result.message || 'No message provided.'}`);
}

if (!Array.isArray(result.data) || result.data.length === 0) {
throw new Error('result.data is empty or not an array. Nothing to render.');
}

/* ── render pages ── */
statusBox.style.display = 'none';
const fragment = document.createDocumentFragment();

result.data.forEach((page, i) => {
try {
fragment.appendChild(buildPage(page));
} catch (pageErr) {
console.error(`[Prospectus] Error building page ${i}:`, pageErr, page);
}
});

pagesContainer.appendChild(fragment);

pdfBtn.disabled = false;
setStatus(`${result.data.length} page(s) loaded — ready to print`);

} catch (err) {
setError(err.message);
}
}

loadProspectus();