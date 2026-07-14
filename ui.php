:root{
  --bg:#0d1117;
  --card: rgba(22,27,34,0.85);
  --accent:#58a6ff;
  --text:#e6edf3;
  --muted:#8b949e;
  --input-bg: rgba(255,255,255,0.03);
  --border:#30363d;
  --tile-bg: rgba(255,255,255,0.02);
  --tile-active: rgba(88,166,255,0.12);
}
*{box-sizing:border-box}
body{
  margin:0;
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  background:var(--bg);
  color:var(--text);
  font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  padding:32px;
}
.container{
  width:100%;
  max-width:820px;
  background:var(--card);
  border-radius:14px;
  border:1px solid var(--border);
  padding:34px;
  box-shadow:0 10px 40px rgba(0, 255, 26, 0.5);
  backdrop-filter: blur(8px);
}
.header {
  text-align:center;
  margin-bottom:18px;
}
.title{
  color: var(--accent) ;
  font-size:28px;
  font-weight:600;
  margin:0;
  letter-spacing:0.6px;
}
.subtitle{
  color:var(--muted);
  font-size:13px;
  margin-top:6px;
}

/* search row */
.search-row { display:flex; gap:10px; align-items:center; margin-top:18px; }
.search-input {
  flex:1;
  display:flex;
  align-items:center;
  background:var(--input-bg);
  border-radius:999px;
  padding:10px 14px;
  border:1px solid var(--border);
}
.search-input input {
  flex:1;
  background:transparent;
  border:0;
  color:var(--text);
  font-size:16px;
  outline:none;
  padding:6px 8px;
}
.icon-btn {
  background:transparent;
  border:0;
  color:var(--muted);
  font-size:18px;
  padding:6px 8px;
  cursor:pointer;
}

/* tiles */
.tiles {
  display:flex;
  gap:10px;
  flex-wrap:wrap;
  margin-top:16px;
  justify-content:center;
}
.tile {
  min-width:150px;
  max-width:190px;
  background:var(--tile-bg);
  border:1px solid var(--border);
  border-radius:10px;
  padding:10px 12px;
  cursor:pointer;
  display:flex;
  gap:10px;
  align-items:center;
  transition: transform .12s ease, box-shadow .12s ease, background .12s ease;
}
.tile:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0, 255, 26, 0.5); }
.tile .glyph {
  width:44px;
  height:44px;
  border-radius:8px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:20px;
  background: rgba(255,255,255,0.02);
  color:var(--accent);
  border:1px solid rgba(255,255,255,0.03);
}
.tile .meta { flex:1; text-align:left; }
.tile .meta strong { display:block; font-size:14px; color:var(--text); }
.tile .meta small { color:var(--muted); font-size:12px; display:block; margin-top:4px; }

/* active state */
.tile.active {
  background: var(--tile-active);
  border-color: rgba(88,166,255,0.22);
  box-shadow: 0 6px 20px rgba(88,166,255,0.06);
}

/* controls row */
.controls { display:flex; gap:12px; margin-top:18px; align-items:center; flex-wrap:wrap; justify-content:center; }
.controls .form-control { background:var(--input-bg); border:1px solid var(--border); color:var(--text); padding:8px 10px; border-radius:8px; min-width:200px; }

/* action buttons */
.actions { display:flex; gap:12px; justify-content:center; margin-top:18px; }
.btn-primary {
  background:#007bff;
  color:#fff;
  border:0;
  padding:10px 18px;
  border-radius:8px;
  cursor:pointer;
  font-weight:600;
}
.btn-secondary {
  background:transparent;
  color:var(--text);
  border:1px solid var(--border);
  padding:10px 14px;
  border-radius:8px;
  cursor:pointer;
}

/* result */
#result { margin-top:18px; text-align:center; color:var(--accent); word-break:break-all; font-size:14px; }

/* footer */
.footer { margin-top:22px; text-align:center; color:var(--muted); font-size:13px; }

/* responsive tweaks */
@media (max-width:640px){
  .tile { min-width: calc(50% - 12px); }
  .controls .form-control { min-width:140px; }
}
