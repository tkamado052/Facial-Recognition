from flask import Flask, render_template, request, jsonify, redirect, url_for
import cv2
import numpy as np
import mysql.connector
import base64
import os

app = Flask(__name__)

# Database connection
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="facial-recognition"
)
cursor = db.cursor()

# Face recognition setup
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
recognizer = cv2.face.LBPHFaceRecognizer_create()

# Ensure trainer.yml exists before loading
if os.path.exists('trainer/trainer.yml'):
    recognizer.read('trainer/trainer.yml')
else:
    print("Trainer file not found, please run the training script first.")

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/recognize', methods=['POST'])
def recognize():
    try:
        data = request.get_json()
        if 'image' not in data:
            return jsonify({'error': 'No image uploaded'}), 400

        image = data['image'].split(',')[1]  # Base64 part after the comma
        image_array = np.frombuffer(base64.b64decode(image), dtype=np.uint8)
        frame = cv2.imdecode(image_array, cv2.IMREAD_COLOR)

        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        faces = face_cascade.detectMultiScale(gray, 1.3, 5)

        if len(faces) == 0:
            return jsonify({'message': 'No face detected in image'}), 404

        for (x, y, w, h) in faces:
            id, confidence = recognizer.predict(gray[y:y+h, x:x+w])
            print(f"Detected ID: {id}, Confidence: {confidence}")
            if confidence < 100:
                cursor.execute("SELECT id FROM seniordb WHERE id = %s", (id,))
                user = cursor.fetchone()
                if user:
                    user_id = user[0]
                    return jsonify({'redirect_url': f'http://localhost/facial-Recognition/Facial-Recognition/sl_display_user.php?id={user_id}'})

                else:
                    print(f"No user found with id: {id}")
                    return jsonify({'name': 'Unknown', 'confidence': f"  {round(100 - confidence)}%"})
            else:
                print("Recognition failed with high confidence value.")
                return jsonify({'name': 'Unknown', 'confidence': f"  {round(100 - confidence)}%"})
    except Exception as e:
        print(f"Error during recognition: {e}")
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5001, debug=True)
