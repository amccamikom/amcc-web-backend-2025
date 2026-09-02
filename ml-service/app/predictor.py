from app.models import MachineMetrics, PredictionResult


def _temperature_risk(temperature: float) -> int:
    if temperature <= 50:
        return 5
    if temperature <= 75:
        return 30
    if temperature <= 90:
        return 50
    return 70


def _vibration_risk(vibration: float) -> int:
    if vibration <= 2:
        return 5
    if vibration <= 4:
        return 15
    if vibration <= 7:
        return 25
    return 30


def _operating_hours_risk(operating_hours: float) -> int:
    if operating_hours <= 1_000:
        return 5
    if operating_hours <= 5_000:
        return 10
    if operating_hours <= 10_000:
        return 15
    return 20


def predict_health(metrics: MachineMetrics) -> PredictionResult:
    """Calculate a deterministic, rule-based health assessment."""
    risk_score = min(
        100,
        _temperature_risk(metrics.temperature)
        + _vibration_risk(metrics.vibration)
        + _operating_hours_risk(metrics.operating_hours),
    )

    if risk_score >= 75:
        return PredictionResult(
            status="CRITICAL",
            riskScore=risk_score,
            recommendation="Stop the machine safely and inspect it immediately.",
        )

    if risk_score >= 40:
        return PredictionResult(
            status="WARNING",
            riskScore=risk_score,
            recommendation="Schedule an inspection within 24 hours.",
        )

    return PredictionResult(
        status="NORMAL",
        riskScore=risk_score,
        recommendation="Continue normal operation and routine monitoring.",
    )
