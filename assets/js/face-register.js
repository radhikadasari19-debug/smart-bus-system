const detection = await faceapi
    .detectSingleFace(
        video,
        new faceapi.TinyFaceDetectorOptions()
    )
    .withFaceLandmarks()
    .withFaceDescriptor();

if (detection) {
    const faceDescriptor = Array.from(detection.descriptor);
    console.log(faceDescriptor);
}