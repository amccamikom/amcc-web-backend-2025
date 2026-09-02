import os

from dotenv import load_dotenv


load_dotenv()


def get_port() -> int:
    """Read a valid TCP port from the environment or use the local default."""
    try:
        port = int(os.getenv("PORT", "8000"))
        return port if 1 <= port <= 65535 else 8000
    except ValueError:
        return 8000
