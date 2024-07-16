import subprocess
import time
from flask import Flask, render_template, request, jsonify, redirect

app = Flask(__name__)

@app.route('/')
def index():
    return render_template('main_app.html')

@app.route('/start_recognition', methods=['POST'])
def start_recognition():
    data = request.get_json()
    app_type = data.get('app_type')

    if app_type == 'pwd':
        subprocess.Popen(['python', 'pwd_recognition_app.py'], shell=True)
        time.sleep(2)  # Give the server time to start
        return jsonify({'redirect_url': 'http://127.0.0.1:5001'})
    elif app_type == 'senior':
        subprocess.Popen(['python', 'senior_recognition_app.py'], shell=True)
        time.sleep(2)  # Give the server time to start
        return jsonify({'redirect_url': 'http://127.0.0.1:5002'})
    elif app_type == 'solo_parent':
        subprocess.Popen(['python', 'sl_recognition_app.py'], shell=True)
        time.sleep(2)  # Give the server time to start
        return jsonify({'redirect_url': 'http://127.0.0.1:5003'})

    return jsonify(success=False), 400

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5004, debug=True)
