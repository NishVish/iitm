<form id="mobileForm">
    <input type="text" id="mobile" value="7909075195" placeholder="Mobile">
    <button type="submit">Get Details</button>
</form>

<br>

<div id="formContainer"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $("#mobileForm").submit(function (e) {
        e.preventDefault();

        let mobile = $("#mobile").val();

        $.ajax({
            url: "<?= url('searchlead/') ?>" + '/' + mobile,
            type: "GET",
            dataType: "json",
            success: function (res) {

                let container = document.getElementById("formContainer");
                container.innerHTML = "";

                // ✅ REAL FORM (POST)
                let form = document.createElement("form");
                form.method = "POST";
                form.action = "<?= url('details/update') ?>";

                // CSRF (Laravel)
                let csrf = document.createElement("input");
                csrf.type = "hidden";
                csrf.name = "_token";
                csrf.value = "<?= csrf_token() ?>";
                form.appendChild(csrf);

                function addFields(obj, prefix = "") {
                    for (let key in obj) {

                        if (obj[key] !== null && typeof obj[key] === "object") {
                            addFields(obj[key], prefix + key + ".");
                        } else {

                            let wrapper = document.createElement("div");

                            let label = document.createElement("label");
                            label.innerText = prefix + key;

                            let input = document.createElement("input");
                            input.type = "text";
                            input.name = prefix + key;
                            input.value = obj[key] ?? "";

                            wrapper.appendChild(label);
                            wrapper.appendChild(input);

                            form.appendChild(wrapper);
                        }
                    }
                }

                addFields(res);

                // ✅ SUBMIT BUTTON (REAL POST)
                let btn = document.createElement("button");
                btn.type = "submit";
                btn.innerText = "Update";

                form.appendChild(btn);

                container.appendChild(form);
            }
        });
    });
</script>