import unittest

from app.models import MachineMetrics
from app.predictor import predict_health


class PredictorTests(unittest.TestCase):
    def test_expected_warning_example(self) -> None:
        metrics = MachineMetrics(
            temperature=75,
            vibration=4.2,
            operatingHours=1200,
        )

        result = predict_health(metrics)

        self.assertEqual(result.status, "WARNING")
        self.assertEqual(result.risk_score, 65)

    def test_score_never_exceeds_one_hundred(self) -> None:
        metrics = MachineMetrics(
            temperature=200,
            vibration=100,
            operatingHours=1_000_000,
        )

        result = predict_health(metrics)

        self.assertEqual(result.status, "CRITICAL")
        self.assertEqual(result.risk_score, 100)


if __name__ == "__main__":
    unittest.main()
