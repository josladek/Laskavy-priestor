#!/usr/bin/env python3
"""
Simple Flask app for PHP application wrapper
This satisfies the gunicorn requirement for Replit.
The real application is in the php-version directory.
"""

from flask import Flask

app = Flask(__name__)

@app.route('/')
def index():
    return """
    <h1>Láskavý Priestor</h1>
    <p>PHP aplikácia beží v php-version/ adresári.</p>
    <p>Pre prístup k aplikácii navštívte: <a href="/php-version/">php-version/</a></p>
    """

@app.route('/health')
def health():
    return {'status': 'ok', 'message': 'PHP application running'}

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)