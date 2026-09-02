import uvicorn

from app.config import get_port


if __name__ == "__main__":
    uvicorn.run("app.main:app", host="0.0.0.0", port=get_port(), reload=True)
