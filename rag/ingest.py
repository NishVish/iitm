import requests
from bs4 import BeautifulSoup
import chromadb
import ollama

URL = "https://iitmindia.com"

response = requests.get(URL)
soup = BeautifulSoup(response.text, "html.parser")

text = soup.get_text(separator=" ", strip=True)

# Chunking
chunk_size = 1000
chunks = [
    text[i:i + chunk_size]
    for i in range(0, len(text), chunk_size)
]

client = chromadb.PersistentClient(path="./chroma_db")

collection = client.get_or_create_collection(
    name="iitm_docs"
)

for idx, chunk in enumerate(chunks):

    embedding = ollama.embeddings(
        model="nomic-embed-text",
        prompt=chunk
    )["embedding"]

    collection.add(
        ids=[str(idx)],
        embeddings=[embedding],
        documents=[chunk]
    )

print("IITMIndia.com indexed successfully")