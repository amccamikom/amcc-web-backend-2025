import { useEffect, useState } from 'react';
import { analyzeMachine, checkServices } from './services/api.js';

const initialForm = {
  machineName: '',
  temperature: '',
  vibration: '',
  operatingHours: '',
};

function ConnectionStatus({ connection }) {
  const label = {
    checking: 'Checking services…',
    connected: 'All services online',
    degraded: 'ML service unavailable',
    offline: 'Backend offline',
  }[connection];

  return (
    <div className={`connection connection--${connection}`} role="status">
      <span className="connection__dot" aria-hidden="true" />
      {label}
    </div>
  );
}

function ResultCard({ result }) {
  return (
    <section className={`result result--${result.status.toLowerCase()}`} aria-live="polite">
      <div className="result__heading">
        <div>
          <p className="eyebrow">Analysis complete</p>
          <h2>{result.machineName}</h2>
        </div>
        <span className="status-badge">{result.status}</span>
      </div>

      <div className="risk">
        <div className="risk__labels">
          <span>Risk score</span>
          <strong>{result.riskScore}/100</strong>
        </div>
        <div className="risk__track" aria-label={`Risk score ${result.riskScore} out of 100`}>
          <span style={{ width: `${result.riskScore}%` }} />
        </div>
      </div>

      <div className="recommendation">
        <span className="recommendation__icon" aria-hidden="true">↗</span>
        <div>
          <p>Recommended action</p>
          <strong>{result.recommendation}</strong>
        </div>
      </div>

      <p className="timestamp">
        Checked {new Intl.DateTimeFormat('en', { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(result.checkedAt))}
      </p>
    </section>
  );
}

export default function App() {
  const [form, setForm] = useState(initialForm);
  const [connection, setConnection] = useState('checking');
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState('');
  const [result, setResult] = useState(null);

  useEffect(() => {
    let active = true;

    checkServices()
      .then((response) => {
        if (active) setConnection(response.data.mlService.status === 'online' ? 'connected' : 'degraded');
      })
      .catch(() => {
        if (active) setConnection('offline');
      });

    return () => { active = false; };
  }, []);

  function handleChange(event) {
    const { name, value } = event.target;
    setForm((current) => ({ ...current, [name]: value }));
  }

  async function handleSubmit(event) {
    event.preventDefault();
    setIsLoading(true);
    setError('');
    setResult(null);

    try {
      const response = await analyzeMachine({
        machineName: form.machineName.trim(),
        temperature: Number(form.temperature),
        vibration: Number(form.vibration),
        operatingHours: Number(form.operatingHours),
      });
      setResult(response.data);
      setConnection('connected');
    } catch (requestError) {
      setError(requestError.message || 'Could not analyze the machine. Please try again.');
    } finally {
      setIsLoading(false);
    }
  }

  return (
    <main className="page-shell">
      <nav className="topbar" aria-label="Application header">
        <a className="brand" href="#top" aria-label="AMCC Docker Lab home">
          <span className="brand__mark">A</span>
          <span>AMCC <b>/ Docker Lab</b></span>
        </a>
        <ConnectionStatus connection={connection} />
      </nav>

      <div id="top" className="content-grid">
        <section className="intro">
          <p className="eyebrow"><span>Live lab</span> · Multi-service application</p>
          <h1>Know your machine<br />before it <em>stops.</em></h1>
          <p className="intro__copy">
            Enter current operating metrics. The request travels through React, Express,
            and FastAPI to produce an instant health assessment.
          </p>

          <div className="flow" aria-label="Application request flow">
            <div><span>01</span><strong>React</strong><small>Input</small></div>
            <i>→</i>
            <div><span>02</span><strong>Express</strong><small>Validate</small></div>
            <i>→</i>
            <div><span>03</span><strong>FastAPI</strong><small>Predict</small></div>
          </div>
        </section>

        <section className="workspace">
          <form className="form-card" onSubmit={handleSubmit}>
            <div className="form-card__heading">
              <div>
                <p className="eyebrow">New assessment</p>
                <h2>Machine readings</h2>
              </div>
              <span className="form-card__number">01</span>
            </div>

            <label>
              Machine name
              <input
                name="machineName"
                value={form.machineName}
                onChange={handleChange}
                placeholder="e.g. Press Machine A"
                maxLength="80"
                required
              />
            </label>

            <div className="field-row">
              <label>
                Temperature <span>°C</span>
                <input name="temperature" type="number" min="0" max="200" step="0.1" value={form.temperature} onChange={handleChange} placeholder="75" required />
              </label>
              <label>
                Vibration <span>mm/s</span>
                <input name="vibration" type="number" min="0" max="100" step="0.1" value={form.vibration} onChange={handleChange} placeholder="4.2" required />
              </label>
            </div>

            <label>
              Operating hours <span>hours</span>
              <input name="operatingHours" type="number" min="0" max="1000000" step="1" value={form.operatingHours} onChange={handleChange} placeholder="1200" required />
            </label>

            <button type="submit" disabled={isLoading}>
              {isLoading ? <><span className="spinner" /> Analyzing…</> : <>Analyze machine <span>→</span></>}
            </button>
          </form>

          {error && <div className="error-message" role="alert"><strong>Analysis failed.</strong> {error}</div>}
          {result && <ResultCard result={result} />}
        </section>
      </div>

      <footer>
        <span>AMCC WEB BACKEND · INTERMEDIATE LAB</span>
        <span>React / Express / FastAPI</span>
      </footer>
    </main>
  );
}
