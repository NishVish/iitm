<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: #f5f7fb;
        font-family: Arial, Helvetica, sans-serif;
        color: #1f2937;
    }

    .company-form {
        width: 100%;
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px 50px;
    }

    .company-form>h2 {
        margin: 0 0 25px;
        font-size: 24px;
        color: #111827;
    }

    /* ================= SECTION ================= */

    .form-section {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .form-section h3 {
        margin: 0 0 20px;
        font-size: 18px;
        color: #111827;
    }

    /* ================= GRID ================= */

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .full {
        grid-column: 1 / -1;
    }

    /* ================= FORM ================= */

    .form-group {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .form-group label {
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .form-group label span {
        color: #dc2626;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 10px 12px;
        font-size: 14px;
        color: #111827;
        background: #fff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-group input {
        height: 42px;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 70px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    /* ================= CONTACT HEADER ================= */

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-header h3 {
        margin: 0;
    }

    .add-btn {
        border: 0;
        background: #2563eb;
        color: #fff;
        padding: 10px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .add-btn:hover {
        background: #1d4ed8;
    }

    /* ================= CONTACT ROW ================= */

    .contact-row {
        display: grid;
        grid-template-columns:
            minmax(0, 1fr) minmax(0, 1fr) minmax(0, 1fr) minmax(0, 1fr) 42px;

        gap: 12px;
        align-items: end;

        padding: 16px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;

        margin-bottom: 12px;
    }

    .contact-row:last-child {
        margin-bottom: 0;
    }

    .remove-btn {
        width: 42px;
        height: 42px;

        border: 0;
        border-radius: 6px;

        background: #fee2e2;
        color: #dc2626;

        font-size: 22px;
        line-height: 1;

        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;

        transition: background 0.2s;
    }

    .remove-btn:hover {
        background: #fecaca;
    }

    /* ================= ACTIONS ================= */

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .reset-btn,
    .save-btn {
        border: 0;
        border-radius: 6px;
        padding: 11px 22px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .reset-btn {
        background: #e5e7eb;
        color: #374151;
    }

    .reset-btn:hover {
        background: #d1d5db;
    }

    .save-btn {
        background: #16a34a;
        color: #fff;
    }

    .save-btn:hover {
        background: #15803d;
    }

    /* ================= TABLET ================= */

    @media (max-width: 900px) {
        .contact-row {
            grid-template-columns: repeat(2, minmax(0, 1fr)) 42px;
        }

        .contact-row .remove-btn {
            grid-column: 3;
            grid-row: 1 / 3;
            align-self: end;
        }
    }

    /* ================= MOBILE ================= */

    @media (max-width: 750px) {

        .company-form {
            margin: 20px auto;
            padding: 0 12px 30px;
        }

        .form-section {
            padding: 18px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .full {
            grid-column: auto;
        }

        .section-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .add-btn {
            width: 100%;
        }

        .contact-row {
            grid-template-columns: 1fr;
        }

        .contact-row .remove-btn {
            grid-column: auto;
            grid-row: auto;
            width: 100%;
        }

        .form-actions {
            flex-direction: column;
        }

        .reset-btn,
        .save-btn {
            width: 100%;
        }
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const container = document.getElementById('contactsContainer');
        const addContactBtn = document.getElementById('addContactBtn');

        let contactIndex = 1;

        /*
         * Add new contact
         */
        addContactBtn.addEventListener('click', function () {

            const contactRow = document.createElement('div');

            contactRow.className = 'contact-row';

            contactRow.innerHTML = `
                <div class="form-group">
                    <label>Contact Name</label>
                    <input
                        type="text"
                        name="contacts[${contactIndex}][name]"
                        placeholder="Contact name"
                    >
                </div>

                <div class="form-group">
                    <label>Designation</label>
                    <input
                        type="text"
                        name="contacts[${contactIndex}][designation]"
                        placeholder="Designation"
                    >
                </div>

                <div class="form-group">
                    <label>Mobile</label>
                    <input
                        type="tel"
                        name="contacts[${contactIndex}][mobile]"
                        placeholder="Mobile number"
                        maxlength="15"
                    >
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        name="contacts[${contactIndex}][email]"
                        placeholder="Email address"
                    >
                </div>

                <button
                    type="button"
                    class="remove-btn"
                    aria-label="Remove contact"
                >
                    ×
                </button>
            `;

            container.appendChild(contactRow);

            contactIndex++;
        });


        /*
         * Remove contact
         *
         * Event delegation is used so dynamically
         * added buttons also work.
         */
        container.addEventListener('click', function (event) {

            const removeButton = event.target.closest('.remove-btn');

            if (!removeButton) {
                return;
            }

            const contacts = container.querySelectorAll('.contact-row');

            if (contacts.length <= 1) {
                alert('At least one contact is required.');
                return;
            }

            const contactRow = removeButton.closest('.contact-row');

            if (contactRow) {
                contactRow.remove();
            }
        });


        /*
         * Reset form
         */
        document.getElementById('companyForm').addEventListener('reset', function () {

            setTimeout(function () {

                // Keep only the first contact row
                const contacts = container.querySelectorAll('.contact-row');

                contacts.forEach(function (contact, index) {
                    if (index > 0) {
                        contact.remove();
                    }
                });

                // Reset index for newly added contacts
                contactIndex = 1;

            }, 0);
        });

    });
</script>