from pydantic import BaseModel, ConfigDict, Field


class MachineMetrics(BaseModel):
    model_config = ConfigDict(populate_by_name=True)

    temperature: float = Field(ge=0, le=200, description="Temperature in degrees Celsius")
    vibration: float = Field(ge=0, le=100, description="Vibration in millimetres per second")
    operating_hours: float = Field(
        alias="operatingHours",
        ge=0,
        le=1_000_000,
        description="Total machine operating hours",
    )


class PredictionResult(BaseModel):
    model_config = ConfigDict(populate_by_name=True)

    status: str
    risk_score: int = Field(alias="riskScore", ge=0, le=100)
    recommendation: str
