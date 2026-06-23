import pandas as pd

file_path = "companies_with_websites.xlsx"
df = pd.read_excel(file_path)

def section(title):
    print("\n" + "=" * 60)
    print(title)
    print("=" * 60 + "\n")

section("DATASET OVERVIEW")
print(f"Rows: {df.shape[0]}")
print(f"Columns: {df.shape[1]}")
print(f"Memory usage: {df.memory_usage(deep=True).sum() / 1024:.2f} KB")

section("COLUMN SUMMARY")
summary = pd.DataFrame({
    "dtype": df.dtypes,
    "missing": df.isna().sum(),
    "missing_%": (df.isna().sum() / len(df) * 100).round(2),
    "unique": df.nunique()
})
print(summary.sort_values("missing_%", ascending=False))

section("DATA QUALITY CHECK")

df["website_str"] = df["website"].astype(str)

quality = {
    "duplicate_rows": df.duplicated().sum(),
    "duplicate_ids": df["id"].duplicated().sum(),
    "empty_websites": df["website"].isna().sum(),
    "empty_countries": df["country"].isna().sum(),
}

for k, v in quality.items():
    print(f"{k}: {v}")

section("COUNTRY DISTRIBUTION (TOP 15)")
print(df["country"].value_counts(dropna=False).head(15))

section("WEBSITE INSIGHTS")
non_null_websites = df["website"].dropna()

print(f"Total websites: {len(non_null_websites)}")

# basic patterns
print("Contains http(s):", non_null_websites.astype(str).str.contains("http").sum())
print("Contains www:", non_null_websites.astype(str).str.contains("www").sum())
print("Missing domain dot:", (~non_null_websites.astype(str).str.contains(r"\.")).sum())

section("SAMPLE RECORDS")
print(df.sample(10).to_string(index=False))

section("MOST COMPLETE RECORDS")
df["completeness"] = df.notna().sum(axis=1)
print(df.sort_values("completeness", ascending=False).head(10)[["id", "name", "country", "website"]])