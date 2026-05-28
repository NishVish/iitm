from fastapi import FastAPI
from pydantic import BaseModel
import chromadb
import ollama

app = FastAPI()

client = chromadb.PersistentClient(path="./chroma_db")

collection = client.get_collection(
    name="iitm_docs"
)

class AskRequest(BaseModel):
    question: str

@app.post("/ask")
def ask(data: AskRequest):

    question = data.question

    query_embedding = ollama.embeddings(
        model="nomic-embed-text",
        prompt=question
    )["embedding"]

    results = collection.query(
        query_embeddings=[query_embedding],
        n_results=3
    )

    context = "\n".join(results["documents"][0])

    prompt = f"""
    Answer ONLY from the provided context.

    Context:
    {context}

    Question:
    {question}
    """

    response = ollama.chat(
        model="llama3",
        messages=[
            {
                "role": "user",
                "content": prompt
            }
        ]
    )

    return {
        "answer": response["message"]["content"],
        "context": results["documents"][0]
    }