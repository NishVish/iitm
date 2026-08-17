<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.10.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.10.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-identifycategory--nameofthecompany-">
                                <a href="#endpoints-GETapi-identifycategory--nameofthecompany-">GET api/identifycategory/{nameofthecompany}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-getAllCompanyData--mobileNumber-">
                                <a href="#endpoints-GETapi-getAllCompanyData--mobileNumber-">GET api/getAllCompanyData/{mobileNumber}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-">
                                <a href="#endpoints-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-">GET api/getLatestCompanyData/{mobileNumber}/{querylength}/{city}/{response}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-getLatestContactId--mobileNumber-">
                                <a href="#endpoints-GETapi-getLatestContactId--mobileNumber-">GET api/getLatestContactId/{mobileNumber}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-getDetails--mobileNumber-">
                                <a href="#endpoints-GETapi-getDetails--mobileNumber-">GET api/getDetails/{mobileNumber}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-events">
                                <a href="#endpoints-GETapi-events">GET api/events</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: May 27, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-identifycategory--nameofthecompany-">GET api/identifycategory/{nameofthecompany}</h2>

<p>
</p>



<span id="example-requests-GETapi-identifycategory--nameofthecompany-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/identifycategory/consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/identifycategory/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-identifycategory--nameofthecompany-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IlhFUTZxQXhkT0sxUC9hTG9LUjZsbEE9PSIsInZhbHVlIjoiZEx5cDlnUTlxSlYxOENwT1FwUklZdTRhQVB0NHBkQVRDbzRYdzNLWXhVRUpIbnh4UmNVOWNjQ3RLcDloeGM4MnB3eGRQZkxIYm84L2JMZ1gyVDkrOGJtS1NYVXhHcmgvSUY1TjhUY3hFRjhaSk83aTROT0NaeFNHc09NTFdtQU4iLCJtYWMiOiIxNmNkMTRjYjY4ODVlZmQ2MTk5NDI5ZTg1MGE2Y2E2YzU5M2RhYjU5ZGE3OTM0MTNhYmI3OTJlMGYzYjI2YzEyIiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:19 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6Im4wTTJoTDR1QlF3V082elRhMnNvMWc9PSIsInZhbHVlIjoiNStrVWNRWXh0ZXdUdVZxaTVVdlhPZlpYTjNaOHpqRWNVdTNjSlNlVm5CNy94QUNRWHZuQlFUZEhnb3lyQUdmMUoyVFNNaFNyZXc2Ynd1NWRobjQ2S2E5MDNpZFN0YXF5SGs4eWZQOEZFaWwrQTh0N2krYy9mdXN5NHBDYXIzMjkiLCJtYWMiOiI1MzRkZDRlOGQxYmIzOTMzZjgzZTExMzg2NTJjM2FlN2M4OGJmZWJiYTE4NjU2MzdlOWU5MDYwM2ExZGY0MzE1IiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:19 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: true,
    &quot;company_name&quot;: &quot;consequatur&quot;,
    &quot;category&quot;: &quot;Uncategorized&quot;,
    &quot;keyword&quot;: null
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-identifycategory--nameofthecompany-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-identifycategory--nameofthecompany-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-identifycategory--nameofthecompany-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-identifycategory--nameofthecompany-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-identifycategory--nameofthecompany-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-identifycategory--nameofthecompany-" data-method="GET"
      data-path="api/identifycategory/{nameofthecompany}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-identifycategory--nameofthecompany-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-identifycategory--nameofthecompany-"
                    onclick="tryItOut('GETapi-identifycategory--nameofthecompany-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-identifycategory--nameofthecompany-"
                    onclick="cancelTryOut('GETapi-identifycategory--nameofthecompany-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-identifycategory--nameofthecompany-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/identifycategory/{nameofthecompany}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-identifycategory--nameofthecompany-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-identifycategory--nameofthecompany-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>nameofthecompany</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="nameofthecompany"                data-endpoint="GETapi-identifycategory--nameofthecompany-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-getAllCompanyData--mobileNumber-">GET api/getAllCompanyData/{mobileNumber}</h2>

<p>
</p>



<span id="example-requests-GETapi-getAllCompanyData--mobileNumber-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/getAllCompanyData/consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/getAllCompanyData/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-getAllCompanyData--mobileNumber-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IkRJeExFcjhqZ1lTaHB2R2tlcWdzTlE9PSIsInZhbHVlIjoiMWdML1prUFd0cUZSem0wWVViZVJpdGl6MDFQTithYWVRVCs0VXZ5aXZzdmxlNFU4L2lmc3BsTWU1RldxbERQYmdYVFV2VkUrZERHSlg0VWtybDE4NDlBQko4Z0xiaUZDdVlTQXc1VXM0NXdkZG9HcjZKcUFQUmlrbnZvcjZhdmEiLCJtYWMiOiIwMTQ2MjZjZDU1N2Y1ZTY1Yjc1ZWQ0MWRjODU3NzExYjNlMTM2YjIwYjk0OWJhNjU1MWYxZTRhZGYxZmY5ZmJiIiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:19 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6IjNGRnRvVmJZdkV0WWRPY3lBNlY0OWc9PSIsInZhbHVlIjoiWWx2Z2JWd05NYUhKTWZ1cUJFelpSRUdnSXRJeW1rM2dFZk5RUjhPaVhEV1NzQnBlWkZraTE3cUpQZ0hQMEx2c3JIYnJPVDU5ZjMrbHZJd2JTcTlQTm1JL2VSVE4yRkprQ3l5Njd5SUVjRkRzRkMvTVBhQTh3cXVvY1lrR0lCaEYiLCJtYWMiOiI1Mzg0NzcyMzVhMDU3N2NhZDJmZTdjZmY4YmQ4NzIyZmQxZDNkNmFjMDQwZjdlNzA1NWY1MGU3YmIyOGIxMDczIiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:19 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;No data found&quot;,
    &quot;count&quot;: 0,
    &quot;data&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-getAllCompanyData--mobileNumber-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-getAllCompanyData--mobileNumber-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-getAllCompanyData--mobileNumber-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-getAllCompanyData--mobileNumber-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-getAllCompanyData--mobileNumber-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-getAllCompanyData--mobileNumber-" data-method="GET"
      data-path="api/getAllCompanyData/{mobileNumber}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-getAllCompanyData--mobileNumber-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-getAllCompanyData--mobileNumber-"
                    onclick="tryItOut('GETapi-getAllCompanyData--mobileNumber-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-getAllCompanyData--mobileNumber-"
                    onclick="cancelTryOut('GETapi-getAllCompanyData--mobileNumber-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-getAllCompanyData--mobileNumber-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/getAllCompanyData/{mobileNumber}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-getAllCompanyData--mobileNumber-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-getAllCompanyData--mobileNumber-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>mobileNumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="mobileNumber"                data-endpoint="GETapi-getAllCompanyData--mobileNumber-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-">GET api/getLatestCompanyData/{mobileNumber}/{querylength}/{city}/{response}</h2>

<p>
</p>



<span id="example-requests-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/getLatestCompanyData/consequatur/consequatur/consequatur/consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/getLatestCompanyData/consequatur/consequatur/consequatur/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6InRaWXNVT2NwQWMwQzdFNVMxSFJLbGc9PSIsInZhbHVlIjoiTkhjQ3NFQU42aGcvT2VBVWFuRzNnQzZGMngvSTNLSFNzdXo3YlRrVnU4NGlRWldIeXUzN0t3dUFFMTVBcUNUQXN3SnNseEpiWWdLZXhoZXA2U2N1OHVDUzlabWhsVGdYUjlSQlJxZTIvYmlpR1NEcjdscVZvdS9scnZHSkNEeVIiLCJtYWMiOiIxZjQ2OTA3OTA2ZjhlZjQ4Y2Q5N2E0MjE4ODU2ODNjMTAwYjMzOWM1ZTdiZmRjOTRiY2MzMDQ5MWVhZmEyOTU3IiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:19 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6IlhzTThnRkxNYmxFWHpvd2N4WnRiclE9PSIsInZhbHVlIjoiWGx2ME02c1Y2Y1RscDhFMm5TVUttQWF0N1JIcjJ5VUxIdzdGV1VmNzFHSWJiN0hKd2RTRTJwMnRKbFM3cVVZRHExbXpNVjJ6REo5eFd2aXFXRUZFWTBRN0QrQXUxUmJTaHZ6UEExS3BVNFdSdzE3M3B3OHc0bXh3Z1RuR3d3WFEiLCJtYWMiOiI3ODE2Yzg3YmI0MjAyMmQxOWZhYzBmZjY2NmM0ZmQyYWI5YmJiZDg3NWM3M2YxNWU5OWNjYmJiNDFhZTMwM2MxIiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:19 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;No data found&quot;,
    &quot;data&quot;: null
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-" data-method="GET"
      data-path="api/getLatestCompanyData/{mobileNumber}/{querylength}/{city}/{response}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
                    onclick="tryItOut('GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
                    onclick="cancelTryOut('GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/getLatestCompanyData/{mobileNumber}/{querylength}/{city}/{response}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>mobileNumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="mobileNumber"                data-endpoint="GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>querylength</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="querylength"                data-endpoint="GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>city</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="city"                data-endpoint="GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>response</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="response"                data-endpoint="GETapi-getLatestCompanyData--mobileNumber---querylength---city---response-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-getLatestContactId--mobileNumber-">GET api/getLatestContactId/{mobileNumber}</h2>

<p>
</p>



<span id="example-requests-GETapi-getLatestContactId--mobileNumber-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/getLatestContactId/consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/getLatestContactId/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-getLatestContactId--mobileNumber-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">content-type: text/html; charset=utf-8
cache-control: no-cache, private
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IlFqWWxqWjBQT3NScE5tZnhlaEhUVlE9PSIsInZhbHVlIjoieTF3T2J3M1gzb1JzZWR4NTlIeDNsb2NYYnVFelNUcm04M2s5d01VMC84em5KZVFvQWs2bFUzNjdGd2ZUblVqMlU1ajRoU1Y5eDE0UGVpa1dSR3hiWEc2ZlBDOW43ZWVkOHVLRU9Sb055eUJPc2MvREdnYjVWZi91ckhHTmZRaksiLCJtYWMiOiJhZWQzMzU0YmVlMzU5M2EzZTExYjMzMmVhYTNhMjljZjM1ZDFiNDkxYmFjYWE3MjUyOWJjZmIwZWNmMjdhNDE2IiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:19 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6IndoYmJVaEZSbEdUVmJjZHk1c3BnVGc9PSIsInZhbHVlIjoiclFkY1ozeTdGKzAyUjBVYU9aSkRiWWtjK1RVejlRUkpqZlY4b3VyQ3VycmU0VzlsSHE1cFNwcWtPOEpIMnE4RzU1NFEzTXlrckc5QVpxTXFwQUVBbEFJU2YreWVjWjNzVDNubXlkU0xXYlhQWVpadDFmT3o3M0JvZ2VWeDhSbSsiLCJtYWMiOiIwNWUxNDRmNjY1YTJmMmY0NDliNzcwMmEzZTljYWU0YmJkZjNhNjJkYWE2NjU4ZmYwNDRlNmVkZmVjZmRiMGI2IiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:19 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;"></code>
 </pre>
    </span>
<span id="execution-results-GETapi-getLatestContactId--mobileNumber-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-getLatestContactId--mobileNumber-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-getLatestContactId--mobileNumber-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-getLatestContactId--mobileNumber-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-getLatestContactId--mobileNumber-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-getLatestContactId--mobileNumber-" data-method="GET"
      data-path="api/getLatestContactId/{mobileNumber}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-getLatestContactId--mobileNumber-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-getLatestContactId--mobileNumber-"
                    onclick="tryItOut('GETapi-getLatestContactId--mobileNumber-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-getLatestContactId--mobileNumber-"
                    onclick="cancelTryOut('GETapi-getLatestContactId--mobileNumber-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-getLatestContactId--mobileNumber-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/getLatestContactId/{mobileNumber}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-getLatestContactId--mobileNumber-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-getLatestContactId--mobileNumber-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>mobileNumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="mobileNumber"                data-endpoint="GETapi-getLatestContactId--mobileNumber-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-getDetails--mobileNumber-">GET api/getDetails/{mobileNumber}</h2>

<p>
</p>



<span id="example-requests-GETapi-getDetails--mobileNumber-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/getDetails/consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/getDetails/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-getDetails--mobileNumber-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IlRrSHlJQnVqb2JBeXJxN2ZNamxkb0E9PSIsInZhbHVlIjoiK0FsTXVwUjU1U2VzYW5iQml1eW96QllEYkFmc2ZiUEh3bkhIV0JrVjZ2Nkd1NGVNV1NtVVFGREFKZ050RXhPeXBkdzd5b3FEbkU1ZkZReVRGMVNKR09COGtlWWlBRGFVMjlid3MvclF6a1NDOWorVGpicC9keXJDaEdSS0dtN28iLCJtYWMiOiIzMjI2Mjk0NmRjZWJiNjdmMWM3MjBhOWYxMGFhMTk0NmFiZTJiYjQyYzIxMmFkYjUxNWEwYWYwMzIzMzEyMGQzIiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:20 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6IjZZVnpSRGFmcWdJUHE1eWZ1NkFJRlE9PSIsInZhbHVlIjoiYVFaNk0vWFh1dzlWKzdtaE5xTTNZNjZsTURGSS9sSU5NZ3dNN0tvM2VpSExpb2ZDUGNxZGZ4TUduUGhIOTFQN2Vocmpnc3pEeVRBWTE3bVRGeU5KL1JlTnlTSXoxSExLYmFBdnRkcEEyOXFvL2tEcVhmblErUXFxaERXK3V1UEciLCJtYWMiOiI2NDBiOTJiN2E4ZDVkZTQ2YzAxZjliYmZjYWJmYTNiZGYyNWNhYzQ0YWU1MzcwNGE5YzFiOGRhYTIxYjY1MmU1IiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:20 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;mobile&quot;: null,
    &quot;contact&quot;: null,
    &quot;company&quot;: null,
    &quot;email&quot;: null,
    &quot;othercontacts&quot;: []
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-getDetails--mobileNumber-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-getDetails--mobileNumber-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-getDetails--mobileNumber-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-getDetails--mobileNumber-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-getDetails--mobileNumber-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-getDetails--mobileNumber-" data-method="GET"
      data-path="api/getDetails/{mobileNumber}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-getDetails--mobileNumber-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-getDetails--mobileNumber-"
                    onclick="tryItOut('GETapi-getDetails--mobileNumber-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-getDetails--mobileNumber-"
                    onclick="cancelTryOut('GETapi-getDetails--mobileNumber-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-getDetails--mobileNumber-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/getDetails/{mobileNumber}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-getDetails--mobileNumber-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-getDetails--mobileNumber-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>mobileNumber</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="mobileNumber"                data-endpoint="GETapi-getDetails--mobileNumber-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-events">GET api/events</h2>

<p>
</p>



<span id="example-requests-GETapi-events">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/events" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/events"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-events">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6ImptTnJGZGxyRjZEWjVGTGRMa3hYRHc9PSIsInZhbHVlIjoiQzBHOXF1dEtNZFNaUVNPQVFNTUFFK0Y4VGdEZDN1QkhoVlNlL1NZbHRkUlhPVU9wbm9Id2dKWnkwWExxSHFkU3V0UG9LMW5BaUk4THRrMlJQUm1Pd1Fmei9KbGRRRG0wa09Ha2JCSGhNbVYvNnpJdEloZmJDd3l3eTBQSGpEaDgiLCJtYWMiOiI3ODk1NDQ5MWY0MDEwZDllNWU4YmNmOTBmYjNkNWIyN2JiZTNmZjIzNWNkNzNhNDkxNmI4NWE2MWVhOWYzMjA4IiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:20 GMT; Max-Age=7200; path=/; samesite=lax; laravel-session=eyJpdiI6IlhhWllUZWM0RytBQnFoVGdZeitLRGc9PSIsInZhbHVlIjoiR3J1eHorWjdLTDJ4VTRObUczZ2Q1anpFQ2JINkN6cnU4bG9CRDBrMm5jeW13VkFCc2dOYnhwSVArNFUvblRsN0xYemJlWUR3bmJzZEliejErdXo2S2daLytkTWVUaHVmd3VxYlNWSWpJSWp2NTMxQmlUb3FzUTcwTitHZGlCMWgiLCJtYWMiOiIyMjFkZTk5YjliOTM3YTU2NTJmYjY2MjM4MTNkOTVkZDExODYyN2ZiNjEwNzNjMTA0Yzc2MWQ0YzAyNzFmZjY2IiwidGFnIjoiIn0%3D; expires=Wed, 27 May 2026 09:06:20 GMT; Max-Age=7200; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;event_id&quot;: 1,
        &quot;b2b_constrain&quot;: &quot;B2B-IITM&quot;,
        &quot;year&quot;: 2026,
        &quot;name&quot;: &quot;IITM Chennai&quot;,
        &quot;price&quot;: null,
        &quot;event_image&quot;: &quot;https://iitmindia.com/wp-content/uploads/2023/05/2-1-1.jpg&quot;,
        &quot;venue_details&quot;: &quot;Convention Center, Chennai Trade Center, CTC Complex, Nandambakkam, Chennai &ndash; 600089&quot;,
        &quot;venue_booking_details&quot;: &quot;Trade Visitor Registration&quot;,
        &quot;coordinator&quot;: &quot;&quot;,
        &quot;start_date&quot;: &quot;2026-07-16&quot;,
        &quot;end_date&quot;: &quot;2026-07-18&quot;,
        &quot;created_at&quot;: &quot;2026-04-24 11:07:13&quot;,
        &quot;updated_at&quot;: &quot;2026-04-24 16:21:30&quot;,
        &quot;active&quot;: 1,
        &quot;info&quot;: &quot;Chennai, formerly known as Madras, is the main business, commercial, and financial hub of southern India and one of the major cities in the country. It serves as the capital of the Indian state of Tamil Nadu and is home to a bustling port, an international airport, and several prestigious colleges and institutions that focus on providing a highly skilled workforce. The city&#039;s economic output, measured by gross domestic product, has been significant, and it ranks among the top cities in India. Chennai&#039;s strategic location on the eastern coast has made it a crucial port of communication for trade and commerce, and it plays a pivotal role in connecting the southern states with the rest of the country. Chennai has also emerged as a prominent IT hub, attracting various Indian and international software firms, making it a significant center for the IT industry in India. Companies like TCS, Infosys, Wipro, HCL Technologies, and others have established their presence in the city&#039;s vibrant IT sector. With the recent economic boom, Tamil Nadu, as a whole, has experienced substantial growth, and Chennai&#039;s economy has played a crucial role in contributing to the state&#039;s progress. In addition to its economic significance, Chennai also offers a platform for both B2B and B2C travel businesses and general visitors to explore the global travel community, products, services, and advancements in the industry. In summary, Chennai has emerged as a major economic and technological powerhouse in India, akin to Kolkata&#039;s position in eastern India. It has a strong IT sector, contributes significantly to the country&#039;s economy, and attracts businesses and institutions from around the world. The city&#039;s strategic location and thriving industries have cemented its status as a vital player in India&#039;s economic landscape.\r\n\r\nIITM CHENNAI is a platform for B2B and B2C travel businesses and general visitors to know about the global travel community, products, services, and advancements.&quot;
    },
    {
        &quot;event_id&quot;: 2,
        &quot;b2b_constrain&quot;: &quot;B2B-IITM&quot;,
        &quot;year&quot;: 2026,
        &quot;name&quot;: &quot;IITM Bengaluru&quot;,
        &quot;price&quot;: null,
        &quot;event_image&quot;: &quot;https://iitmindia.com/wp-content/uploads/2023/05/1-1-1.jpg&quot;,
        &quot;venue_details&quot;: &quot;Gate No-2, Tripura Vasini, Palace Ground, Bengaluru &ndash; 560006, Karnataka&quot;,
        &quot;venue_booking_details&quot;: &quot;Trade Visitor Registration&quot;,
        &quot;coordinator&quot;: &quot;&quot;,
        &quot;start_date&quot;: &quot;2026-07-23&quot;,
        &quot;end_date&quot;: &quot;2026-07-25&quot;,
        &quot;created_at&quot;: &quot;2026-04-24 11:07:13&quot;,
        &quot;updated_at&quot;: &quot;2026-05-14 14:30:50&quot;,
        &quot;active&quot;: 1,
        &quot;info&quot;: &quot;Bengaluru, also known as Bangalore, is the main business, commercial, and financial hub of southern India and one of the major cities in the country. It is home to a major international airport, numerous reputed colleges, and institutions that focus on providing a highly skilled workforce. The city has a thriving IT sector and is considered the technology capital of India. As of recent years, Bengaluru&#039;s economic output, measured by gross domestic product, has been significant and ranks among the top cities in India. It has attracted various Indian and international software firms, making it a prominent center for the IT industry in the country. Regarding the IT sector, prominent companies like Wipro, Infosys, TCS, Tech Mahindra, HCL Technologies, and others have established their operations in Bengaluru. The city&#039;s economy has experienced substantial growth, contributing to Karnataka state being one of the fastest-growing economies in India. Furthermore, Bengaluru serves as a key platform for both B2B and B2C travel businesses and general visitors, providing information about the global travel community, products, services, and advancements. In summary, Bengaluru has emerged as a significant economic and technological powerhouse in India, akin to Kolkata&#039;s position in eastern India. It has a robust IT sector, contributes significantly to the country&#039;s economy, and attracts various businesses and institutions from around the world.\r\n\r\nIITM BENGALURU is a platform for B2B and B2C travel businesses and general visitors to know about the global travel community, products, services, and advancements.\r\n\r\n&quot;
    },
    {
        &quot;event_id&quot;: 3,
        &quot;b2b_constrain&quot;: &quot;B2B-IITM&quot;,
        &quot;year&quot;: 2026,
        &quot;name&quot;: &quot;IITM Delhi NCR&quot;,
        &quot;price&quot;: null,
        &quot;event_image&quot;: &quot;https://iitmindia.com/wp-content/uploads/2023/05/1-1-1.jpg&quot;,
        &quot;venue_details&quot;: &quot;TBA&quot;,
        &quot;venue_booking_details&quot;: &quot;TBA&quot;,
        &quot;coordinator&quot;: &quot;&quot;,
        &quot;start_date&quot;: &quot;2026-09-24&quot;,
        &quot;end_date&quot;: &quot;2026-09-26&quot;,
        &quot;created_at&quot;: &quot;2026-04-24 11:07:13&quot;,
        &quot;updated_at&quot;: &quot;2026-04-24 16:21:30&quot;,
        &quot;active&quot;: 1,
        &quot;info&quot;: &quot;Delhi, the capital city of India, serves as the main business, commercial, and political hub of the nation. It holds immense significance as the administrative center of the country and hosts various government offices, embassies, and diplomatic missions. With a rich historical and cultural heritage, Delhi is home to iconic landmarks like the Red Fort, India Gate, and Qutub Minar, attracting tourists from around the world. As an economic powerhouse, Delhi&#039;s gross domestic product ranks among the highest in India. The city&#039;s diverse economy encompasses a wide range of industries, including finance, manufacturing, IT, tourism, and services. Delhi is well-connected by air, with an international airport catering to both domestic and international flights. Its extensive transportation network, comprising metro, buses, and other modes, facilitates smooth movement within the city. The IT sector in Delhi has seen substantial growth in recent years, with various Indian and international software companies establishing their presence in the city. This has contributed significantly to the city&#039;s economic prosperity and made it a prominent center for IT services. Furthermore, Delhi serves as a platform for businesses and general visitors to engage in B2B and B2C interactions, fostering collaboration and promoting advancements in various industries, including travel and tourism. In conclusion, Delhi holds a vital position in India&#039;s economic landscape and governance. It is a city of historical importance, a thriving economic hub, and a melting pot of diverse cultures, making it a dynamic metropolis and a key player in shaping the country&#039;s future.\r\n\r\nIITM DELHI is a platform for B2B and B2C travel businesses and general visitors to know about the global travel community, products, services, and advancements.&quot;
    },
    {
        &quot;event_id&quot;: 4,
        &quot;b2b_constrain&quot;: &quot;B2B-IITM&quot;,
        &quot;year&quot;: 2026,
        &quot;name&quot;: &quot;IITM Mumbai&quot;,
        &quot;price&quot;: null,
        &quot;event_image&quot;: &quot;https://iitmindia.com/wp-content/uploads/2023/05/4-1-1.jpg&quot;,
        &quot;venue_details&quot;: &quot;TBA&quot;,
        &quot;venue_booking_details&quot;: &quot;TBA&quot;,
        &quot;coordinator&quot;: &quot;&quot;,
        &quot;start_date&quot;: &quot;2026-10-29&quot;,
        &quot;end_date&quot;: &quot;2026-10-31&quot;,
        &quot;created_at&quot;: &quot;2026-04-24 11:07:13&quot;,
        &quot;updated_at&quot;: &quot;2026-04-24 16:21:30&quot;,
        &quot;active&quot;: 1,
        &quot;info&quot;: &quot;Mumbai, also known as Bombay, is the financial, commercial, and entertainment capital of India. As the largest city in the country, Mumbai holds immense significance and serves as a bustling metropolis with a diverse and vibrant population. The city&#039;s economic importance is unparalleled, and it is considered the financial hub of India. Mumbai houses the Reserve Bank of India, the Bombay Stock Exchange (BSE), and numerous major financial institutions and corporate headquarters. Its economy is diversified, with thriving industries such as finance, banking, IT, film, media, and entertainment. Mumbai&#039;s strategic location on the western coast has made it a major port and a crucial center for trade and commerce. It is well-connected by sea, air, and rail, and its Chhatrapati Shivaji Maharaj International Airport is one of the busiest airports in the country, facilitating both domestic and international travel. The city is renowned for its prolific film industry, Bollywood, which produces a vast number of movies each year, making Mumbai a major cultural hub and a center of artistic expression in India. Mumbai&#039;s skyline is adorned with iconic landmarks, including the Gateway of India, Marine Drive, and the Bandra-Worli Sea Link, making it a popular tourist destination. In addition to its economic and cultural significance, Mumbai is home to a diverse workforce, attracting people from various regions and communities, making it a melting pot of cultures and traditions. Overall, Mumbai&#039;s dynamic and fast-paced environment, coupled with its economic prowess and cultural diversity, has cemented its position as a key player in India&#039;s development and growth. It continues to be a city of opportunities, attracting individuals and businesses from all over the country and the world.\r\n\r\nIITM MUMBAI is a platform for B2B and B2C travel businesses and general visitors to know about the global travel community, products, services, and advancements.&quot;
    },
    {
        &quot;event_id&quot;: 5,
        &quot;b2b_constrain&quot;: &quot;B2B-IITM&quot;,
        &quot;year&quot;: 2026,
        &quot;name&quot;: &quot;IITM Pune&quot;,
        &quot;price&quot;: null,
        &quot;event_image&quot;: &quot;https://iitmindia.com/wp-content/uploads/2023/05/5-1-1.jpg&quot;,
        &quot;venue_details&quot;: &quot;TBA&quot;,
        &quot;venue_booking_details&quot;: &quot;Time 11:00 AM - 6:00 PM&quot;,
        &quot;coordinator&quot;: &quot;&quot;,
        &quot;start_date&quot;: &quot;2026-11-26&quot;,
        &quot;end_date&quot;: &quot;2026-11-28&quot;,
        &quot;created_at&quot;: &quot;2026-04-24 11:07:13&quot;,
        &quot;updated_at&quot;: &quot;2026-04-24 16:21:30&quot;,
        &quot;active&quot;: 1,
        &quot;info&quot;: &quot;Pune, often referred to as the \&quot;Oxford of the East,\&quot; is a major city in the state of Maharashtra, India. It holds significant importance as an educational, industrial, and cultural center. The city is renowned for its prestigious educational institutions, including universities, colleges, and research centers. Students from all over the country and even abroad come to Pune to pursue higher education, earning it the moniker \&quot;Oxford of the East.\&quot; Pune is also a thriving industrial hub with a diverse economy. It is home to various manufacturing industries, including automotive, information technology, and engineering. The Hinjewadi IT Park, located in Pune, is one of the largest IT hubs in India and houses numerous IT companies. The city&#039;s economy has experienced substantial growth, and its strategic location on the Deccan Plateau has contributed to its significance as a major trade and transportation center. Pune&#039;s rich history and cultural heritage are evident in its numerous historical monuments, temples, and landmarks. The Aga Khan Palace, Shaniwar Wada, and Sinhagad Fort are among the prominent historical sites that attract tourists and history enthusiasts. Additionally, Pune&#039;s pleasant climate, lush green surroundings, and vibrant cultural scene make it an attractive destination for residents and visitors alike. The city fosters a spirit of innovation and entrepreneurship, with a burgeoning startup ecosystem and a supportive environment for new businesses to flourish. In conclusion, Pune&#039;s blend of education, industry, culture, and history makes it a city of opportunities and a significant contributor to Maharashtra&#039;s growth and development. Its reputation as an educational and industrial hub continues to attract talent and investment, ensuring its position as a key player in India&#039;s progress.\r\n\r\nIITM PUNE is a platform for B2B and B2C travel businesses and general visitors to know about the global travel community, products, services, and advancements.\r\n\r\n&quot;
    },
    {
        &quot;event_id&quot;: 6,
        &quot;b2b_constrain&quot;: &quot;B2B-IITM&quot;,
        &quot;year&quot;: 2026,
        &quot;name&quot;: &quot;IITM Hyderabad&quot;,
        &quot;price&quot;: null,
        &quot;event_image&quot;: &quot;https://iitmindia.com/wp-content/uploads/2023/05/6-1-1.jpg&quot;,
        &quot;venue_details&quot;: &quot;TBA&quot;,
        &quot;venue_booking_details&quot;: &quot;Time 11:00 AM - 6:00 PM&quot;,
        &quot;coordinator&quot;: &quot;&quot;,
        &quot;start_date&quot;: &quot;2026-12-03&quot;,
        &quot;end_date&quot;: &quot;2026-12-05&quot;,
        &quot;created_at&quot;: &quot;2026-04-24 11:07:13&quot;,
        &quot;updated_at&quot;: &quot;2026-04-24 16:21:30&quot;,
        &quot;active&quot;: 1,
        &quot;info&quot;: &quot;Hyderabad, the capital city of the Indian state of Telangana, is a major center for technology, education, and culture in southern India. It is often referred to as \&quot;Cyberabad\&quot; due to its prominence in the IT and software industry. The city has a rich history and is known for its iconic landmarks such as the Charminar, Golconda Fort, and Qutb Shahi Tombs, reflecting its glorious past as a center of power and culture during the Qutb Shahi and Nizam periods. In recent years, Hyderabad has emerged as a prominent IT and technology hub, attracting numerous national and international software companies. The HITEC City (Hyderabad Information Technology and Engineering Consultancy City) is a major IT park that houses a plethora of IT and IT-enabled services companies, making it one of the largest IT clusters in India. The city&#039;s economic growth has been remarkable, and it has diversified industries including information technology, pharmaceuticals, biotechnology, manufacturing, and services. Hyderabad&#039;s strategic location, excellent infrastructure, and favorable business environment have contributed to its economic success. Hyderabad is also renowned for its world-class educational institutions and research centers. The city&#039;s universities and colleges attract students from across the country and the globe, making it an important center for education and research. Culturally, Hyderabad is known for its rich traditions, cuisine, and arts. The city&#039;s unique blend of traditions from different regions is reflected in its festivals, music, and dance forms. Additionally, Hyderabad&#039;s growing reputation as a tourist destination is evident from its vibrant markets, modern shopping malls, and culinary delights. In conclusion, Hyderabad&#039;s rapid development in technology, education, and culture has propelled it to the forefront of India&#039;s cities. Its strong presence in the IT industry, coupled with its historical charm and cultural heritage, make it a unique and dynamic metropolis, contributing significantly to the growth and progress of the country.\r\n\r\nIITM HYDERABAD is a platform for B2B and B2C travel businesses and general visitors to know about the global travel community, products, services, and advancements.&quot;
    },
    {
        &quot;event_id&quot;: 7,
        &quot;b2b_constrain&quot;: &quot;B2B-IITM&quot;,
        &quot;year&quot;: 2027,
        &quot;name&quot;: &quot;IITM Kochi&quot;,
        &quot;price&quot;: null,
        &quot;event_image&quot;: &quot;https://iitmindia.com/wp-content/uploads/2023/05/7-1-1.jpg&quot;,
        &quot;venue_details&quot;: &quot;TBA&quot;,
        &quot;venue_booking_details&quot;: &quot;Time 11:00 AM - 6:00 PM&quot;,
        &quot;coordinator&quot;: &quot;&quot;,
        &quot;start_date&quot;: &quot;2027-01-07&quot;,
        &quot;end_date&quot;: &quot;2027-01-09&quot;,
        &quot;created_at&quot;: &quot;2026-04-24 11:07:13&quot;,
        &quot;updated_at&quot;: &quot;2026-04-24 16:21:30&quot;,
        &quot;active&quot;: 1,
        &quot;info&quot;: &quot;Kochi, also known as Cochin, is a vibrant port city located in the state of Kerala, India. It is situated along the southwest coast and holds immense historical, economic, and cultural significance.As a major port city, Kochi has been a crucial center for trade and commerce for centuries. Its strategic location on the Arabian Sea has facilitated maritime trade and attracted merchants and traders from various parts of the world. Even today, the Port of Kochi remains an important hub for international trade.Kochi&#039;s rich history is evident in its colonial architecture, ancient landmarks, and cultural heritage. The city has been influenced by various civilizations, including the Portuguese, Dutch, and British, which is reflected in its diverse architecture and cultural practices. The city&#039;s economy is diverse and dynamic. While trade and fishing remain important industries, Kochi has also embraced modernization and developed into a significant commercial and business hub. The Information Technology Park in Kochi (Infopark) is a prime example of the city&#039;s foray into the IT sector, attracting IT companies and contributing to the growth of the technology industry in Kerala. Kochi is a popular tourist destination, drawing visitors with its scenic backwaters, beautiful beaches, and historical landmarks. The Chinese fishing nets at Fort Kochi, Mattancherry Palace, and the Jewish Synagogue are some of the attractions that showcase the city&#039;s cultural heritage. Culturally, Kochi is a melting pot of various communities, and festivals like Onam and Vishu are celebrated with great enthusiasm and fervor. The city&#039;s friendly and welcoming atmosphere, along with its rich cultural tapestry, makes it an attractive place to live, work, and visit. In conclusion, Kochi&#039;s blend of history, trade, technology, and culture has made it a dynamic and significant city in southern India. Its vibrant economy, diverse culture, and beautiful landscapes continue to draw people from different parts of the world, contributing to its growth and prosperity.\r\n\r\nIITM KOCHI is a platform for B2B and B2C travel businesses and general visitors to know about the global travel community, products, services, and advancements.&quot;
    },
    {
        &quot;event_id&quot;: 8,
        &quot;b2b_constrain&quot;: &quot;B2B-IITM&quot;,
        &quot;year&quot;: 2027,
        &quot;name&quot;: &quot;IITM Kolkata&quot;,
        &quot;price&quot;: null,
        &quot;event_image&quot;: &quot;https://iitmindia.com/wp-content/uploads/2023/05/8-1-1.jpg&quot;,
        &quot;venue_details&quot;: &quot;TBA&quot;,
        &quot;venue_booking_details&quot;: &quot;Time 11:00 AM - 6:00 PM&quot;,
        &quot;coordinator&quot;: &quot;&quot;,
        &quot;start_date&quot;: &quot;2027-02-18&quot;,
        &quot;end_date&quot;: &quot;2027-02-19&quot;,
        &quot;created_at&quot;: &quot;2026-04-24 11:07:13&quot;,
        &quot;updated_at&quot;: &quot;2026-04-24 16:21:30&quot;,
        &quot;active&quot;: 1,
        &quot;info&quot;: &quot;Kolkata is the main business, commercial and financial hub of eastern India and the main port of communication for the North-East Indian states. Kolkata is home to a major port, an international airport and many nationally and internationally reputed colleges and Institutions aimed at supplying a highly skilled workforce. According to a Price water house Cooper&rsquo;s report, as of 2009, Kolkata&rsquo;s economic output as measured by gross domestic product as 104 US dollars, and ranks third among South Asian cities, behind Mumbai and Delhi. However, As of 2010, Kolkata, with an estimated Gross domestic product (GDP) by purchasing power parity of 150 billion dollars, ranked third among South Asian cities, after Mumbai and Delhi.\r\n\r\nIITM Kolkata is a platform for B2B and B2C travel businesses and general visitors to know about the global travel community, products, services, and advancements.&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-events" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-events"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-events"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-events" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-events">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-events" data-method="GET"
      data-path="api/events"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-events', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-events"
                    onclick="tryItOut('GETapi-events');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-events"
                    onclick="cancelTryOut('GETapi-events');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-events"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/events</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-events"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-events"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
