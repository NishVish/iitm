import pandas as pd

file_path = "companies.xlsx"
df = pd.read_excel(file_path, sheet_name="Main")

# Fill strings with '', numbers with 0
df = df.fillna({col: '' for col in df.select_dtypes(include='object').columns})
df = df.fillna({col: 0 for col in df.select_dtypes(include='number').columns})

# Optional: rename columns to match your form fields if necessary
# df.columns = df.columns.str.strip().str.lower().str.replace(" ", "_")

# -----------------------------
# 2. Setup session
# -----------------------------
session = requests.Session()
form_url = "http://localhost/iitm/central/company/add"  # replace with actual URL

# Get CSRF token from form
r = session.get(form_url)
soup = BeautifulSoup(r.text, 'html.parser')
csrf_input = soup.find('input', {'name': 'csrf_test_name'})  # adjust name if different
csrf_token = csrf_input['value']

# -----------------------------
# 3. Submit rows one by one
# -----------------------------
success_count = 0
fail_count = 0

for index, row in df.iterrows():
    # Map Excel columns to form fields
    data = {
        'companies[0][database_name]': row.get('database_name', ''),
        'companies[0][category]': row.get('category', ''),
        'companies[0][source]': row.get('source', ''),
        'companies[0][updated_by]': row.get('updated_by', ''),
        'companies[0][updated_at]': row.get('updated_at', ''),
        'companies[0][comments]': row.get('comments', ''),
        'companies[0][outbound]': '1' if row.get('outbound', '') else '',
        'companies[0][company_name]': row.get('company_name', ''),
        'companies[0][address_1]': row.get('address_1', ''),
        'companies[0][address_2]': row.get('address_2', ''),
        'companies[0][city]': row.get('city', ''),
        'companies[0][pincode]': row.get('pincode', ''),
        'companies[0][state]': row.get('state', ''),
        'companies[0][phone]': row.get('phone', ''),
        'companies[0][fax]': row.get('fax', ''),
        'companies[0][contact1_name]': row.get('contact1_name', ''),
        'companies[0][contact1_designation]': row.get('contact1_designation', ''),
        'companies[0][contact1_mobile1]': row.get('contact1_mobile1', ''),
        'companies[0][contact1_mobile2]': row.get('contact1_mobile2', ''),
        'companies[0][contact1_mobile3]': row.get('contact1_mobile3', ''),
        'companies[0][contact1_email1]': row.get('contact1_email1', ''),
        'companies[0][contact1_email2]': row.get('contact1_email2', ''),
        'companies[0][contact1_email3]': row.get('contact1_email3', ''),
        'companies[0][contact2_name]': row.get('contact2_name', ''),
        'companies[0][contact2_designation]': row.get('contact2_designation', ''),
        'companies[0][contact2_email1]': row.get('contact2_email1', ''),
        'companies[0][contact2_email2]': row.get('contact2_email2', ''),
        'companies[0][contact2_mobile1]': row.get('contact2_mobile1', ''),
        'companies[0][contact2_mobile2]': row.get('contact2_mobile2', ''),
        'companies[0][contact3_name]': row.get('contact3_name', ''),
        'companies[0][contact3_designation]': row.get('contact3_designation', ''),
        'companies[0][contact3_email1]': row.get('contact3_email1', ''),
        'companies[0][contact3_email2]': row.get('contact3_email2', ''),
        'companies[0][contact3_mobile1]': row.get('contact3_mobile1', ''),
        'companies[0][contact3_mobile2]': row.get('contact3_mobile2', ''),
        'csrf_test_name': csrf_token,
    }

    # Send POST request
    try:
        resp = session.post(form_url, data=data)
        if resp.status_code == 200:
            success_count += 1
        else:
            print(f"Row {index+1} failed with status {resp.status_code}")
            fail_count += 1
    except Exception as e:
        print(f"Row {index+1} exception: {e}")
        fail_count += 1

    # Optional: slow down to avoid server overload
    time.sleep(0.1)  # 100ms between requests

print(f"Finished! Success: {success_count}, Failed: {fail_count}")