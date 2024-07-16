import cv2
import numpy as np
import base64
import os
from PIL import Image
import io
from flask import Flask, request, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

dataset_path = 'dataset/'
trainer_path = 'trainer/'

if not os.path.exists(dataset_path):
    os.makedirs(dataset_path)

if not os.path.exists(trainer_path):
    os.makedirs(trainer_path)

# Load Haar cascade classifier for face detection
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

@app.route('/capture', methods=['POST'])
def capture():
    try:
        # Extract data from the request body
        data = request.get_json()
        id = data['id']
        image_data = data['image'].split(',')[1]

        # Decode base64 encoded image data
        image = Image.open(io.BytesIO(base64.b64decode(image_data)))
        image = np.array(image)

        # Convert image to grayscale for face detection
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

        # Detect faces using the cascade classifier
        faces = face_cascade.detectMultiScale(gray, 1.3, 5)

        # Generate a unique filename for each captured face
        count = len([name for name in os.listdir(dataset_path) if name.startswith(f"User.{id}.")])
        for (x, y, w, h) in faces:
            count += 1
            face_img = gray[y:y+h, x:x+w]

            # Save detected face as JPEG image
            filename = f"{dataset_path}/User.{id}.{count}.jpg"
            cv2.imwrite(filename, face_img)
            print(f"Saved {filename}")

        # Automatically train the recognizer after capturing the face
        train_recognizer()

        return jsonify(success=True)

    except Exception as e:
        # Handle exceptions gracefully
        print(f"Error capturing face: {str(e)}")
        return jsonify(success=False, error=str(e))

def train_recognizer():
    recognizer = cv2.face.LBPHFaceRecognizer_create()
    detector = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

    def get_images_and_labels(path):
        image_paths = [os.path.join(path, f) for f in os.listdir(path) if not f.endswith('.DS_Store')]
        face_samples = []
        ids = []

        for image_path in image_paths:
            pil_image = Image.open(image_path).convert('L')
            image_np = np.array(pil_image, 'uint8')

            id = int(os.path.split(image_path)[-1].split(".")[1])

            faces = detector.detectMultiScale(image_np)
            
            for (x, y, w, h) in faces:
                face_samples.append(image_np[y:y+h, x:x+w])
                ids.append(id)
        return face_samples, ids

    print("Training faces. It will take a few seconds. Wait ...")
    faces, ids = get_images_and_labels(dataset_path)
    recognizer.train(faces, np.array(ids))

    recognizer.write(f'{trainer_path}/trainer.yml')
    print(f"\n [INFO] {len(np.unique(ids))} faces trained. Exiting Program")

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5000, debug=True)
