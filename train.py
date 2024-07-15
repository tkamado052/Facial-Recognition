import cv2
import numpy as np
import os
from PIL import Image

# Path for face image database
path = 'dataset'

# Create a Local Binary Patterns Histogram face recognizer
recognizer = cv2.face.LBPHFaceRecognizer_create()
# Load Haar cascade classifier for face detection
detector = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

# Function to get the images and label data
def get_images_and_labels(path):
    image_paths = [os.path.join(path, f) for f in os.listdir(path) if not f.endswith('.DS_Store')]
    face_samples = []
    ids = []

    for image_path in image_paths:
        # convert image to grayscale
        pil_image = Image.open(image_path).convert('L')
        image_np = np.array(pil_image, 'uint8')

        # Extract the user ID from the image filename
        id = int(os.path.split(image_path)[-1].split(".")[1])

        # Detect the face in the image
        faces = detector.detectMultiScale(image_np)
        
        # If a face is detected, append it to the training set
        for (x, y, w, h) in faces:
            face_samples.append(image_np[y:y+h, x:x+w])
            ids.append(id)
    return face_samples, ids

print("Training faces. It will take a few seconds. Wait ...")
faces, ids = get_images_and_labels(path)
recognizer.train(faces, np.array(ids))

# Save the model into trainer/trainer.yml
if not os.path.exists('trainer'):
    os.makedirs('trainer')
recognizer.write('trainer/trainer.yml')

# Print the number of faces trained and end program
print(f"\n [INFO] {len(np.unique(ids))} faces trained. Exiting Program")
