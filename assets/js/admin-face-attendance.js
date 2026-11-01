
const video = document.getElementById("video");
const statusText = document.getElementById("status");
const result = document.getElementById("result");
const startBtn = document.getElementById("startBtn");
const stopBtn = document.getElementById("stopBtn");

const MODEL_URL = "../models";

let registeredStudents = [];
let scannerRunning = false;
let stream = null;
let lastMarked = new Set();

async function loadModels() {
    await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
    await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
    await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
}

async function loadRegisteredFaces() {
    const response = await fetch("../api/get_face_data.php");
    const data = await response.json();

    if (!response.ok || !data.success) {
        throw new Error(data.message || "Could not load registered faces.");
    }

    registeredStudents = data.students.map(student => ({
        id: Number(student.id),
        name: student.name,
        descriptor: new Float32Array(student.descriptor)
    }));

    if (registeredStudents.length === 0) {
        throw new Error("No registered student faces found.");
    }
}

async function startCamera() {
    stream = await navigator.mediaDevices.getUserMedia({
        video: { facingMode: "user" },
        audio: false
    });

    video.srcObject = stream;
    await new Promise(resolve => {
        video.onloadedmetadata = resolve;
    });
    await video.play();
}

async function markAttendance(student) {
    if (lastMarked.has(student.id)) return;

    lastMarked.add(student.id);

    try {
        const response = await fetch("../api/mark_attendance.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ student_id: student.id })
        });

        const data = await response.json();

        result.textContent = data.message ||
            (data.success ? "Attendance marked." : "Attendance failed.");

    } catch (error) {
        lastMarked.delete(student.id);
        result.textContent = "Unable to save attendance.";
    }
}

async function scanFaces() {
    while (scannerRunning) {
        if (video.readyState >= 2) {
            const detection = await faceapi
                .detectSingleFace(
                    video,
                    new faceapi.TinyFaceDetectorOptions()
                )
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (detection) {
                let bestMatch = null;
                let bestDistance = 0.48;

                for (const student of registeredStudents) {
                    const distance = faceapi.euclideanDistance(
                        detection.descriptor,
                        student.descriptor
                    );

                    if (distance < bestDistance) {
                        bestDistance = distance;
                        bestMatch = student;
                    }
                }

                if (bestMatch) {
                    statusText.textContent =
                        "Recognized: " + bestMatch.name;

                    await markAttendance(bestMatch);
                } else {
                    statusText.textContent = "Face not recognized.";
                }
            } else {
                statusText.textContent = "Looking for a face...";
            }
        }

        await new Promise(resolve => setTimeout(resolve, 1000));
    }
}

startBtn.addEventListener("click", async () => {
    try {
        startBtn.disabled = true;
        statusText.textContent = "Loading face recognition models...";

        await loadModels();
        await loadRegisteredFaces();
        await startCamera();

        scannerRunning = true;
        stopBtn.disabled = false;
        statusText.textContent = "Attendance scanner running.";

        scanFaces();

    } catch (error) {
        statusText.textContent = error.message;
        startBtn.disabled = false;
        stopCamera();
    }
});

function stopCamera() {
    scannerRunning = false;

    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }

    video.srcObject = null;
    stopBtn.disabled = true;
    startBtn.disabled = false;
}

stopBtn.addEventListener("click", stopCamera);
