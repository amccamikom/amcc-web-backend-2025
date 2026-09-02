import time
from datetime import datetime, timezone

from fastapi import FastAPI

from app.models import MachineMetrics, PredictionResult
from app.predictor import predict_health

app = FastAPI(
    title="AMCC Machine Health ML Service",
    description="Rule-based prediction service for the AMCC Docker Lab.",
    version="1.0.0",
)
started_at = time.monotonic()


@app.get("/")
def read_root() -> dict:
    return {
        "name": "AMCC Machine Health ML Service",
        "endpoints": ["GET /health", "POST /predict"],
    }


@app.get("/health")
def read_health() -> dict:
    return {
        "status": "healthy",
        "timestamp": datetime.now(timezone.utc).isoformat(),
        "uptime": round(time.monotonic() - started_at, 2),
    }


@app.post("/predict", response_model=PredictionResult)
def predict(metrics: MachineMetrics) -> PredictionResult:
    return predict_health(metrics)
