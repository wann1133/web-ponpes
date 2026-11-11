import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

window.ponpesFormatBytes = (bytes) => {
    if (bytes < 1024) return `${bytes} B`;
    if (bytes < 1024 * 1024) return `${Math.round(bytes / 1024)} KB`;
    return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
};

window.ponpesCompressImageFile = async (
    file,
    { maxDimension = 1600, quality = 0.84, minSkipSize = 350 * 1024 } = {}
) => {
    if (!file || !file.type || !file.type.startsWith('image/') || typeof createImageBitmap !== 'function') {
        return file;
    }

    try {
        const bitmap = await createImageBitmap(file);
        const largest = Math.max(bitmap.width, bitmap.height);

        if (largest <= maxDimension && file.size <= minSkipSize) {
            if (typeof bitmap.close === 'function') bitmap.close();
            return file;
        }

        const scale = largest > maxDimension ? maxDimension / largest : 1;
        const targetW = Math.max(1, Math.round(bitmap.width * scale));
        const targetH = Math.max(1, Math.round(bitmap.height * scale));

        const canvas = document.createElement('canvas');
        canvas.width = targetW;
        canvas.height = targetH;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, targetW, targetH);
        ctx.drawImage(bitmap, 0, 0, targetW, targetH);

        if (typeof bitmap.close === 'function') bitmap.close();

        const blob = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', quality));
        if (!blob || (blob.size >= file.size && largest <= maxDimension)) {
            return file;
        }

        const cleanBase = file.name.replace(/\.[^.]+$/, '') || 'foto';
        return new File([blob], `${cleanBase}.jpg`, {
            type: 'image/jpeg',
            lastModified: Date.now(),
        });
    } catch (error) {
        return file;
    }
};

Alpine.start();
